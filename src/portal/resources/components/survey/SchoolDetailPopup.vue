<script setup lang="ts">
import {ref} from "vue";
import Donut from "./Donut.vue";
import RatingSliderStatic from "./RatingSliderStatic.vue";
import axios from "axios";
import {t} from "../../assets/data/language";
import Loading from "../other/Loading.vue";

let openPopUp = ref(false);
let loaded = ref(false);
let subjectInfo: any = ref(null);
let schoolInfo: any = ref(null);
let percent: any = ref(0);
let title: any = ref('');
const loadSchool = async (id: number, p: number, t: string) => {
  openPopUp.value = true;
  percent.value = p
  title.value = t
  schoolInfo.value = await getSchoolInfo(id, p, t);
  subjectInfo.value = await getSubjectInfo(id)
  loaded.value = true;
  console.log(subjectInfo)
}

const getSchoolInfo = async (id, percent, title) => {
  return (await axios({
    method: 'get',
    url: `/api/schools/${id}?groups[]=transport:read`,
  })).data;
}

const getSubjectInfo = async (id) => {
  return (await axios({
    method: 'get',
    url: `/api/summary/${id}`,
  })).data;
}

defineExpose({
  loadSchool
});
</script>

<template>
  <div class="bg" v-if="openPopUp"></div>
  <div class="popup-open" v-if="openPopUp">
    <div class="header"><a href="javascript:;" @click.prevent="openPopUp = !openPopUp">&lt; Aizvert</a></div>
    <div class="content" v-if="loaded">

      <div class="flex flex-row flex-wrap">
        <div class="basis-8/12 p-3">
          <h2>Informācija par skolu</h2>
          <div class="descriptiong mb-6">
            Bieži vien, pabeidzot kādu no iepriekš minētajām skolām, cilvēki iet šādas tālākās gaitas
          </div>
          <div class="hc-card compatibility mb-6">
            <div class="percent">
              <Donut class="donut mr-3" :percent="percent" />
              {{ percent }}%
            </div>
            Atbilstība Tev:
          </div>

          <div class="hc-card mb-6 info-box">
            <div class="flex flex-row flex-wrap mb-8 mt-8">
              <div class="basis-7/12">
                <span class="label">Adrese</span><br>
                <span class="text">{{ schoolInfo.address }}</span>
              </div>
              <div class="basis-5/12">
                <span class="label">Pieejamie sabiedriskie transporti</span><br>
                <span class="text">
                  <span v-for="tr in schoolInfo.transports" :class="tr.type">{{ tr.number }}</span>
                </span>
              </div>
            </div>

            <div class="flex flex-row flex-wrap mb-8">
              <div class="basis-3/12">
                <span class="label">Skolēnu skaits</span><br>
                <span class="text">2344</span>
              </div>
              <div class="basis-3/12">
                <span class="label">Paralēlklašu skaits</span><br>
                <span class="text">4</span>
              </div>
              <div class="basis-3/12">
                <span class="label">Vidējais skolēnu skaits klasē</span><br>
                <span class="text">28</span>
              </div>
            </div>

            <div class="flex flex-row flex-wrap mb-8">
              <div class="basis-12/12">
                <span class="label">Pieejamās ārpus skolas aktivitātes</span><br>
                <span class="text">
                  <span v-for="ac in schoolInfo.extraCurricularActivities" class="bordered">{{ ac }}</span>
                </span>
              </div>
            </div>
          </div>

        </div>
        <div class="basis-4/12 p-3">
          <div class="hc-card mb-6 school-title">
            <h2>{{ title }}</h2>
            <span class="school-name">{{ schoolInfo.title }}</span>
          </div>
          <div class="hc-card ratings">
            <span class="rating-title">Novērtējums</span>
            <div class="rating-list" v-if="subjectInfo">
              <template v-for="name in Object.keys(subjectInfo)">
                <div class="flex flex-row flex-wrap items-center">
                  <div class="basis-7/12 p-3">
                    <RatingSliderStatic :rating="subjectInfo[name]" />
                  </div>
                  <div class="basis-5/12 p-3">
                    {{ t(name) }}
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Loading v-else />
  </div>
</template>

<style scoped lang="scss">
  .bg {
    position: fixed;
    background: rgba(0, 0, 0, 0.25);
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
  }

  .popup-open {
    position: fixed;
    top: 3%;
    min-height: 300px;
    background: #F7F7F9;
    width: 94%;
    left: 3%;
    border-radius: 20px;
    padding: 30px;
    color: black;
    z-index: 3;

    a {
      color: black;
    }

    h2 {
      font-size: 48px;
      font-weight: 700;
      line-height: 48px;
    }

    .descriptiong {
      font-style: normal;
      font-weight: 400;
      font-size: 16px;
      line-height: 24px;
      text-align: left;
      width: 100%;
    }

    .compatibility {
      background: linear-gradient(109.38deg, #B42EF3 3.46%, #5921D0 95.43%);
      padding: 30px 20px;

      font-size: 32px;
      font-weight: 700;
      line-height: 32px;
      color: #FFFFFF;
      position: relative;


      .percent {
        display: flex;
        align-items: center;
        font-style: normal;
        font-weight: 700;
        font-size: 32px;
        line-height: 32px;
        color: #ffffff;
        padding: 0 10px;
        height: 40px;
        position: absolute;
        right: 0;
      }
    }

    .school-title {
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

    .info-box {
      .label {
        font-size: 16px;
        font-weight: 400;
        line-height: 24px;
      }
      .text {
        font-size: 24px;
        font-weight: 600;
        line-height: 24px;

        .bordered {
          border: 1px solid gray;
          font-size: 12px;
          font-weight: 600;
          line-height: 20px;
          padding: 2px 12px;
          display: inline-block;
          margin: 0 5px 0 0;
          border-radius: 10px;
        }
      }
    }

    .BUS, .TRAM, .TROL {
      font-size: 12px;
      font-weight: 500;
      line-height: 12px;
      text-align: center;

      background: gray;
      color: white;

      margin: 5px 2px;
      display: inline-block;
      padding: 5px;
      border-radius: 5px;
    }

    .BUS {
      background: #DF8A27;
    }

    .TRAM {
      background: #DF2727;
    }

    .TROL {
      background: #277CDF;
    }
  }
</style>