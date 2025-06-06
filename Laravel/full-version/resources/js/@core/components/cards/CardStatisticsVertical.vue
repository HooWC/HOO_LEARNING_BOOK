<script setup>
import { controlledComputed } from "@vueuse/core"

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  color: {
    type: String,
    required: false,
    default: 'primary',
  },
  icon: {
    type: String,
    required: true,
  },
  stats: {
    type: String,
    required: true,
  },
  change: {
    type: Number,
    required: true,
  },
  subtitle: {
    type: String,
    required: true,
  },
})

const isPositive = controlledComputed(() => props.change, () => Math.sign(props.change) === 1)
</script>

<template>
  <VCard>
    <VCardText class="d-flex align-center">
      <VAvatar
        v-if="props.icon"
        rounded
        size="38"
        variant="tonal"
        :color="props.color"
      >
        <VIcon
          :icon="props.icon"
          size="24"
        />
      </VAvatar>

      <VSpacer />

      <div
        v-if="props.change"
        :class="isPositive ? 'text-success' : 'text-error'"
        class="d-flex align-center text-sm font-weight-medium mt-n4"
      >
        <span>{{ isPositive ? `+${props.change}` : props.change }}%</span>

        <VIcon :icon="isPositive ? 'mdi-chevron-up' : 'mdi-chevron-down'" />
      </div>
    </VCardText>

    <VCardText>
      <h6 class="text-h6 me-2 mt-2 mb-1">
        {{ props.stats }}
      </h6>
      <p class="text-sm">
        {{ props.title }}
      </p>

      <VChip
        size="x-small"
        class="font-weight-medium"
      >
        <span class="text-truncate">{{ props.subtitle }}</span>
      </VChip>
    </VCardText>
  </VCard>
</template>
