<script setup lang="ts">

import {Survey, SurveyState} from "../../mixins/Survey";
import Graph2 from "./Graph2.vue";
import {useSurvey} from "../../stores/survey";
import {t} from "../../assets/data/language";

const survey = useSurvey();

const emit = defineEmits(["nextStep"])


const options = {
  chart: {
    toolbar: {
      show: false,
    },
    type: 'radar',
  },
  xaxis: {
    categories: Object.keys(survey.getSurvey().attribute_summary).slice(0, 12).map((name) => {return t(name)}),
  },
  // Additional configuration options for the chart
  // For example, title, labels, tooltip, etc.
};

const series = [
  {
    name: 'Series 1',
    data: Object.keys(survey.getSurvey().attribute_summary).slice(0, 12).map((name) => {return survey.getSurvey().attribute_summary[name]}),
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
      <button @click="emit('nextStep', SurveyState.SUMMARY)" class="btng">
        Nākamais solis
      </button>
    </div>
  </div>
</template>

<style scoped lang="scss">
.statistic {

  .graphs {
    display: flex;
    max-width: 1200px;
    margin: 50px auto;
    gap: 5%;
    flex-direction: column;


    @media (min-width: 768px) {
      flex-direction: row;
    }

    .graph-block {
      flex: 1 1 100%;
      text-align: center;
      padding: 0 20px;
      display: flex;
      justify-content: center;

      &:last-child {
        display: flex;
        flex-wrap: nowrap;
        align-content: space-around;
        flex-direction: column;
        justify-content: space-around;
      }
    }
  }

  .finish {
    margin: 0 auto 50px;
    max-width: 400px;
    text-align: center;
  }
}
</style>