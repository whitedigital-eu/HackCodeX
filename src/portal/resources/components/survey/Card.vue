<script setup lang="ts">
import IconThumbsUp from "../icons/IconThumbsUp.vue";

const props = defineProps({
  image: String,
})

const emit = defineEmits(["cardSelected"])

</script>

<template>
  <div class="card">
    <div class="inner-card" :style="`background-image: url('${image}')`">

    </div>
    <button @click="emit('cardSelected')" class="btn">
      <icon-thumbs-up />
    </button>
  </div>
</template>

<style lang="scss" scoped>
.card {
  flex: 1 0 50%;
  height: 50%;
  text-align: center;
  display: flex;
  flex-wrap: nowrap;
  flex-direction: column;
  align-items: center;
  justify-content: space-evenly;

  .inner-card {
    background-position: center;
    background-size: cover;
  }

  img {
    margin: 0 60px;
    width: 80%;
    max-height: 50%;
  }

  position: relative;
  .btn {
    position: absolute;
    bottom: 5%;
  }

  &.second {

    button {
      border: 3px solid var(--secondary);
      background-image: -webkit-linear-gradient(30deg, var(--secondary) 50%, transparent 50%);
      background-image: linear-gradient(30deg, var(--secondary) 50%, transparent 50%);
    }
  }

  @media (min-width: 768px) {
    height: 100%;

    &:hover {
      button {
        visibility: visible;
        cursor: pointer;
      }
    }

    button {
      padding: 24px 0;
      //visibility: hidden;
    }
  }
}
</style>