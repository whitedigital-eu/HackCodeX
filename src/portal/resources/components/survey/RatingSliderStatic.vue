<script setup lang="ts">
const props = defineProps<{
  rating: any
}>()
</script>

<template>
  <div class="slide-bg">
    <div class="filled" :style="`width: ${parseInt(rating) * 10}%`"></div>
  </div>
</template>

<style scoped lang="scss">
.slide-bg {
  background: #E0E2E7;
  border-radius: 10px;
  height: 8px;
  overflow: hidden;

  .filled {
    background: linear-gradient(109.38deg, #B42EF3 3.46%, #5921D0 95.43%);
    height: 8px;
  }
}
</style>