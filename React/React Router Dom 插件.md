# React Router Dom 插件

## 🐯 安装 

```
npm i react-router-dom
```

使用

```react
import React from 'react';
import ReactDOM from 'react-dom/client';
import {
	createBrowserRouter,
	RouterProvider,
} from "react-router-dom";

const router = createBrowserRouter([
  {
    path: "/",
    element: <div>Hello world</div>
  },
  {
    path: "/login",
    element: <div>login page</div>
  },
])

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
  	<RouterProvider router={router} />
  </React.StrictMode>
);
```



## 🐻 例子

创建 `router` 文件

```react
import Login from '../page/Login'
import Article from '../page/Article'
import {
	createBrowserRouter,
	RouterProvider,
} from "react-router-dom";

const router = createBrowserRouter([
  {
    path: "/",
    element: <div>Hello world</div>
  },
  {
    path: "/login",
    element: <div>login page</div>
  },
])

export default router
```

`index.js` 引入

```react
import React from 'react';
import ReactDOM from 'react-dom/client';
import { RouterProvider } from "react-router-dom";
import router from './router'

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
  	<RouterProvider router={router} />
  </React.StrictMode>
);
```

`前端` 使用

```react
import { Link， useNavigate } from 'react-router-dom'

const Login = () => {
    const navigate = useNavigate()
    return (
        <div>
        	<Link to="/article">点击</Link>
            <button onClick={() => navigate('/article')}>点击</button>
        </div>
    )
}
```

### Link 和 Navigate 区别：

1. **用法：** `<Link>` 是一个 React 组件，需要包裹在 JSX 中，并使用 `to` 属性指定导航的目标路由；`navigate` 是一个函数，可以在任何合适的地方调用，用于编程式地触发导航。
2. **适用场景：** `<Link>` 通常用于在页面中创建导航链接，例如导航栏、菜单等；`navigate` 适用于在事件处理函数中或其他需要编程控制的地方执行导航操作。
3. **性能：** 使用 `<Link>` 组件进行导航时，React Router 会使用客户端路由进行导航，不会重新加载整个页面，因此通常更加高效。而使用 `navigate` 函数进行导航时，虽然也是客户端导航，但是需要手动触发，可能会带来一些额外的性能开销。

```react
import React from 'react';
import { useNavigate } from 'react-router-dom';

function MyComponent() {
  const navigate = useNavigate();

  const handleNavigate = () => {
    // 执行编程式导航到指定路由
    navigate('/article');
  };

  return (
    <div>
      <h1>My Component</h1>
      <button onClick={handleNavigate}>点击跳转到文章页面</button>
    </div>
  );
}

export default MyComponent;
```



## 💫 useSearchParams()

```react
<button onClick={() => navigate('/article?id=1001&name=Hoo')}>点击</button>
```

```react
import { useSearchParams } from 'react-router-dom'

const Article = () => {
    const [ params ] = useSearchParams()
    const  id = params.get('id')
    const  name = params.get('name')
    return (
        <div>
        	id是 {id} , 名字是 {name}
        </div>
    )
}
```



## 💫 useParams()

```react
<button onClick={() => navigate('/article/1001')}>点击</button>
```
```react
import Home from '../page/Home'
import Login from '../page/Login'
import Article from '../page/Article'
import {
	createBrowserRouter,
	RouterProvider,
} from "react-router-dom";

const router = createBrowserRouter([
  {
    path: "/",
    element: <Home />
  },
  {
    path: "/login",
    element: <Login />
  },
  {
    path: "/article/:id",
    element: <Article />
  },
])

export default router
```

```react
import { useParams } from 'react-router-dom'

const Article = () => {
    const params = useParams()
    const  id = params.id
    return (
        <div>
        	id是 {id}
        </div>
    )
}
```

======

```react
<button onClick={() => navigate('/article/1001/Hoo')}>点击</button>
```

```react
import Home from '../page/Home'
import Login from '../page/Login'
import Article from '../page/Article'
import {
	createBrowserRouter,
	RouterProvider,
} from "react-router-dom";

const router = createBrowserRouter([
  {
    path: "/",
    element: <Home />
  },
  {
    path: "/login",
    element: <Login />
  },
  {
    path: "/article/:id/:name",
    element: <Article />
  },
])

export default router
```

```react
import { useParams } from 'react-router-dom'

const Article = () => {
    const params = useParams()
    const  id = params.id
    const  name = params.name
    return (
        <div>
        	id是 {id} , name是 {name}
        </div>
    )
}
```



## 💫 Children (Outlet)

```react
import Home from '../page/Home'
import Login from '../page/Login'
import Article from '../page/Article'
import Board from '../page/Board'
import About from '../page/About'
import {
	createBrowserRouter,
	RouterProvider,
} from "react-router-dom";

const router = createBrowserRouter([
  {
    path: "/",
    element: <Home />
    children: [
      {
    	path: "/board",
    	element: <Board />
  	  },
  	  {
    	path: "/about",
    	element: <About />
  	  },
    ]
  },
  {
    path: "/login",
    element: <Login />
  },
  {
    path: "/article/:id/:name",
    element: <Article />
  },
])

export default router
```

`Home`

```react
import { Link, Outlet } from "react-router-dom"

const Home = () => {
	<div>
    	我是Home , 不会不见， 固定的
        <Link to="/board">面板</Link>
        <Link to="/about">关于</Link>
        
        {/* 渲染子组件 */}
        <Outlet />
    </div>
}
```

## 💫 默认二级路由

```react
import Home from '../page/Home';
import Login from '../page/Login';
import Article from '../page/Article';
import Board from '../page/Board';
import About from '../page/About';
import {
  createBrowserRouter,
  RouterProvider,
} from "react-router-dom";

const router = createBrowserRouter([
  {
    path: "/",
    element: <Home />,
    children: [
      {
        index: true, // 这里改为 index，表示默认路由
        element: <Board />
      },
      {
        path: "/about",
        element: <About />
      },
    ]
  },
  {
    path: "/login",
    element: <Login />
  },
  {
    path: "/article/:id/:name",
    element: <Article />
  },
]);

export default router;
```

## 💫 404页面路由

```
// 添加404页面路由
  {
    path: "*",
    element: <NotFound />
  }
```













