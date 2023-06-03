<script setup lang="ts">
import IconThumbsUp from "../icons/IconThumbsUp.vue";

const props = defineProps({
  image: String,
})

const emit = defineEmits(["cardSelected"])

</script>

<template>
  <div class="card">
    <img alt="option image" :src="image" />
    <button @click="emit('cardSelected')" class="btn">
      <icon-thumbs-up />
    </button>
  </div>
</template>

<style lang="scss" scoped>
.card {
  flex: 1 0 50%;
  height: 50%;
  background: #48333B;
  text-align: center;
  display: flex;
  flex-wrap: nowrap;
  flex-direction: column;
  align-items: center;
  justify-content: space-evenly;

  img {
    margin: 0 60px;
    width: 80%;
    max-height: 50%;
  }

  &.second {
    background: #333948;

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