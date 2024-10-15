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

    // getter 定义 获取数据并对其进行处理，然后将结果返回给组件
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