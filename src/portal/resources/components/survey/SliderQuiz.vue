<script setup lang="ts">

import {Survey, SurveyState} from "../../mixins/Survey";
import SubjectProperty from "./SubjectPropery.vue";

const emit = defineEmits(["nextStep"])

const props = defineProps({
  survey: Survey
})
</script>

<template>
  <div class="slider-quiz">
    <h1>Pievieno atbildes</h1>
    <div class="description">
      Lorem ipsum dolor sit amet consectetur. Tortor viverra dignissim porttitor lectus lacus duis urna. Orci id feugiat quisque eu turpis.
    </div>
    <div class="subjects">
      <SubjectProperty v-for="subject in Object.keys(survey?.subjects)" :survey="survey" :subject="subject" />
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
  }
</style>