# Vue3 Pinia

[Pinia 中文文档]: https://pinia.web3doc.top/introduction.html

### 安装 `Pinia`

```
npm install pinia
```

### 安装 `Axios`  (如有需要)

```
npm i axios
```

### `Main.js` 引入 Pinia

```javascript
import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import { createPinia } from 'pinia'

createApp(App).use(createPinia()).mount('#app')
```

### 创建 `store` 文件

```javascript
import { defineStore } from "pinia";
import { computed, ref } from 'vue'
import axios from "axios";

export const useCounterStore = defineStore('counter',() => {
    // 定义数据 (state)
    const count = ref(0)

    // 定义修改数据的方法 （action 同步+异步）
    const increment = () => {
        count.value++
    }

    // getter 定义 获取数据并对其进行处理，然后将结果返回给组件  计算属性
    const doubleCount = computed(() => count.value * 2)

    // 定义异步action
    const API_URL = 'http://geek.itheima.net/v1_0/channels'
    const list = ref([])
    const getList = async () => {
        const res = await axios.get(API_URL)
        list.value = res.data.data.channels  
    }

    // 以对象的方式return供组件使用
    return {
        count,
        increment,
        doubleCount,
        list,  
        getList,
    }
})
```

### vue 基本使用 pinia

```vue
<script setup>
  import { onMounted } from 'vue';
  import { useCounterStore } from './stores/counter';

  const counterStore = useCounterStore();

  onMounted(() => {
    counterStore.getList()
  })

</script>

<template>
  <button @click="counterStore.increment">{{  counterStore.count  }}</button>
  {{ counterStore.doubleCount }}

  <ul>
    <li v-for="item in counterStore.list" :key="item.id">
      {{ item.name }}
    </li>
  </ul>
</template>
```

### `storeToRefs` 写法

```vue
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
```



























