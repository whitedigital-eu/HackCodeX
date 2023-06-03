<script setup lang="ts">
import { ref } from 'vue'
import type {MenuInterface} from "@/interfaces/menu/MenuInterface";

const topMenu = ref<MenuInterface[]>([
  {
    label: 'Par mums',
    location: 'about',
  },
  {
    label: 'Aptauja',
    location: 'survey',
  },
  {
    label: 'Atrodi savu nākotni',
    location: 'future',
  }
])
</script>

<template>
  <div class="top-bar">
    <div class="user">
      <img src="@/assets/images/profile.png" />
    </div>
    <div class="menu">
      <router-link v-for="item in topMenu" active-class="active" :to="item.location">{{ item.label}}</router-link>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.top-bar {
  .user {
    position: absolute;
    height: 80px;
    right: 20px;
    display: flex;
    align-content: center;
    flex-wrap: wrap;

    img {
      width: 40px;
      height: 40px;
    }
  }

  .menu {
    background: #232325;
    display: flex;
    justify-content: center;
    flex-wrap: nowrap;
    gap: 10px;

    a {
      padding: 10px;
      margin: 18px 0;
      color: #FFFFFF;
      display: inline-block;
      border-radius: 20px;
      font-size: 16px;
      font-weight: 600;

      &.active {
        background: var(--primary);
      }
    }
  }
}
</style>
