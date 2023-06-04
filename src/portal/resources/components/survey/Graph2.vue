<script setup lang="ts">
import {useSurvey} from "../../stores/survey";
import {t} from "../../assets/data/language";

const survey = useSurvey();

const props = defineProps<{
  antonyms: string
}>()
</script>

<template>
  <div class="glist">
    <div>{{ t(antonyms[0]) }}</div>
    <div>{{ survey.getSurvey().attribute_summary[antonyms[0]] }}%</div>
    <div>{{ survey.getSurvey().attribute_summary[antonyms[1]] }}%</div>
    <div>{{ t(antonyms[1]) }}</div>
  </div>
</template>

<style scoped lang="scss">
.glist {
  display: flex;

  div {
    flex: 0 0 20%;

    &:first-child {
      text-align: left;
      flex: 0 0 30%;
    }

    &:last-child {
      text-align: right;
      flex: 0 0 30%;
    }
  }
}
</style>