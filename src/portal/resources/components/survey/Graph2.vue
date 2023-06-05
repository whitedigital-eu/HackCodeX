<script setup lang="ts">
import {useSurvey} from "../../stores/survey";
import {t} from "../../assets/data/language";

const survey = useSurvey();

const getPercent = (index) => {
  if (index === 0) {
    return (survey.getSurvey().attribute_summary[props.antonyms[0]] - survey.getSurvey().attribute_summary[props.antonyms[1]]) > 0 ?
        (survey.getSurvey().attribute_summary[props.antonyms[0]] - survey.getSurvey().attribute_summary[props.antonyms[1]]) : 0
  }

  return (survey.getSurvey().attribute_summary[props.antonyms[1]] - survey.getSurvey().attribute_summary[props.antonyms[0]]) > 0 ?
      (survey.getSurvey().attribute_summary[props.antonyms[1]] - survey.getSurvey().attribute_summary[props.antonyms[0]]) : 0
}

const props = defineProps<{
  antonyms: string
}>()
</script>

<template>
  <div class="glist flex flex-nowrap">
    <div class="basis-3/12 text-left">{{ t(antonyms[0]) }}</div>
    <div class="basis-3/12 text-right">
      <div class="bar" v-if="getPercent(0) > 0" :style="`width:${30+getPercent(0)}px`">
        {{  getPercent(0) }}%
      </div>
    </div>
    <div class="basis-3/12 text-left">
      <div class="bar t2" v-if="getPercent(1) > 0" :style="`width:${30+getPercent(1)}px`">
        {{  getPercent(1) }}%
      </div>
    </div>
    <div class="basis-3/12 text-right">{{ t(antonyms[1]) }}</div>
  </div>
</template>

<style scoped lang="scss">
.glist {
  display: flex;
  position: relative;

  .bar {
    background: var(--primary);
    display: inline-block;
    border-top-left-radius :10px;
    border-bottom-left-radius :10px;
    padding: 0 5px;
    color: #FFFFFF;

    &.t2 {
      border-top-left-radius: 0;
      border-bottom-left-radius: 0;
      border-top-right-radius: 10px;
      border-bottom-right-radius: 10px;
    }
  }
}
</style>