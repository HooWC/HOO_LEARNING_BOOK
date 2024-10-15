# Vue3 项目

### 起步创建 Vue 项目

```
安装 routes
安装 Pinia
```

### 创建文件

```
apis // api 使用
utils // api 使用
styles
directives
composables
```





# 🪔 安装Element Plus （如有需要）

[Element Plus UI框架 官网]: https://element-plus.org/zh-CN/guide/installation.html

##### 安装 Element Plus

```
npm install element-plus --save

npm install -D unplugin-vue-components unplugin-auto-import
```

把下列代码插入到你的 `Vite.config.js`

```javascript
import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// elementPlus 引入
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    AutoImport({
      resolvers: [ElementPlusResolver()],
    }),
    Components({
      resolvers: [
        // 1. 配置elementPlus采用sass样式配色系统
        ElementPlusResolver({ importStyle: "sass" }),
      ],
    }),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  css: {
    preprocessorOptions: {
      scss: {
        // 2. 自动导入定制化样式文件进行样式覆盖
        additionalData: `
          @use "@/styles/element/index.scss" as *;
        `,
      }
    }
  }
})
```

安装 `SASS`

```
npm i sass -D
```

##### 在 `styles `创建 `element文件 `，然后创建 `index.scss`

准备定制化的样式文件

```javascript
@forward 'element-plus/theme-chalk/src/common/var.scss' with (
	$colors:(
		'primary': (
			// 主色
			'base': #27ba9b,
		),
		'success': (
			// 成功色
			'base': #1dc779,
		),
		'warning': (
			// 警告色
			'base': #ffb302,
		),
		'danger': (
			// 危险色
			'base': #e26237,
		),
		'error': (
			// 错误色
			'base': #cf4444,
		),
	)
)
```





# 安装 `Axios`  (如有需要)

```
npm i axios
```

### 



