<script setup>
import { ref } from 'vue'

const items = ref([
   { text: 'List', path: '/List' },
   { text: 'Card', path: '/Card' },
   { text: 'Sheet', path: '/Sheet' },
   { text: 'Bottom', path: '/Bottom' },
   { text: 'Bottom2', path: '/Bottom2' },
   { text: 'Menu', path: '/Menu' },
   { text: 'Toolbars', path: '/Toolbars' },
])
</script>

<template>
  <h1>我是首页</h1>
  <v-card class="mx-auto" max-width="300">
    <v-list :lines="false" density="compact" nav>
      <v-list-item
        v-for="(item, i) in items"
        :key="i"
        :value="item"
        color="primary"
      >
        <router-link :to="item.path">{{ item.text }}</router-link>
      </v-list-item>
    </v-list>
  </v-card>
</template>

<style>
/* Add any styles you need here */
</style>