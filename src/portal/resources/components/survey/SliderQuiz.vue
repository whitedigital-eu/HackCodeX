<script setup lang="ts">

import {Survey, SurveyState} from "../../mixins/Survey";
import {Sortable} from "sortablejs-vue3";
import {t} from "../../assets/data/language";
import {onMounted, ref} from "vue";

const emit = defineEmits(["nextStep"])

const props = defineProps<{
  survey: Survey
}>()

let sortList = ref([])

onMounted( () => {
  let i = 0;
  sortList.value = Object.keys(props.survey.subjects).map((s) => {
    return {
      id: i++,
      name: s
    }
  });
  updateSort();
})

const onSortEnd = (event) => {
  const { newIndex, oldIndex } = event;
  const movedItem = sortList.value.splice(oldIndex, 1)[0];
  sortList.value.splice(newIndex, 0, movedItem);
  updateSort();
};

const updateSort= () => {
  sortList.value.forEach((item, index) => {
    props.survey.subjects[item.name] = sortList.value.length - index - 1;
  });
}

</script>

<template>
  <div class="slider-quiz">
    <h1>Novērtē priekšmetu svarīgumu</h1>
    <div class="subjects">
      <Sortable
          :list="sortList"
          item-key="id"
          tag="div"
          @end="onSortEnd"
      >
        <template #item="{element, index}">
          <div class="draggable flex flex-nowrap my-2" :key="element">
            <div class="sort-score items-center flex justify-center">{{ sortList.length - index }}</div>
            <div class="sort-subject items-center flex">{{ t(element.name) }}</div>
          </div>
        </template>
      </Sortable>

<!--      <SubjectProperty v-for="subject in Object.keys(survey?.subjects)" :survey="survey" :subject="subject" />-->
    </div>

    <div class="finish">
      <button @click="emit('nextStep', SurveyState.STATISTIC)" class="btng">
        Nākamais solis
      </button>
    </div>
  </div>
</template>

<style scoped lang="scss">
  .slider-quiz {

    .finish {
      margin: 0 auto 50px;
      max-width: 400px;
      text-align: center;
    }

    .subjects {
      max-width: 600px;
      margin: 0 auto;
    }

    .sort-subject {
      border-radius: 10px;
      height: 48px;
      background: #F7F7F9;
      width: 100%;
      padding: 0 20px;
      cursor: grab;
    }

    .sort-score {
      cursor: grab;
      border-radius: 10px;
      height: 48px;
      width: 48px;
      color: #FFFFFF;
      margin-right: 20px;
      background: linear-gradient(109.38deg, #B42EF3 3.46%, #5921D0 95.43%);
    }
  }
</style>