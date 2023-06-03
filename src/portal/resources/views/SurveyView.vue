<script setup lang="ts">
import {useSurvey} from "../stores/survey";

const survey = useSurvey();

import Card from "../components/survey/Card.vue";
import type {Choice} from "../interfaces/survey/Choice";

const cardSelected = (choice: Choice) => {
  survey.getSurvey().addChoice(choice)
}
</script>

<template>
  <main>
    {{ survey.getSurvey().attribute_summary }}
    <div class="chooser">
      <Card v-for="(choice, index) in survey.getSurvey().getCurrentPictureQuizQuestion().choices"
            :image="choice.image"
            :class="{'second': index === 1}"
            @cardSelected="cardSelected(choice)"
      />
    </div>
  </main>
</template>

<style lang="scss" scoped>
.chooser {
  display: flex;
  flex-wrap: nowrap;
  height: calc(100vh - 75px);
  flex-direction: column;

  @media (min-width: 768px) {
    flex-direction: row;
  }
}
</style>
