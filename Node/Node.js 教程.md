## Node.js 教程



### 安装

1，选择 **Windows PowerShell (Admin)**

```
Set-ExecutionPolicy RemoteSigned -Scope CurrentUser // 一开始电脑使用
```

2，在项目 **安装**

```
npm init -y
```

3，**（选择）**可安装

```
npm install -g typescript // 电脑 cmd 安装 typescript 全局安装 / 一开始电脑使用
```

```
tsc -v // 检查 / 一开始电脑使用
```

```
npm install -g ts-node // 电脑 cmd 安装 ts-node 全局安装 / 一开始电脑使用
```

```
ts-node -v // 检查 / 一开始电脑使用
```

在项目安装 **typescript**

```
tsc --init
```

```
npm i express
```

```
npm i @types/express -D
```



### 启动

```js
node hello.js
```

```
ts-node ./api_server.ts
```





## Typescript 写法

```ts
import express from 'express';

const app = express();

app.get('/',(req,res) => {
    res.end('1212');
})

app.listen(8080, () => {
    console.log('服务已经启动了...')
})
```



### 引入 Json 文件

1，在 **tsconfig.json** 配置

```ts
"resolveJsonModule":true,
```

2，引入

```ts
import list from './list.json'
```

#### 例子代码：

Json

```json
[
    {
        "name":"Hoo",
        "age":24
    },
    {
        "name":"Jee",
        "age":14
    }
]
```

data.ts

```ts
import list from './list.json'

export class DataStore{
    static list = list
}
```

api_server.ts

```ts
import express from 'express';
import { DataStore } from './data' // 引入 Json 数据

const app = express();

app.get('/',(req,res) => {
    res.json(DataStore.list);
})

app.listen(8080, () => {
    console.log('服务已经启动了...')
})
```







































































## JavaScript 写法

### FS

#### 创建文件

```js
// 导入 fs
const fs = require('fs');

// 异步写入
fs.writeFile('./创建文件.txt','输入的内容', err => {
    if(err){
        console.log('写入失败');
        return;
    }

    console.log('成功');
});
```

```js
// 导入 fs
const fs = require('fs');

// 同步写入
fs.writeFileSync('./创建文件.txt','输入的内容');

//路径
'D:/index.html'
```



#### 追加内容

```js
// 导入 fs
const fs = require('fs');

// 追加内容
fs.appendFile('./创建文件.txt','追加的内容', err => {
    if(err) throw err;
    console.log('成功');
});
```

```js
// 导入 fs
const fs = require('fs');

// 同步追加
fs.appendFileSync('./创建文件.txt','输入的内容');
```



#### FS 流式写法 创建

```js
// 导入 fs
const fs = require('fs');

// 写入
let ws = fs.createWriteStream('./世界观.txt');
ws.write('世间1\r\n');
ws.write('世间2\r\n');
ws.write('世间3\r\n');
ws.write('世间4\r\n');

// 关闭
ws.end
```



#### 读取

```js
// 导入 fs
const fs = require('fs');

// 读取 二进制
fs.readFile('./创建文件.txt',(err, data) => {
    if(err) throw err;
    console.log(data);
})

// 读取 内容
fs.readFile('./创建文件.txt','utf-8',(err, data) => {
    if(err) throw err;
    console.log(data);
})
```

```js
// 导入 fs
const fs = require('fs');

// 读取 二进制
let data = fs.readFileSync('./创建文件.txt');
console.log(data.toString());
```



#### 保存视频

```js
// 导入 fs
const fs = require('fs');

// 读取
let data = fs.readFileSync('./例子.mp4');

// 保存视频
fs.writeFileSync('../File/Save/例子.mp4',data);
```

```js
// 导入 fs
const fs = require('fs');

// 读取
const rs = fs.createReadStream('./例子.mp4');
// 保存路径
const ws = fs.createWriteStream('./新例子.mp4');

rs.on('data',chunk => {
    // 保存
    ws.write(chunk);
})
```



#### 换名字

```js
// 导入 fs
const fs = require('fs');

// 换名字
fs.rename('./创建文件.txt','./新名字.txt', err => {
    if(err) throw err;
    console.log('成功');
})
```



#### 移动文件

```js
// 导入 fs
const fs = require('fs');

// 移动 文件
fs.rename('./创建文件.txt','./新文件夹/创建文件.txt', err => {
    if(err) throw err;
    console.log('成功');
})
```



#### 删除文件

```js
// 导入 fs
const fs = require('fs');

// 删除
fs.unlink('./创建文件.txt', err => {
    if(err) throw err;
    console.log('成功');
})
```

```js
// 导入 fs
const fs = require('fs');

// 删除
fs.rm('./创建文件.txt', err => {
    if(err) throw err;
    console.log('成功');
})
```



#### 创建文件夹

```js
// 导入 fs
const fs = require('fs');

// 创建
fs.mkdir('./page', err => {
    if(err) throw err;
    console.log('成功');
})
```



#### 读取文件夹

```js
// 导入 fs
const fs = require('fs');

// 读取
fs.readdir('./page', (err, data) => {
    if(err) throw err;
    console.log(data);
})
```



#### 删除文件夹

```js
// 导入 fs
const fs = require('fs');

// 删除 不可删除空文件夹
fs.rmdir('./page', err => {
    if(err) throw err;
    console.log("成功");
})
```

```js
// 导入 fs
const fs = require('fs');

// 删除 空文件夹  不推荐使用
fs.rmdir('./page', {recursive: true} , err => {
    if(err) throw err;
    console.log("成功");
})
```

```js
// 导入 fs
const fs = require('fs');

// 删除 空文件夹   推荐使用
fs.rm('./page', {recursive: true} , err => {
    if(err) throw err;
    console.log("成功");
})
```



### Http

```js
// 导入 http
const http = require('http');

// 创建服务对象
const server = http.createServer((request, response) => {
   response.end('Hello Http'); 
})

// 启动服务
server.listen(9000,() => {
    console.log('服务启动了')
})
```

```js
// 导入 http
const http = require('http');

// 创建服务对象
const server = http.createServer((request, response) => {
    // 显示中文
   response.setHeader('content-type','text/html;charset=utf-8');
   response.end('你好'); 
})

// 启动服务
server.listen(9000,() => {
    console.log('服务启动了')
})
```



#### 获取URL数据

```js
// 导入 http
const http = require('http');
// 导入 url
const url = require('url');

// 创建服务对象
const server = http.createServer((request, response) => {
   // 连接
   let res = url.parse(request.url, true);

   // 获取路径
   let pathname = res.pathname;
   // 获取传递值
   let keyword = res.query.keyword;

   response.end('url');
})

// 启动服务
server.listen(9000,() => {
    console.log('服务启动了...')
})
```

```js
// 导入 http
const http = require('http');
// 导入 url
const url = require('url');

// 创建服务对象
const server = http.createServer((request, response) => {

   // 获取传递值
   let keyword = url.searchParams.get('keyword');

   response.end('url');
})

// 启动服务
server.listen(9000,() => {
    console.log('服务启动了...')
})
```



#### 判断方法

```js
// 导入 http 和 url 模块
const http = require('http');
const url = require('url');

// 创建服务对象
const server = http.createServer((request, response) => {

    // 获取请求方法
    let {method} = request;
    
   // 获取 pathname
   let {pathname} = url.parse(request.url, true);

    // 显示中文
    response.setHeader('content-type','text/html;charset=utf-8');

   // 判断请求方法和路径
   if (method === 'GET' && pathname === '/login') {
        response.end('登入界面');
   } else if (method === 'GET' && pathname === '/reg') {
        response.end('注册界面');
   } else {
        response.end('页面不存在');
   }
});

// 启动服务
server.listen(9000, () => {
    console.log('服务启动了...');
});
```



#### 引入HTML

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>mnj</h1>
    
</body>
</html>
```

```js
// 导入 http 和 fs 模块
const http = require('http');
const fs = require('fs');

// 创建服务对象
const server = http.createServer((request, response) => {

    // 引入 html
    let html = fs.readFileSync('./1.html');
    response.end(html);

});

// 启动服务
server.listen(9000, () => {
    console.log('服务启动了...');
});
```

```js
// 导入 http 和 fs 模块
const http = require('http');
const fs = require('fs');

// 创建服务对象
const server = http.createServer((request, response) => {

    let {pathname} = url.parse(request.url, true);
    if(pathname === '/'){
    	let html = fs.readFileSync('./1.html');
    	response.end(html);
   	}else if(pathname === '/index.css'){
        let css = fs.readFileSync('./1.css');
    	response.end(css);
    }else if(pathname === '/index.js'){
        let js = fs.readFileSync('./1.js');
    	response.end(js);
    }else{
        response.statusCode = 404;
        response.end('<h1>404 Not Found</h1>')
    }

});

// 启动服务
server.listen(9000, () => {
    console.log('服务启动了...');
});
```

```js
// 导入 http 和 fs 模块
const http = require('http');
const fs = require('fs');

// 创建服务对象
const server = http.createServer((request, response) => {

    let {pathname} = url.parse(request.url, true);
    fs.readFile(filePath, (err, data) => {
        if(err) throw err;
        response.end(data);
    })

});

// 启动服务
server.listen(9000, () => {
    console.log('服务启动了...');
});
```













