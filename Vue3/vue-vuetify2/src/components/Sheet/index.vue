<script setup>
import { ref } from 'vue'

const elevations = ref([0, 4, 8, 12, 16, 20])
</script>

<template>
  <v-container>
    <v-row justify="space-around">
      <v-col
        v-for="elevation in elevations"
        :key="elevation"
        cols="12"
        md="4"
      >
        <v-sheet
          class="pa-12"
          color="grey-lighten-3"
        >
          <v-sheet
            :elevation="elevation"
            class="mx-auto"
            height="100"
            width="100"
          ></v-sheet>
        </v-sheet>
      </v-col>
    </v-row>
  </v-container>
</template>