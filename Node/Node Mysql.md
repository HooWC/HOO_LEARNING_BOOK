在 Node.js 中创建一个使用 MySQL 的 RESTful API 涉及一些关键步骤。以下是详细步骤，包括 CRUD（创建、读取、更新、删除）操作的完整代码。

### 准备工作

1. **安装 Node.js**：确保系统上已经安装了 Node.js。
2. **创建项目文件夹**：创建一个文件夹来存储项目，例如 `notejs-mysql-api`。

### 第一步：初始化项目

打开终端并进入项目文件夹，然后运行以下命令来初始化一个 Node.js 项目：

```
npm init -y
```

### 第二步：安装必要的包

安装 Express.js（用于创建服务器）、MySQL 库和其他工具：

```
npm install express mysql body-parser
```

- **express**：用于构建 RESTful API。
- **mysql**：用于连接和操作 MySQL 数据库。
- **body-parser**：用于解析请求主体中的 JSON 数据。

### 第三步：设置 MySQL 数据库

在 MySQL 中创建一个新的数据库和表，例如：

```js
CREATE DATABASE notejs_api;
USE notejs_api;

CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT
);
```

### 第四步：创建主文件 `app.js`

在项目文件夹中创建一个 `app.js` 文件，配置 RESTful API。

#### 导入依赖项和设置 Express 应用程序

```js
const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');

const app = express();
const PORT = 3000;

// 中间件配置
app.use(bodyParser.json());

// 配置 MySQL 数据库连接
const db = mysql.createConnection({
  host: 'localhost',    // 替换为你的 MySQL 主机
  user: 'root',         // 替换为你的 MySQL 用户名
  password: '',         // 替换为你的 MySQL 密码
  database: 'notejs_api'  // 替换为你的数据库名称
});

db.connect((err) => {
  if (err) throw err;
  console.log('MySQL connected...');
});
```

### 第五步：创建 CRUD 路由

#### 1. 创建（POST）- 添加新笔记

```js
// 创建新笔记
app.post('/api/notes', (req, res) => {
  const { title, content } = req.body;
  const sql = 'INSERT INTO notes (title, content) VALUES (?, ?)';
  db.query(sql, [title, content], (err, result) => {
    if (err) throw err;
    res.json({ id: result.insertId, title, content });
  });
});
```

#### 2. 读取（GET）- 获取所有笔记

```js
// 获取所有笔记
app.get('/api/notes', (req, res) => {
  const sql = 'SELECT * FROM notes';
  db.query(sql, (err, results) => {
    if (err) throw err;
    res.json(results);
  });
});
```

#### 3. 读取单条记录（GET）- 根据 ID 获取单条笔记

```js
// 根据 ID 获取单条笔记
app.get('/api/notes/:id', (req, res) => {
  const { id } = req.params;
  const sql = 'SELECT * FROM notes WHERE id = ?';
  db.query(sql, [id], (err, result) => {
    if (err) throw err;
    if (result.length === 0) {
      return res.status(404).json({ message: 'Note not found' });
    }
    res.json(result[0]);
  });
});
```

#### 4. 更新（PUT）- 更新笔记内容

```js
// 更新笔记
app.put('/api/notes/:id', (req, res) => {
  const { id } = req.params;
  const { title, content } = req.body;
  const sql = 'UPDATE notes SET title = ?, content = ? WHERE id = ?';
  db.query(sql, [title, content, id], (err, result) => {
    if (err) throw err;
    if (result.affectedRows === 0) {
      return res.status(404).json({ message: 'Note not found' });
    }
    res.json({ message: 'Note updated successfully' });
  });
});
```

#### 5. 删除（DELETE）- 删除笔记

```js
// 删除笔记
app.delete('/api/notes/:id', (req, res) => {
  const { id } = req.params;
  const sql = 'DELETE FROM notes WHERE id = ?';
  db.query(sql, [id], (err, result) => {
    if (err) throw err;
    if (result.affectedRows === 0) {
      return res.status(404).json({ message: 'Note not found' });
    }
    res.json({ message: 'Note deleted successfully' });
  });
});
```

### 第六步：启动服务器

在 `app.js` 文件底部添加以下代码，设置服务器在指定端口监听：

```js
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
```

### 第七步：启动项目

在终端中运行以下命令来启动 Node.js 服务器：

```js
node app.js
```

### 运行和测试

在服务器启动后，可以使用 Postman 或 CURL 测试 API：

- **创建笔记**：`POST http://localhost:3000/api/notes`，请求体 `{ "title": "Title", "content": "Content" }`
- **获取所有笔记**：`GET http://localhost:3000/api/notes`
- **获取单条笔记**：`GET http://localhost:3000/api/notes/:id`
- **更新笔记**：`PUT http://localhost:3000/api/notes/:id`，请求体 `{ "title": "New Title", "content": "New Content" }`
- **删除笔记**：`DELETE http://localhost:3000/api/notes/:id`

### 完整代码

完整代码如下：

```js
const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');

const app = express();
const PORT = 3000;

app.use(bodyParser.json());

const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'notejs_api'
});

db.connect((err) => {
  if (err) throw err;
  console.log('MySQL connected...');
});

app.post('/api/notes', (req, res) => {
  const { title, content } = req.body;
  const sql = 'INSERT INTO notes (title, content) VALUES (?, ?)';
  db.query(sql, [title, content], (err, result) => {
    if (err) throw err;
    res.json({ id: result.insertId, title, content });
  });
});

app.get('/api/notes', (req, res) => {
  const sql = 'SELECT * FROM notes';
  db.query(sql, (err, results) => {
    if (err) throw err;
    res.json(results);
  });
});

app.get('/api/notes/:id', (req, res) => {
  const { id } = req.params;
  const sql = 'SELECT * FROM notes WHERE id = ?';
  db.query(sql, [id], (err, result) => {
    if (err) throw err;
    if (result.length === 0) {
      return res.status(404).json({ message: 'Note not found' });
    }
    res.json(result[0]);
  });
});

app.put('/api/notes/:id', (req, res) => {
  const { id } = req.params;
  const { title, content } = req.body;
  const sql = 'UPDATE notes SET title = ?, content = ? WHERE id = ?';
  db.query(sql, [title, content, id], (err, result) => {
    if (err) throw err;
    if (result.affectedRows === 0) {
      return res.status(404).json({ message: 'Note not found' });
    }
    res.json({ message: 'Note updated successfully' });
  });
});

app.delete('/api/notes/:id', (req, res) => {
  const { id } = req.params;
  const sql = 'DELETE FROM notes WHERE id = ?';
  db.query(sql, [id], (err, result) => {
    if (err) throw err;
    if (result.affectedRows === 0) {
      return res.status(404).json({ message: 'Note not found' });
    }
    res.json({ message: 'Note deleted successfully' });
  });
});

app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
```

这就是完整的 CRUD RESTful API 示例，用 Node.js 和 MySQL 实现！