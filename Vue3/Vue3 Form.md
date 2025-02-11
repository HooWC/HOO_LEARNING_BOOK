```vue
<script setup>
import { ref } from 'vue'

const formData = ref({
  name: '',
  email: ''
})

const handleSubmit = () => {
  console.log('提交的数据:', formData.value)
  alert('提交成功！')
}
</script>

<template>
  <form @submit.prevent="handleSubmit">
    <label>
      姓名：
      <input v-model="formData.name" type="text" required />
    </label>
    <br />
    <label>
      邮箱：
      <input v-model="formData.email" type="email" required />
    </label>
    <br />
    <button type="submit">提交</button>
  </form>
</template>
```

