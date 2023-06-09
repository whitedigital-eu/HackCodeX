<script setup lang="ts">
import {useSurvey} from "../stores/survey";

const survey = useSurvey();

import Card from "../components/survey/Card.vue";
import type {Choice} from "../interfaces/survey/Choice";
import {SurveyState} from "../mixins/Survey";
import SliderQuiz from "../components/survey/SliderQuiz.vue";
import Statistic from "../components/survey/Statistic.vue";
import Summary from "../components/survey/Summary.vue";
import {computed, onMounted, ref} from "vue";

const loadedQuiz = ref(false);

const cardSelected = (choice: Choice) => {
  survey.getSurvey().addChoice(choice)
}

const nextStep = (step: SurveyState) => {
  survey.getSurvey().state = step;
}

onMounted(async () => {
  await survey.getSurvey().loadQuizQuestions();
  loadedQuiz.value = true;
})
</script>

<template>
  <main>
    <div v-if="survey.getSurvey().state === SurveyState.PICTURE_QUIZ" class="containerg">
      <template v-if="loadedQuiz">
        <Card v-for="(choice, index) in survey.getSurvey().getCurrentPictureQuizQuestion()?.choices"
              :image="choice.image"
              :class="{'second': index === 1}"
              @cardSelected="cardSelected(choice)"
        />
      </template>
      <template v-else>
        Loading quiz
      </template>
    </div>
    <div v-else-if="survey.getSurvey().state === SurveyState.SLIDER_QUIZ">
      <SliderQuiz :survey="survey.getSurvey()" @nextStep="nextStep" />
    </div>
    <div v-else-if="survey.getSurvey().state === SurveyState.STATISTIC">
      <Statistic @nextStep="nextStep"  />
    </div>
    <div v-else-if="survey.getSurvey().state === SurveyState.SUMMARY">
      <Summary />
    </div>
  </main>
</template>

<style lang="scss" scoped>
.containerg {
  display: flex;
  flex-wrap: nowrap;
  height: calc(100vh - 75px);
  flex-direction: column;

  @media (min-width: 768px) {
    flex-direction: row;
  }
}
</style>
