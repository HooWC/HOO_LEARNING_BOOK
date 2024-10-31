## Node 进阶版



### 安装

```
npm init -y
npm install express
```



#### 使用例子 1

```js
// 导入所需模块
const express = require('express');
const app = express();

// 定义端口
const PORT = 8080;

// 路由 - 返回简单的文本数据
app.get('/', (req, res) => {
    res.send('欢迎来到 Node.js API 服务器！');
});

// 路由 - 返回 JSON 格式的用户数据
app.get('/api/users', (req, res) => {
    const users = [
        { id: 1, name: 'Alice', age: 25 },
        { id: 2, name: 'Bob', age: 30 },
        { id: 3, name: 'Charlie', age: 35 },
    ];
    res.json(users);
});

// 启动服务器
app.listen(PORT, () => {
    console.log(`服务器已启动，访问地址：http://localhost:${PORT}`);
});
```



#### 使用例子 2

```js
// 导入模块
const express = require('express');
const app = express();
const PORT = 8080;

// 中间件：解析 JSON 数据
app.use(express.json());

// 模拟数据库数据
let users = [
    { id: 1, name: 'Alice', age: 25 },
    { id: 2, name: 'Bob', age: 30 },
    { id: 3, name: 'Charlie', age: 35 },
];

// 获取所有用户 (GET)
app.get('/api/users', (req, res) => {
    res.json(users);
});

// 根据 ID 获取用户 (GET)
app.get('/api/users/:id', (req, res) => {
    const userId = parseInt(req.params.id, 10);
    const user = users.find(u => u.id === userId);
    if (user) {
        res.json(user);
    } else {
        res.status(404).send('用户未找到');
    }
});

// 创建新用户 (POST)
app.post('/api/users', (req, res) => {
    const newUser = {
        id: users.length + 1, // 简单的 ID 生成方式
        name: req.body.name,
        age: req.body.age,
    };
    users.push(newUser);
    res.status(201).json(newUser); // 返回新创建的用户
});

// 更新用户 (PUT)
app.put('/api/users/:id', (req, res) => {
    const userId = parseInt(req.params.id, 10);
    const user = users.find(u => u.id === userId);

    if (user) {
        user.name = req.body.name || user.name;
        user.age = req.body.age || user.age;
        res.json(user);
    } else {
        res.status(404).send('用户未找到');
    }
});

// 删除用户 (DELETE)
app.delete('/api/users/:id', (req, res) => {
    const userId = parseInt(req.params.id, 10);
    const userIndex = users.findIndex(u => u.id === userId);

    if (userIndex !== -1) {
        const deletedUser = users.splice(userIndex, 1);
        res.json(deletedUser);
    } else {
        res.status(404).send('用户未找到');
    }
});

// 启动服务器
app.listen(PORT, () => {
    console.log(`服务器已启动，访问地址：http://localhost:${PORT}`);
});
```

##### API 测试方法

**使用 Postman**

- **GET 请求**

  - 获取所有用户：`GET http://localhost:8080/api/users`
  - 根据 ID 获取用户：`GET http://localhost:8080/api/users/1`

- **POST 请求**

  - 创建新用户：`POST http://localhost:8080/api/users`

  - 请求体示例：

    ```json
    {
      "name": "David",
      "age": 40
    }
    ```

- **PUT 请求**

  - 更新用户信息：`PUT http://localhost:8080/api/users/1`

  - 请求体示例：

    ```json
    {
      "name": "Alice Updated",
      "age": 26
    }
    ```

- **DELETE 请求**

  - 删除用户：`DELETE http://localhost:8080/api/users/1`





### 中间件 - 使用 JWT 认证

```
npm install express jsonwebtoken body-parser
```



#### 使用例子 1

```js
const express = require('express');
const jwt = require('jsonwebtoken');
const bodyParser = require('body-parser');
const crypto = require('crypto');

const app = express();
const SECRET_KEY = crypto.randomBytes(32).toString('hex'); // 生成 32 字节的随机密钥

// 使用 body-parser 中间件解析请求体数据
app.use(bodyParser.json());

// 中间件：验证 JWT 令牌
function authenticateToken(req, res, next) {
    const authHeader = req.headers['authorization'];
    const token = authHeader && authHeader.split(' ')[1];

    if (!token) return res.status(401).send('Access Denied');

    jwt.verify(token, SECRET_KEY, (err, user) => {
        if (err) return res.status(403).send('Invalid Token');
        req.user = user;
        next();
    });
}

// 登录路径，生成 JWT 令牌
app.post('/login', (req, res) => {
    const { username, password } = req.body;
    
    // 这里模拟用户验证（实际应用中需要使用数据库）
    if (username === 'testUser' && password === 'password123') {
        const user = { username: 'testUser' };
        const token = jwt.sign(user, SECRET_KEY, { expiresIn: '1h' });
        res.json({ token });
    } else {
        res.status(403).send('Invalid username or password');
    }
});

// 受保护的路径，只有认证用户可以访问
app.get('/protected', authenticateToken, (req, res) => {
    res.send(`Hello ${req.user.username}, you have access to this protected resource!`);
});

// 一个公开的路径，无需认证
app.get('/public', (req, res) => {
    res.send('This is a public resource accessible to anyone.');
});

// 启动服务器
app.listen(8080, () => {
    console.log('Server running on port 8080');
});
```



##### 路径说明

1. **POST `/login`**
   - 功能：用户登录并获取 JWT 令牌。
   - 请求体：`{ "username": "testUser", "password": "password123" }`
   - 返回：JWT 令牌。
2. **GET `/protected`**
   - 功能：受保护的路径，只有携带有效 JWT 的用户可以访问。
   - 请求头：`Authorization: Bearer <token>`
   - 返回：受保护资源信息。
3. **GET `/public`**
   - 功能：公开路径，无需认证即可访问。
   - 返回：公开资源信息。





### 文件上传与下载 - 使用 Multer

```
npm install express multer
```

```
project-directory/
├── uploads/      # 存放上传文件的目录 / 自己创建
├── server.js     # 主服务器文件
├── package.json
```



#### 使用例子 1

```js
const express = require('express');
const multer = require('multer');
const path = require('path');

const app = express();

// 设置上传目录和文件命名
const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, 'uploads/'); // 指定上传文件存放的目录
    },
    filename: (req, file, cb) => {
        cb(null, Date.now() + path.extname(file.originalname)); // 以时间戳作为文件名
    }
});

// 创建 multer 实例
const upload = multer({ storage });

// 上传文件的路由
app.post('/upload', upload.single('file'), (req, res) => {
    res.send(`File uploaded successfully: ${req.file.filename}`);
});

// 下载文件的路由
app.get('/download/:filename', (req, res) => {
    const filePath = path.join(__dirname, 'uploads', req.params.filename);
    res.download(filePath, (err) => {
        if (err) {
            res.status(404).send('File not found');
        }
    });
});

// 启动服务器
app.listen(8080, () => {
    console.log('Server running on port 8080');
});
```

Html Uploads

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <h1>File Upload</h1>
    <form action="http://localhost:8080/upload" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required />
        <button type="submit">Upload</button>
    </form>
</body>
</html>
```

Html Download

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Download</title>
</head>
<body>
    <h1>Download File</h1>
    <button id="downloadBtn">Download File</button>

    <script>
        document.getElementById('downloadBtn').addEventListener('click', function() {
            window.location.href = 'http://localhost:8080/download/1730343500255.txt';
        });
    </script>
</body>
</html>
```



**使用 Postman 上传文件**：

- 打开 Postman。
- 选择请求方法为 `POST`。
- 输入 URL：`http://localhost:8080/upload`。
- 在 `Body` 选项卡中，选择 `form-data`。
- 在 `Key` 字段中输入 `file`（这是 multer 中定义的字段名）。
- 在 `Value` 字段中，点击右侧的“选择文件”按钮，选择要上传的文件。
- 点击“发送”按钮。



**在 Postman 中发起 GET 请求**：

- 打开 Postman。

- 选择请求方法为 `GET`。

- 输入 URL，例如：

  ```
  http://localhost:8080/download/your_uploaded_file_name.ext
  ```

  替换 

  ```
  your_uploaded_file_name.ext
  ```

   为你实际上传的文件名。

- 点击“发送”按钮。

**检查下载**：

- Postman 会提示你保存文件。如果一切正常，你将能够下载该文件。



##### 路由说明

1. **POST `/upload`**
   - 功能：接收文件上传。
   - 文件参数：`file`（应与前端请求中上传的字段名一致）。
   - 返回：上传成功消息，包含文件名。
2. **GET `/download/:filename`**
   - 功能：下载指定文件。
   - 请求参数：`filename`（要下载的文件名）。
   - 返回：下载文件或 404 错误（文件未找到）。





### 实时通信 - 使用 Socket.IO

```
npm install express socket.io
```

```
project-directory/
├── server.js         # Node.js 服务器文件
├── public/           # 存放前端文件的目录
│   ├── index.html    # 前端 HTML 文件
│   └── style.css     # （可选）样式文件
└── package.json      # 项目描述文件
```



#### 使用例子 1

```js
const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const path = require('path');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// 静态文件服务
app.use(express.static(path.join(__dirname, 'public')));

// 处理 Socket.IO 连接
io.on('connection', (socket) => {
    console.log('A user connected');

    // 监听客户端发送的消息
    socket.on('chat message', (msg) => {
        console.log('Message received: ' + msg);
        // 广播消息到所有客户端
        io.emit('chat message', msg);
    });

    socket.on('disconnect', () => {
        console.log('A user disconnected');
    });
});

// 启动服务器
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
```

HTML

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <link rel="stylesheet" href="style.css"> <!-- 可选样式 -->
</head>
<body>
    <h1>Chat Room</h1>
    <ul id="messages"></ul>
    <form id="form" action="">
        <input id="input" autocomplete="off" placeholder="Type your message here..." /><button>Send</button>
    </form>

    <script src="/socket.io/socket.io.js"></script>
    <script>
        const socket = io();

        const form = document.getElementById('form');
        const input = document.getElementById('input');
        const messages = document.getElementById('messages');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (input.value) {
                // 发送消息到服务器
                socket.emit('chat message', input.value);
                input.value = '';
            }
        });

        // 监听服务器发送的消息
        socket.on('chat message', function(msg) {
            const item = document.createElement('li');
            item.textContent = msg;
            messages.appendChild(item);
            window.scrollTo(0, document.body.scrollHeight);
        });
    </script>
</body>
</html>
```

Css

```css
body {
    font-family: Arial, sans-serif;
}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

li {
    padding: 8px;
    margin-bottom: 5px;
    background-color: #f1f1f1;
    border-radius: 4px;
}

form {
    display: flex;
    margin-top: 10px;
}

input {
    flex: 1;
    padding: 10px;
}

button {
    padding: 10px;
}
```

打开浏览器，访问 `http://localhost:3000`。你应该能够看到聊天界面。



#### Public Chat 项目

```
npm install mongoose
```



使用 MongoDB Atlas 是一个非常方便的方法来托管 MongoDB 数据库。以下是详细的步骤，帮助你设置和使用 MongoDB Atlas：

#### 1. 注册 MongoDB Atlas

1. 访问 MongoDB Atlas：
   - 前往 [MongoDB Atlas](https://www.mongodb.com/cloud/atlas)。
2. 创建账户：
   - 点击“Get Started Free”注册一个账户。如果你已有账户，直接登录即可。

#### 2. 创建一个新集群

1. 创建集群：
   - 登录后，点击“Build a Cluster”。
   - 选择一个免费的集群配置（Free Tier）。
   - 选择你的云提供商和区域（建议选择离你最近的区域以获得更好的性能）。
   - 点击“Create Cluster”按钮，等待集群创建（可能需要几分钟）。

#### 3. 配置数据库用户

1. 创建数据库用户：
   - 在集群创建完成后，点击“Database Access”选项。
   - 点击“Add New Database User”。
   - 设置用户名和密码，选择“Read and write to any database”权限。
   - 点击“Add User”。

#### 4. 设置网络访问

1. 允许IP访问：
   - 点击“Network Access”选项。
   - 点击“Add IP Address”。
   - 选择“Allow Access from Anywhere”以便任何IP访问（在生产环境中，请根据需要限制IP）。
   - 点击“Confirm”。

#### 5. 获取连接字符串

1. 获取连接字符串：

   - 返回集群页面，点击“Connect”按钮。

   - 选择“Connect your application”。

   - 复制提供的连接字符串，格式如下：

     ```js
     mongodb+srv://<username>:<password>@cluster0.mongodb.net/myFirstDatabase?retryWrites=true&w=majority
     ```

#### 6. 使用 Mongoose 连接到 MongoDB Atlas

在你的 Node.js 项目中，你需要安装 Mongoose（如果还没安装的话）：

```
npm install mongoose
```

然后在代码中连接到 MongoDB Atlas：

```js
const mongoose = require('mongoose');

// 使用你在 Atlas 上创建的用户名和密码替换
const username = 'yourUsername';
const password = 'yourPassword';
const dbName = 'yourDatabaseName'; // 可自定义数据库名
const uri = `mongodb+srv://${username}:${password}@cluster0.mongodb.net/${dbName}?retryWrites=true&w=majority`;

mongoose.connect(uri, {
    useNewUrlParser: true,
    useUnifiedTopology: true,
})
.then(() => {
    console.log('Connected to MongoDB Atlas');
})
.catch(err => {
    console.error('Database connection error:', err);
});
```

#### 7. 在数据库中执行操作

一旦连接成功，你可以创建模型、执行 CRUD 操作等。以下是一个简单的示例：

```js
const messageSchema = new mongoose.Schema({
    text: String,
    timestamp: { type: Date, default: Date.now },
});

const Message = mongoose.model('Message', messageSchema);

// 插入消息示例
const newMessage = new Message({ text: 'Hello, MongoDB Atlas!' });
newMessage.save()
    .then(() => console.log('Message saved!'))
    .catch(err => console.error('Error saving message:', err));

// 查询消息示例
Message.find()
    .then(messages => console.log('Messages:', messages))
    .catch(err => console.error('Error fetching messages:', err));
```

#### 8. 清理资源

如果不再使用，可以在 Atlas 控制台中删除集群，避免不必要的费用。

#### 小结

通过以上步骤，你可以在 MongoDB Atlas 上创建数据库并在 Node.js 应用中使用。Atlas 提供了强大的管理界面，可以轻松监控和管理数据库



#### 使用例子  1

html

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <link rel="stylesheet" href="style.css"> <!-- 可选样式 -->
</head>
<body>
    <h1>Chat Room</h1>
    <ul id="messages"></ul>
    <form id="form" action="">
        <input id="input" autocomplete="off" placeholder="Type your message here..." /><button>Send</button>
    </form>

    <script src="/socket.io/socket.io.js"></script>
    <script>
        const socket = io();
        const form = document.getElementById('form');
        const input = document.getElementById('input');
        const messages = document.getElementById('messages');

        // 加载历史消息
        socket.on('load messages', function(msgs) {
            msgs.forEach(msg => {
                const item = document.createElement('li');
                item.textContent = msg.content; // 使用 msg.content 显示消息
                messages.appendChild(item);
            });
            window.scrollTo(0, document.body.scrollHeight); // 滚动到页面底部
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (input.value) {
                // 发送消息到服务器
                socket.emit('chat message', input.value);
                input.value = '';
            }
        });

        // 监听服务器发送的消息
        socket.on('chat message', function(msg) {
            const item = document.createElement('li');
            item.textContent = msg;
            messages.appendChild(item);
            window.scrollTo(0, document.body.scrollHeight);
        });
    </script>
</body>
</html>
```

css

```css
body {
    font-family: Arial, sans-serif;
}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

li {
    padding: 8px;
    margin-bottom: 5px;
    background-color: #f1f1f1;
    border-radius: 4px;
}

form {
    display: flex;
    margin-top: 10px;
}

input {
    flex: 1;
    padding: 10px;
}

button {
    padding: 10px;
}
```

server.js

```js
const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const path = require('path');
const mongoose = require('mongoose');
const Message = require('./models/Message'); // 导入 Message 模型

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// 使用你在 Atlas 上创建的用户名和密码替换
const username = 'wengchinbusiness'; // 替换为你的用户名
const password = 'OdelKSTJEWDKD27T'; // 替换为你的密码
const dbName = 'sample_mflix'; // 使用你的数据库名称
const uri = `mongodb+srv://${username}:${password}@cluster0.5x4eq.mongodb.net/${dbName}?retryWrites=true&w=majority&appName=Cluster0`;

mongoose.connect(uri, {
    useNewUrlParser: true,
    useUnifiedTopology: true,
})
.then(() => {
    console.log('Connected to MongoDB Atlas');
})
.catch(err => {
    console.error('Database connection error:', err);
});

// 静态文件服务
app.use(express.static(path.join(__dirname, 'public')));

// API 路由，用于获取所有消息
app.get('/messages', async (req, res) => {
    try {
        const messages = await Message.find().sort({ createdAt: 'asc' }); // 按时间排序
        res.json(messages); // 返回消息数据
    } catch (err) {
        res.status(500).json({ error: 'Error fetching messages' });
    }
});

// 处理 Socket.IO 连接
io.on('connection', (socket) => {
    console.log('A user connected');

    // 在用户连接时加载历史消息
    Message.find().sort({ createdAt: 'asc' }).then(messages => {
        socket.emit('load messages', messages); // 发送历史消息到客户端
    });

    // 监听客户端发送的消息
    socket.on('chat message', async (msg) => {
        console.log('Message received: ' + msg);

        // 保存消息到数据库
        const message = new Message({ content: msg });
        await message.save();

        // 广播消息到所有客户端
        io.emit('chat message', msg);
    });

    socket.on('disconnect', () => {
        console.log('A user disconnected');
    });
});

// 启动服务器
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
```

models/Message.js

```js
// models/Message.js
const mongoose = require('mongoose');

const messageSchema = new mongoose.Schema({
    content: {
        type: String,
        required: true,
    },
    createdAt: {
        type: Date,
        default: Date.now,
    },
});

const Message = mongoose.model('Message', messageSchema);

module.exports = Message;
```





### 队列处理 - 使用 Bull 进行异步任务处理  x

```
npm install bull redis
```

```
your-project-name/
├── queue.js
├── server.js
├── package.json
└── node_modules/
```



#### 使用例子 1

queue.js

```
// queue.js
const Queue = require('bull');

// 创建 Bull 队列
const emailQueue = new Queue('emailQueue', {
  redis: {
    host: '127.0.0.1', // Redis 服务器地址
    port: 6379, // Redis 端口
  },
});

// 处理队列中的任务
emailQueue.process(async (job) => {
  console.log('Processing job:', job.id);
  
  // 模拟发送电子邮件的异步操作
  await sendEmail(job.data);
  
  console.log(`Email sent to: ${job.data.email}`);
});

// 模拟发送电子邮件的函数
async function sendEmail({ email }) {
  return new Promise((resolve) => {
    setTimeout(() => {
      console.log(`Sent email to ${email}`);
      resolve();
    }, 2000); // 模拟延迟
  });
}

module.exports = emailQueue;
```

server.js

```

```

package.json

```

```











































