## Axios

### 1. 安装 Axios

如果你还没有安装 Axios，可以通过 npm 或 yarn 安装：

```js
npm install axios
# 或者
yarn add axios
```

### 2. 基本用法

#### 2.1 发送 GET 请求

```js
import axios from 'axios';

const getData = async () => {
    try {
        const response = await axios.get('https://jsonplaceholder.typicode.com/posts');
        console.log(response.data);
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

getData();
```

#### 2.2 发送 POST 请求

```js
import axios from 'axios';

const postData = async () => {
    try {
        const response = await axios.post('https://jsonplaceholder.typicode.com/posts', {
            title: 'foo',
            body: 'bar',
            userId: 1,
        });
        console.log(response.data);
    } catch (error) {
        console.error('Error posting data:', error);
    }
};

postData();
```

### 3. 自定义请求头

```js
import axios from 'axios';

const fetchDataWithHeaders = async () => {
    try {
        const response = await axios.get('https://jsonplaceholder.typicode.com/posts', {
            headers: {
                'Authorization': 'Bearer YOUR_TOKEN',
                'Content-Type': 'application/json',
            },
        });
        console.log(response.data);
    } catch (error) {
        console.error('Error fetching data with headers:', error);
    }
};

fetchDataWithHeaders();
```



### 4. CRUD 示例代码

假设我们正在与一个 RESTful API 交互，例如 `https://jsonplaceholder.typicode.com/posts`，以下是 CRUD 操作的示例：

#### 4.1 创建（Create）

```js
javascript复制代码import axios from 'axios';

const createPost = async () => {
    try {
        const response = await axios.post('https://jsonplaceholder.typicode.com/posts', {
            title: 'foo',
            body: 'bar',
            userId: 1,
        });
        console.log('Created Post:', response.data);
    } catch (error) {
        console.error('Error creating post:', error);
    }
};

createPost();
```

#### 4.2 读取（Read）

```js
javascript复制代码import axios from 'axios';

const fetchPosts = async () => {
    try {
        const response = await axios.get('https://jsonplaceholder.typicode.com/posts');
        console.log('Posts:', response.data);
    } catch (error) {
        console.error('Error fetching posts:', error);
    }
};

fetchPosts();
```

#### 4.3 更新（Update）

```js
javascript复制代码import axios from 'axios';

const updatePost = async (postId) => {
    try {
        const response = await axios.put(`https://jsonplaceholder.typicode.com/posts/${postId}`, {
            title: 'Updated Title',
            body: 'Updated Body',
            userId: 1,
        });
        console.log('Updated Post:', response.data);
    } catch (error) {
        console.error('Error updating post:', error);
    }
};

// 调用更新函数，假设要更新 ID 为 1 的帖子
updatePost(1);
```

#### 4.4 删除（Delete）

```js
javascript复制代码import axios from 'axios';

const deletePost = async (postId) => {
    try {
        const response = await axios.delete(`https://jsonplaceholder.typicode.com/posts/${postId}`);
        console.log('Deleted Post:', response.status); // 204 No Content
    } catch (error) {
        console.error('Error deleting post:', error);
    }
};

// 调用删除函数，假设要删除 ID 为 1 的帖子
deletePost(1);
```

### 总结

以上代码展示了如何使用 Axios 进行 CRUD 操作，分别是创建、读取、更新和删除操作。你可以根据需要修改 API URL 和请求体。

































































