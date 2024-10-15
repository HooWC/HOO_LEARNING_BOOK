### Tailwind CSS

官网：https://tailwindcss.com/docs/installation

第一方法 直接引入使用

```
<script src="https://cdn.tailwindcss.com"></script> #使用这个
```

第二方法

```
#1 npm init -y # 生成package.json
#2 npm i -D tailwindcss postcss autoprefixer
#3 npx tailwindcss init # 生成tailwind.config.js
#4 npx tailwindcss -i ./src/input.css -o ./src/output.css --watch #生成 css 文件 可以修改路径  npx tailwindcss -i ./src/css/input.css -o ./public/css/style.css --watch
```

#3 tailwind.config.js

```
module.exports = {
  content: ["./public/**/*.{html，js}"], # 修改自己的html
  theme: {
    extend: {},
  },
  plugins: [],
}

解释
./src/**/*.{html,js}：匹配 src 目录及其所有子目录中的所有 .html 和 .js 文件。
./public/**/*.html：匹配 public 目录及其所有子目录中的所有 .html 文件。
```

#4 生成 input.css 文件

```
@tailwind base;
@tailwind components;
@tailwind utilities;
```

package.json #不需要修改

```
"scripts":{
	"dev": "npx tailwindcss -i ./src/css/input.css -o ./public/css/style.css --watch"
}

只要在cmd使用，npm run dev 就会自动 npx tailwindcss -i ./src/css/input.css -o ./public/css/style.css --watch


```

HTML

```
<link rel="stylesheet" href="css/style.css" /> #引入 output.css
```



自创建 tailwind.config.js

```
theme: {
	extend: {
		colors: {
			primary: '#FF6363',
			secondary: {
				100: '#E2E2D5',
				200: '#888883',
				}
			}
		}
	},
},
```

使用

```
bg-secondary-100
```





















































