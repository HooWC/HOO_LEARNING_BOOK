<script setup>
  import { onMounted } from 'vue';
  import { useCounterStore } from './stores/counter';
  import { storeToRefs } from 'pinia';

  const counterStore = useCounterStore();

  // 不能通过 storeToRefs 函数直接获取 store 中的方法
  const { count, doubleCount } = storeToRefs(counterStore);

  // 从 counterStore 中解构出 方法
  const { increment } = counterStore;

  onMounted(() => {
    counterStore.getList();
  });
</script>

<template>
  <button @click="increment">{{ count }}</button>
  {{ doubleCount }}

  <ul>
    <li v-for="item in counterStore.list" :key="item.id">
      {{ item.name }}
    </li>
  </ul>
</template>












<style scoped>
header {
  line-height: 1.5;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }
}
</style>
