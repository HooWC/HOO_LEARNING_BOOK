## Fetch API

以下是使用 Fetch API 进行基本 CRUD 操作和获取数据的详细示例和步骤。

### 1. 基本用法

首先，确保你的环境支持 Fetch API，现代浏览器都支持该 API。

### 2. CRUD 示例代码

假设我们使用 `https://jsonplaceholder.typicode.com/posts` 作为 RESTful API，以下是 CRUD 操作的示例：

#### 2.1 创建（Create）

```js
const createPost = async () => {
    try {
        const response = await fetch('https://jsonplaceholder.typicode.com/posts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                title: 'foo',
                body: 'bar',
                userId: 1,
            }),
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        console.log('Created Post:', data);
    } catch (error) {
        console.error('Error creating post:', error);
    }
};

createPost();
```

#### 2.2 读取（Read）

```js
const fetchPosts = async () => {
    try {
        const response = await fetch('https://jsonplaceholder.typicode.com/posts');

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        console.log('Posts:', data);
    } catch (error) {
        console.error('Error fetching posts:', error);
    }
};

fetchPosts();
```

#### 2.3 更新（Update）

```js
const updatePost = async (postId) => {
    try {
        const response = await fetch(`https://jsonplaceholder.typicode.com/posts/${postId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                title: 'Updated Title',
                body: 'Updated Body',
                userId: 1,
            }),
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        console.log('Updated Post:', data);
    } catch (error) {
        console.error('Error updating post:', error);
    }
};

// 调用更新函数，假设要更新 ID 为 1 的帖子
updatePost(1);
```

#### 2.4 删除（Delete）

```js
const deletePost = async (postId) => {
    try {
        const response = await fetch(`https://jsonplaceholder.typicode.com/posts/${postId}`, {
            method: 'DELETE',
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        console.log('Deleted Post:', response.status); // 204 No Content
    } catch (error) {
        console.error('Error deleting post:', error);
    }
};

// 调用删除函数，假设要删除 ID 为 1 的帖子
deletePost(1);
```





### 3. 总结

以上代码展示了如何使用 Fetch API 进行 CRUD 操作，包括创建、读取、更新和删除操作。你可以根据需要修改 API URL 和请求体。确保在处理响应时检查 `response.ok`，以便处理可能出现的错误。



- **jQuery AJAX**:

  ```js
  $.ajax({
      url: 'https://api.example.com/data',
      method: 'GET',
      success: function(data) {
          console.log('Success:', data);
      },
      error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error:', textStatus, errorThrown);
      }
  });
  ```

- **Fetch API**:

  ```js
  fetch('https://api.example.com/data')
      .then(response => {
          if (!response.ok) {
              throw new Error('Network response was not ok');
          }
          return response.json();
      })
      .then(data => console.log('Success:', data))
      .catch(error => console.error('Error:', error));
  ```

### 4. 功能和灵活性

- **jQuery AJAX**:
  - 提供了更高层次的抽象，处理复杂的请求（如序列化数据、处理 JSON 等）相对简单。
  - 通过设置各种选项，可以轻松处理超时、重试、缓存等。
- **Fetch API**:
  - 使用 Promise，更加现代和灵活，但需要手动处理错误和响应类型（如 JSON、文本等）。
  - 不支持直接设置请求超时和缓存。

















































































