<script setup lang="ts">

import {ref, watch} from "vue";
import {useSurvey} from "../../stores/survey";
import {t} from "../../assets/data/language";

const survey = useSurvey();

const props = defineProps({
  subject: String
})

let current_number= ref(survey.getSurvey().subjects[<string>props.subject]);

watch(current_number, () => {
  survey.getSurvey().setSubjectValue(<string>props.subject, current_number.value);
})
</script>

<template>
  <div class="slider-bar">
    <div>{{ t(subject) }}</div>
    <div class="slider-box">
      <div class="first">1</div>
      <div v-if="current_number != 1 && current_number != 10" class="current" :style="`left: ${(current_number * 10) - 7}%`">{{ current_number }}</div>
      <div class="last">10</div>
      <input type="range" min="1" max="10" v-model="current_number" class="slider">
    </div>
  </div>
</template>

<style scoped lang="scss">
  .slider-bar {
    max-width: 600px;
    margin: 20px auto;
    padding: 0 20px;
    display: flex;

    .slider-box {
      position: relative;

      .first {
        position: absolute;
        left: 0;
      }

      .last {
        position: absolute;
        right: 0;
      }

      .current {
        position: absolute;
        color: var(--secondary);
      }
    }

    div {
      flex: 0 0 50%;
      display: flex;
      align-content: flex-end;
      flex-wrap: wrap;

      &:last-child {
        text-align: right;

        input {
          padding-top: 30px;
          width: 100%;
        }

        input[type=range] {
          width: 100%;
          margin: 5.85px 0;
          background-color: transparent;
          -webkit-appearance: none;
        }
        input[type=range]:focus {
          outline: none;
        }
        input[type=range]::-webkit-slider-runnable-track {
          background: #E0E0E0;
          border-radius: 1px;
          width: 100%;
          height: 5px;
          cursor: pointer;
        }
        input[type=range]::-webkit-slider-thumb {
          margin-top: -9.95px;
          width: 23px;
          height: 23px;
          background: #2E65F3;
          border-radius: 12px;
          cursor: pointer;
          -webkit-appearance: none;
        }
        input[type=range]:focus::-webkit-slider-runnable-track {
          background: #E0E0E0;
        }
        input[type=range]::-moz-range-track {
          background: #E0E0E0;
          border-radius: 1px;
          width: 100%;
          height: 11.3px;
          cursor: pointer;
        }
        input[type=range]::-moz-range-thumb {
          width: 23px;
          height: 23px;
          background: #2E65F3;
          border-radius: 12px;
          cursor: pointer;
        }
        input[type=range]::-ms-track {
          background: transparent;
          border-color: transparent;
          border-width: 8.45px 0;
          color: transparent;
          width: 100%;
          height: 11.3px;
          cursor: pointer;
        }
        /*TODO: Use one of the selectors from https://stackoverflow.com/a/20541859/7077589 and figure out
        how to remove the virtical space around the range input in IE*/
        @supports (-ms-ime-align:auto) {
          /* Pre-Chromium Edge only styles, selector taken from hhttps://stackoverflow.com/a/32202953/7077589 */
          input[type=range] {
            margin: 0;
            /*Edge starts the margin from the thumb, not the track as other browsers do*/
          }
        }

      }
    }
  }
</style>