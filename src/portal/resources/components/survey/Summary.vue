<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {useSurvey} from "../../stores/survey";
import Donut from "./Donut.vue";
import SchoolDetailPopup from "./SchoolDetailPopup.vue";
import Loading from "../other/Loading.vue";
import {shuffleArray} from "../../assets/data/quetions";
import IconOccupation from "../icons/IconOccupation.vue";
import IconUniersity from "../icons/IconUniersity.vue";

const survey = useSurvey();
const schools = ref(null);
const potentials = ref([]);

const colorSet = [
  ['#00C6FF', '#0072FF'],
  ['#A52A2A', '#8B4513'],
  ['#00B09B', '#96C93D'],
  ['#CC2B5E', '#753A88'],
  ['#000428', '#004E92'],
  ['#02AAB0', '#00CDAC'],
  ['#4B79A1', '#283E51'],
  ['#FF7E5F', '#FEB47B'],
];

const types = {
  'SECONDARY': '6.-9.',
  'HIGHSCOOL': '10.-12.',
}

const submitResults = async () => {
  return await axios({
    method: 'post',
    url: '/api/submissions',
    data: {
      type: "FORM_6TH",
      ...survey.getSurvey().attribute_summary,
      ...survey.getSurvey().subjects,
    }
  });
}

const getSchools = async (id) => {
  return await axios({
    method: 'get',
    url: `/api/submission_results?page=1&itemsPerPage=8&exists[form]=true&groups[]=form:read&order[result]=desc&groups[]=school:read&submission.id=${id}`,
  });
}

const getOccupations = async (id) => {
  return await axios({
    method: 'get',
    url: `/api/submission_results?page=1&itemsPerPage=5&exists[occupation]=true&order[result]=desc&groups[]=occupation:read&submission.id=${id}`,
  });
}

const getUniversity = async (id) => {
  return await axios({
    method: 'get',
    url: `/api/submission_results?page=1&itemsPerPage=4&exists[universityProgram]=true&order[result]=desc&groups[]=university_program:read&submission.id=${id}`,
  });
}

onMounted(async () => {
  const submittedResults = await submitResults();
  const resultId = submittedResults.data.id;
  const schoolsResult = await getSchools(resultId);
  const occupationResult = await getOccupations(resultId);
  const universityResult = await getUniversity(resultId);

  occupationResult.data.forEach((item) => {
    potentials.value.push({
      type: 'occupation',
      title: item.occupation.title
    })
  })

  universityResult.data.forEach((item) => {
    potentials.value.push({
      type: 'university',
      title: item.universityProgram.title
    })
  })

  potentials.value = shuffleArray(potentials.value);

  schools.value = schoolsResult.data;
})

const popup = ref(null);
</script>

<template>
  <school-detail-popup ref="popup" />
  <div class="summary">
    <h1>Nākamais solis zinībās</h1>
    <div class="schools">
      <template v-for="(school, index) in schools">
        <div v-if="index === 4" class="school picmid">
          <svg width="124" height="124" viewBox="0 0 124 124" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M28.2331 79.8999C33.0778 75.0552 39.6486 72.3335 46.5 72.3335H77.5C84.3514 72.3335 90.9222 75.0552 95.7669 79.8999C100.612 84.7446 103.333 91.3154 103.333 98.1668V108.5C103.333 111.354 101.02 113.667 98.1667 113.667C95.3132 113.667 93 111.354 93 108.5V98.1668C93 94.056 91.367 90.1135 88.4602 87.2067C85.5534 84.2999 81.6109 82.6668 77.5 82.6668H46.5C42.3892 82.6668 38.4467 84.2999 35.5399 87.2067C32.633 90.1135 31 94.056 31 98.1668V108.5C31 111.354 28.6868 113.667 25.8334 113.667C22.9799 113.667 20.6667 111.354 20.6667 108.5V98.1668C20.6667 91.3154 23.3884 84.7446 28.2331 79.8999Z" fill="black"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M62 20.6668C53.4396 20.6668 46.5 27.6064 46.5 36.1668C46.5 44.7272 53.4396 51.6668 62 51.6668C70.5604 51.6668 77.5 44.7272 77.5 36.1668C77.5 27.6064 70.5604 20.6668 62 20.6668ZM36.1667 36.1668C36.1667 21.8995 47.7327 10.3335 62 10.3335C76.2674 10.3335 87.8334 21.8995 87.8334 36.1668C87.8334 50.4342 76.2674 62.0002 62 62.0002C47.7327 62.0002 36.1667 50.4342 36.1667 36.1668Z" fill="black"/>
          </svg>
        </div>
        <div class="school">
          <div class="inner-school" @click="popup.loadSchool(school.form.school.id, school.result, `${ types[school.form.type] } ${ school.form.formLetter.toUpperCase() } klase`)">
            <div class="percent" :style="`background: linear-gradient(109.38deg, ${colorSet[index][0]} 3.46%, ${colorSet[index][1]} 95.43%);`">
              <Donut class="donut" :percent="school.result" />
              {{ school.result }}%
            </div>
            <div class="info">
              <h2>{{ types[school.form.type] }} {{ school.form.formLetter.toUpperCase() }} klase</h2>
              <span class="school-name">{{ school.form.school.title }}</span>
            </div>
          </div>
        </div>
      </template>
      <Loading v-if="!schools" />
    </div>
  </div>
  <div class="carrier" v-if="schools" >
    <h1>Karjeras iespējas</h1>
    <div class="description">
      Bieži vien, pabeidzot šo skolu, cilvēki iet šādas tālākās gaitas
    </div>
    <div class="grid gap-x-8 gap-y-4 grid-cols-3 carrier-list">
      <div class="carrier-entity flex flex-row flex-nowrap" v-for="item in potentials" >
        <div class="basis-3/12 items-center flex justify-center" :class="item.type">
          <IconOccupation v-if="item.type === 'occupation'" />
          <IconUniersity v-if="item.type === 'university'"/>
        </div>
        <span class="text-title flex basis-9/12 items-center p-2">
          <span>{{ item.title }}</span>
        </span>
      </div>
    </div>

  </div>
</template>

<style scoped lang="scss">
.summary {
  .schools {
    display: flex;
    flex-direction: row;
    margin-top: 40px;
    flex-wrap: wrap;
    justify-content: space-around;

    .school {
      flex: 1 1 100%;
      display: flex;
      justify-content: center;

      &:hover {
        .inner-school {
          cursor: pointer;
          box-shadow: 2px 2px 10px 0 rgba(0, 0, 0, 0.18);
        }
      }

      &:nth-child(even) {
        &:hover {
          .inner-school {
            transform: rotate(1deg) scale(1.05);
          }
        }
      }

      &:nth-child(odd) {
        &:hover {
          .inner-school {
            transform: rotate(-1deg) scale(1.05);
          }
        }
      }


      .inner-school {
        flex: 0 1 100%;
        margin: 10px;
        background: #F7F7F9;
        border-radius: 15px;
        overflow: hidden;
        display: flex;
        flex-wrap: nowrap;
        flex-direction: row;
        justify-content: flex-start;
        transition: 100ms ease-in-out;

        .percent {
          display: flex;
          align-items: center;
          font-style: normal;
          font-weight: 700;
          font-size: 32px;
          line-height: 32px;
          color: #ffffff;
          padding: 0 10px;

          .donut {
            height: 40px;
            margin-right: 10px;
          }
        }
    }

      @media (min-width: 868px) {
        flex: 1 1 50%;
      }

      @media (min-width: 1000px) {
        flex: none;
        margin: 40px 20px;

        .inner-school {
          flex: 0 1 auto;
        }

        &:nth-child(1),&:nth-child(9), {
          flex: 0 0 100%;
        }

        &:nth-child(4),&:nth-child(6), {
          flex: 1 0 30%;
        }

        &:nth-child(2),&:nth-child(3),
        &:nth-child(7),&:nth-child(8),{
          flex: 0 0 40%;
        }
      }

      .info {
        display: flex;
        padding: 10px;
        flex-direction: column;
        flex-wrap: nowrap;

        h2 {
          display: block;
          margin: 0;
          padding: 0;
          font-size: 24px;
          font-weight: bold;
        }

        .school-name {
          display: block;
        }
      }
    }

    .picmid {
      display: none;
    }

    @media (min-width: 1000px) {
      .picmid {
        display: block;
        flex: 1 1 10%;
        svg {
          position: absolute;
          margin-top: -10px;
          left: calc(50% - 62px);
        }
      }
    }
  }
}

.carrier {
  background: #F7F7F9;
  padding: 60px 20px;

  .carrier-list {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 0;

    .carrier-entity {
      border-radius: 15px;
      background: #ffffff;
      overflow: hidden;

      svg {
        height: 40px;
        width: 40px;
      }

      .text-title {
        height: 100%;
        overflow: hidden;

        span {
          text-overflow: ellipsis;
          white-space: nowrap;
          overflow: hidden;
          width: 100%;

          font-size: 14px;
          font-weight: 700;
          line-height: 20px;

        }
      }

      .university, .occupation {
        width: 82px;
        height: 100%;
        min-height: 74px;
      }

      .university {
        background: linear-gradient(90deg, #00C6FF 0%, #0072FF 100%);
      }

      .occupation {
        background: linear-gradient(90deg, #00B09B 0%, #96C93D 100%);
      }

    }
  }
}
</style>