<script setup lang="ts">
const props = defineProps<{
  percent: any
}>()
</script>

<template>
  <svg style="width: 40px; height: 40px;" height="100%" viewBox="0 0 4040 " class="donut">
    <circle class="donut-hole" cx="20" cy="20" r="15.91549430918954" fill="transparent"></circle>
    <circle class="donut-segment donut-segment" cx="20" cy="20" r="15.91549430918954" fill="transparent" stroke-width="8" :stroke-dasharray="`${percent} ${ 100 - percent}`" stroke-dashoffset="25"></circle>
  </svg>
</template>

<style scoped lang="scss">
@keyframes donutfade {
  0% {
    opacity: .2;
  }
  100% {
    opacity: 1;
  }
}

.donut-segment {
  stroke: #FFFFFF;
  animation: donut1 3s;
}
@keyframes donutfadelong {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

.donut-percent {
  font-size: 0.5em;
  line-height: 1;
  transform: translateY(0.5em);
  font-weight: bold;
}

</style>