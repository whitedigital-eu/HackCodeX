<script setup lang="ts">
import {onMounted} from "vue";
import axios from "axios";
import {useSurvey} from "../../stores/survey";

const survey = useSurvey();
const loading = true;

const result = async () => {
  const res = await axios({
    method: 'post',
    url: '/api/submissions',
    data: {
      type: "FORM_6TH",
      ...survey.getSurvey().attribute_summary,
      ...survey.getSurvey().subjects,
    }
  });

  return res;
}

onMounted(async () => {
  await result();
  this.loading = false;
  console.log('mounted')
})
</script>

<template>
  <div class="summary">
    <h1>Nākamais solis zinībās</h1>
    <div class="description">
      Lorem ipsum dolor sit amet consectetur. Tortor viverra dignissim porttitor lectus lacus duis urna. Orci id feugiat quisque eu turpis.
    </div>
  </div>
</template>

<style scoped lang="scss">
.summary {

}
</style>