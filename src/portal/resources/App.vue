<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router';
import Menu from "@components/menu/Menu.vue";
</script>

<template>
  <header>
    <Menu />
  </header>

  <RouterView />
</template>

<style scoped>

</style>
