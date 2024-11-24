

## 2024 RN 笔记



### 目录

```
├── app                     # 开始
│ ├── (tabs)
│ ├────── _layout.js        # tab layout
│ ├────── index.js          # 如果使用tabs，index就是 home page
│ ├── _layout.js            # Stack home / 添加文体
│ ├── home.js               # 默认 Home page
│ ├── index.js              # Redirect home page
├── assets                  # 资源
│ └── fonts
│ └── icons
│ └── images
├── components
│ ├── common                 # 共同 组件
│ ├── home                   # 首页 组件
│ ├── other page             # 其他
│ ├── index.js               # 暴露 components
├── constants                # 暴露图片 文件夹
│ ├── icons.js  
│ ├── images.js  
│ ├── index.js  
│ ├── theme.js  
├── hook 
│ ├── useFetch.js            # 连接 API （* 自定义 或 Axios
├── styles                   # css 文件夹
├── utils                    # css 文件夹
├── app.json
├── babel.config.json
├── package-lock.json
├── package.json
└── README.md
```

```
├── home                     # 首页 组件
│ ├── welcome.jsx            # 首页 React Native 代码
│ ├── welcome.style.js       # 首页  CSS 
```



### 安装

```
npx create-expo-app@latest -e with-router // 安装
```

```
npm install expo-font axios react-native-dotenv // 安装
```



### 第一次启动项目，请输入以下

`expo-cli` 无需通过 USB 连接。这是 Expo 提供的一种方便快捷的开发方式，适用于跨平台移动应用程序的开发和测试。

```
npm install -g expo-cli // 安装
```



### Router 弃用

`expo-router/babel` 已被弃用，从 SDK 50 开始，推荐使用 `babel-preset-expo`。为了解决这个问题，需要在 `babel.config.js` 文件中删除 `expo-router/babel` 插件并替换为 `babel-preset-expo`。以下是步骤：

1. 打开你的项目目录下的 `babel.config.js` 文件。

2. 找到 `plugins` 部分，并移除 `"expo-router/babel"`。

3. 确保已经安装了 `babel-preset-expo`，如果没有，请运行以下命令来安装它：

   ```base
   npm install babel-preset-expo
   ```

4. 在 `babel.config.js` 文件中，将 `presets` 设置为 `babel-preset-expo`，例如：

   ```js
   module.exports = function (api) {
     api.cache(true);
     return {
       presets: ["babel-preset-expo"],
     };
   };
   ```

5. 保存文件并重启你的开发服务器。



### 安装 .env

```
npm install react-native-dotenv
```

#### babel.config.js

```js
module.exports = function (api) {
  api.cache(true);
  return {
    presets: ["babel-preset-expo"],  // 继续使用你已有的 preset
    plugins: [
      ["module:react-native-dotenv", {
        "envName": "APP_ENV",  // 你可以根据需要修改环境变量的名字
        "moduleName": "@env",  // 使用 @env 来导入变量
        "path": ".env",  // .env 文件的位置
        "safe": false,  // 设置是否使用安全模式
        "allowUndefined": true,  // 允许未定义的环境变量
        "verbose": false  // 是否显示详细日志
      }]
    ]
  };
};
```

#### 使用

```
import { RAPID_API_KEY } from '@env';
```



### 启动

```
npx expo start
```







### 连接 API Hook 自定义 方式

```js
import { useState, useEffect } from "react";
import axios from "axios";
```

```js
import { useState, useEffect } from "react";
import axios from "axios";

const useFetch = (endpoint, query) => {
  const [data, setData] = useState([]);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState(null);

  // 连接 API 链接
  const options = {
    method: 'GET',
    url: `https://your-api.com/${endpoint}`, // 替换为你自己的 API 地址
    params: { ...query }, // 传递查询参数
  };

  // 获取 API 数据
  const fetchData = async () => {
    setIsLoading(true);

    try {
      const response = await axios.request(options);

      setData(response.data); // 根据你的 API 返回结构，可能是 data 或其他字段
      setIsLoading(false);
    } catch (error) {
      setError(error);
      console.log(error);
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    fetchData();
  }, []);

  const refetch = () => {
    setIsLoading(true);
    fetchData();
  };

  return { data, isLoading, error, refetch };
};

export default useFetch;
```

#### 解释

```js
import { useState, useEffect } from "react"; // 导入 React 的 useState 和 useEffect hook
import axios from "axios"; // 导入 axios 库，用于发送 HTTP 请求

const useFetch = (endpoint, query) => {  // 创建一个自定义的 hook，接受 API endpoint 和查询参数 query
  const [data, setData] = useState([]); // 设置状态变量 data，用于存储从 API 获取到的数据，初始值为空数组
  const [isLoading, setIsLoading] = useState(false); // 设置状态变量 isLoading，用于表示数据是否正在加载，初始值为 false
  const [error, setError] = useState(null); // 设置状态变量 error，用于存储错误信息，初始值为 null

  // 设置 axios 请求的配置选项
  const options = {
    method: 'GET',  // 请求方法为 GET
    url: `https://your-api.com/${endpoint}`, // API 请求的 URL，根据传入的 endpoint 动态构建
    params: { ...query },  // 将 query 对象展开并添加到请求的参数中
  };

  // 定义 fetchData 函数，用于发送 API 请求并获取数据
  const fetchData = async () => {
    setIsLoading(true); // 开始加载，设置 isLoading 为 true

    try {
      const response = await axios.request(options); // 使用 axios 发送请求，获取响应

      setData(response.data); // 从响应中提取数据并更新 data 状态
      setIsLoading(false); // 请求完成，设置 isLoading 为 false
    } catch (error) {  // 如果请求失败，进入 catch 块
      setError(error);  // 将错误信息保存在 error 状态中
      console.log(error); // 在控制台输出错误信息
    } finally {
      setIsLoading(false); // 无论请求成功或失败，都设置 isLoading 为 false
    }
  };

  // 使用 useEffect hook 来确保组件加载时自动发起数据请求
  useEffect(() => {
    fetchData();  // 组件加载时调用 fetchData 函数发起 API 请求
  }, []);  // 依赖项为空数组，意味着该 effect 只会在组件首次渲染时运行

  // 定义 refetch 函数，用于重新请求数据
  const refetch = () => {
    setIsLoading(true);  // 开始加载，设置 isLoading 为 true
    fetchData();  // 重新发起请求
  };

  // 返回数据、加载状态、错误信息和重新请求的函数
  return { data, isLoading, error, refetch };
};

export default useFetch;  // 导出 useFetch hook，供其他组件使用
```

#### 前端使用

```
import useFetch from "../../../hook/useFetch";
```



### 连接 API Axios 方式

假设我们有一个用户管理的 API，允许通过用户的唯一标识符（`user_id`）来查询用户的详细信息。这个用户 ID 是每个用户在系统中的唯一标识。

#### 1. **请求 URL 示例**

通常，使用用户 ID 查找用户信息的 API URL 会类似于：

```
GET /users/{user_id}
```

其中，`{user_id}` 是你要查询的用户的 ID，例如：

```
GET /users/12345
```

#### 2. **调用 API 的 JavaScript 示例**

我们可以在 React 中使用 `useEffect` 和 `axios` 来请求该 API，获取用户信息。假设我们使用一个用户 ID 作为查询参数来获取数据。

#### 示例代码：通过用户 ID 获取用户数据

```js
import { useState, useEffect } from 'react';
import axios from 'axios';

const UserProfile = ({ userId }) => {
  const [userData, setUserData] = useState(null); // 存储用户数据
  const [isLoading, setIsLoading] = useState(true); // 加载状态
  const [error, setError] = useState(null); // 错误状态

  useEffect(() => {
    // 在组件加载时通过用户 ID 获取用户数据
    const fetchUserData = async () => {
      try {
        setIsLoading(true); // 设置加载状态
        const response = await axios.get(`https://api.example.com/users/${userId}`); // 使用用户 ID 查询
        setUserData(response.data); // 将用户数据保存到 state
      } catch (error) {
        setError(error); // 如果请求失败，设置错误状态
      } finally {
        setIsLoading(false); // 请求完成，设置加载状态为 false
      }
    };

    fetchUserData(); // 调用 API 获取数据
  }, [userId]); // 依赖项为 userId，当 userId 发生变化时重新请求

  // 渲染加载状态、错误信息或用户数据
  if (isLoading) return <div>Loading...</div>;
  if (error) return <div>Error: {error.message}</div>;

  return (
    <div>
      <h2>User Profile</h2>
      <p>Name: {userData.name}</p>
      <p>Email: {userData.email}</p>
      <p>Age: {userData.age}</p>
      {/* 可以继续显示更多用户信息 */}
    </div>
  );
};

export default UserProfile;
```



### 错误解决

#### Router 错误

```
npm install expo-router
```

```
npx expo upgrade
```

删除 useSearchParams

**切换到 `useLocalSearchParams` 或 `useGlobalSearchParams`**

`useLocalSearchParams` 用于获取当前页面的搜索参数，而 `useGlobalSearchParams` 则适用于全局共享的搜索参数。如果你只关心当前页面的搜索参数，推荐使用 `useLocalSearchParams`。

修改你的代码：

```js
import { useLocalSearchParams } from 'expo-router';

const YourComponent = () => {
  const { job_id } = useLocalSearchParams(); // 使用 useLocalSearchParams 获取当前页面的参数

  // 使用 job_id 做数据加载等处理
};
```



































































