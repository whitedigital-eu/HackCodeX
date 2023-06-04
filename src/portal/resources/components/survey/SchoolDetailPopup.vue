<script setup lang="ts">
import {ref} from "vue";
import Donut from "./Donut.vue";
import RatingSliderStatic from "./RatingSliderStatic.vue";
import axios from "axios";

let openPopUp = ref(false);
const loadSchool = (id: number) => {
  openPopUp.value = true;

}

const getInfo = async (id) => {
  return await axios({
    method: 'get',
    url: `/api/submission_results?page=1&itemsPerPage=8&exists[form]=true&groups[]=form:read&order[result]=desc&groups[]=school:read&submission.id=${id}`,
  });
}

defineExpose({
  loadSchool
});
</script>

<template>
  <div class="bg" v-if="openPopUp"></div>
  <div class="popup-open" v-if="openPopUp">
    <div class="header"><a href="javascript:;" @click.prevent="openPopUp = !openPopUp">&lt; Aizvert</a></div>
    <div class="content">

      <div class="flex flex-row flex-wrap">
        <div class="basis-8/12 p-3">
          <h2>Informācija par skolu</h2>
          <div class="descriptiong mb-6">
            Bieži vien, pabeidzot kādu no iepriekš minētajām skolām, cilvēki iet šādas tālākās gaitas
          </div>
          <div class="hc-card compatibility mb-6">
            <div class="percent">
              <Donut class="donut mr-3" :percent="40" />
              40%
            </div>
            Atbilstība Tev:
          </div>

          <div class="hc-card mb-6 info-box">
            <div class="flex flex-row flex-wrap mb-8 mt-8">
              <div class="basis-7/12">
                <span class="label">Adrese</span><br>
                <span class="text">sadasdsad</span>
              </div>
              <div class="basis-5/12">
                <span class="label">Pieejamie sabiedriskie transporti</span><br>
                <span class="text">sadasdsad</span>
              </div>
            </div>

            <div class="flex flex-row flex-wrap mb-8">
              <div class="basis-3/12">
                <span class="label">Skolēnu skaits</span><br>
                <span class="text">2344</span>
              </div>
              <div class="basis-3/12">
                <span class="label">Paralēlklašu skaits</span><br>
                <span class="text">4</span>
              </div>
              <div class="basis-3/12">
                <span class="label">Vidējais skolēnu skaits klasē</span><br>
                <span class="text">28</span>
              </div>
            </div>

            <div class="flex flex-row flex-wrap mb-8">
              <div class="basis-12/12">
                <span class="label">Pieejamās ārpus skolas aktivitātes</span><br>
                <span class="text">
                  <span class="bordered">Dejosana</span>
                  <span class="bordered">Dejosana</span>
                  <span class="bordered">Dejosana</span>
                </span>
              </div>
            </div>
          </div>

        </div>
        <div class="basis-4/12 p-3">
          <div class="hc-card mb-6 school-title">
            <h2>6.-9. A klase</h2>
            <span class="school-name">Rīgas Franču licejs</span>
          </div>
          <div class="hc-card ratings">
            <span class="rating-title">Novērtējums</span>
            <div class="rating-list">
              <template v-for="index in 10">
                <div class="flex flex-row flex-wrap align-content-center">
                  <div class="basis-8/12 p-3">
                    <RatingSliderStatic :rating="index" />
                  </div>
                  <div class="basis-4/12 p-3">
                    Matematika
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
  .bg {
    position: fixed;
    background: rgba(0, 0, 0, 0.25);
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
  }

  .popup-open {
    position: fixed;
    top: 3%;
    min-height: 300px;
    background: #F7F7F9;
    width: 94%;
    left: 3%;
    border-radius: 20px;
    padding: 30px;
    color: black;
    z-index: 3;

    a {
      color: black;
    }

    h2 {
      font-size: 48px;
      font-weight: 700;
      line-height: 48px;
    }

    .descriptiong {
      font-style: normal;
      font-weight: 400;
      font-size: 16px;
      line-height: 24px;
      text-align: left;
      width: 100%;
    }

    .compatibility {
      background: linear-gradient(109.38deg, #B42EF3 3.46%, #5921D0 95.43%);
      padding: 30px 20px;

      font-size: 32px;
      font-weight: 700;
      line-height: 32px;
      color: #FFFFFF;
      position: relative;


      .percent {
        display: flex;
        align-items: center;
        font-style: normal;
        font-weight: 700;
        font-size: 32px;
        line-height: 32px;
        color: #ffffff;
        padding: 0 10px;
        height: 40px;
        position: absolute;
        right: 0;
      }
    }

    .school-title {
      h2 {
        display: block;
        margin: 0;
        padding: 0;
        font-size: 24px;
        font-weight: bold;
      }

      .school-name {
        display: block;
      }
    }

    .info-box {
      .label {
        font-size: 16px;
        font-weight: 400;
        line-height: 24px;
      }
      .text {
        font-size: 24px;
        font-weight: 600;
        line-height: 24px;

        .bordered {
          border: 1px solid gray;
          font-size: 12px;
          font-weight: 600;
          line-height: 20px;
          padding: 2px 12px;
          display: inline-block;
          margin: 0 5px 0 0;
          border-radius: 10px;
        }
      }
    }
  }
</style>