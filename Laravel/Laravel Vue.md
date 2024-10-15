### Laravel Vue

```
npm create vue@latest # 安装这个
npm install @vitejs/plugin-vue --force --save-dev

npm run dev
```

```
npm install vue-loader@next vue@next vue-router@next # 安装这个
```

vite.config.js

```
import vue from '@vitejs/plugin-vue'

plugins:[
	...,
	vue()
]
```

app.js / main.js

```
import './bootstrap'

import { createApp } from 'vue'
import app from './components/app.vue'

createApp(app).mount('#app')
```

html

```
@vite('resource/css/app.css')
<div id="app"></div>
@vite('resource/js/app.js')
```

查看vue 文案





```
<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>
```

