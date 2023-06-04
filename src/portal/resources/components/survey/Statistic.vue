<script setup lang="ts">

import {Survey, SurveyState} from "../../mixins/Survey";
import Graph2 from "./Graph2.vue";
import {useSurvey} from "../../stores/survey";

const survey = useSurvey();

const emit = defineEmits(["nextStep"])


const options = {
  chart: {
    width: 500,
    type: 'radar',
  },
  xaxis: {
    categories: Object.keys(survey.getSurvey().attribute_summary).slice(0, 12),
  },
  // Additional configuration options for the chart
  // For example, title, labels, tooltip, etc.
};

const series = [
  {
    name: 'Series 1',
    data: [80, 50, 30, 40, 100, 20, 40, 100, 20, 40, 100, 20],
  },
];

const antonymList = [
    ['tangible', 'intangible'],
    ['relationships', 'identity'],
    ['retention', 'discovery'],
    ['others', 'self'],
    ['safety', 'confidence'],
    ['concord', 'control'],
]
</script>

<template>
  <div class="statistic">
    <h1>Tava statistika</h1>
    <div class="description">
      Lorem ipsum dolor sit amet consectetur. Tortor viverra dignissim porttitor lectus lacus duis urna. Orci id feugiat quisque eu turpis.
    </div>
    <div class="graphs">
      <div class="graph-block">
        <apexchart width="500" type="radar" :options="options" :series="series"></apexchart>
      </div>
      <div class="graph-block">
        <Graph2 v-for="antonyms in antonymList" :antonyms="antonyms" />
      </div>
    </div>

    <div class="finish">
      <button @click="emit('nextStep', SurveyState.SUMMARY)" class="btn">
        Nākamais solis
      </button>
    </div>
  </div>
</template>

<style scoped lang="scss">
.statistic {
  h1 {
    font-size: 64px;
    font-weight: 700;
    line-height: 80px;
    text-align: center;
    width: 100%;
  }

  .description {
    font-size: 16px;
    font-weight: 400;
    line-height: 24px;
    text-align: center;
    margin: 0 auto;
    max-width: 500px;
    padding: 0 20px;

  }

  .graphs {
    display: flex;
    max-width: 1200px;
    margin: 50px auto;
    gap: 5%;

    .graph-block {
      flex: 1 1 100%;
      text-align: center;
    }
  }

  .finish {
    margin: 0 auto 50px;
    max-width: 400px;
    text-align: center;
  }
}
</style>