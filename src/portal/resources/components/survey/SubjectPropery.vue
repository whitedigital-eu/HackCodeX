<script setup lang="ts">
import {Survey} from "../../mixins/Survey";

const props = defineProps({
  subject: String
})
</script>

<template>
  <div class="slider-bar">
    <div>{{ subject }}</div>
    <div>
      <input type="range" min="1" max="10" value="4" class="slider" id="myRange">
    </div>
  </div>
</template>

<style scoped lang="scss">
  .slider-bar {
    max-width: 600px;
    margin: 20px auto;
    padding: 0 20px;
    display: flex;

    div {
      flex: 0 0 50%;

      &:last-child {
        text-align: right;

        input {
          width: 100%;
        }
      }
    }
  }
</style>