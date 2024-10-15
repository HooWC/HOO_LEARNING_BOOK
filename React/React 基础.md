# ♐ React 基础

[React 中文文档]: https://zh-hans.react.dev/learn/start-a-new-react-project

一起来速刷React吧，少年！



## 🎆 安装 🐨

```
npx create-react-app <project-name>
```

```
npm create vite@latest

npm run dev
```

#### 启动

```
npm start
```

删除其他文件，留下 `index.js` 和 `App.js`

原始 `index.js` 文件

```react
import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <App />
);
```

## 🎆 安装 `Axios`  (如有需要)

```
npm i axios
```





## 🎆 基本使用

#### 🥪 Map

```react
const list = [
    { id: 1, text: 'Item 1' },
    { id: 2, text: 'Item 2' },
    { id: 3, text: 'Item 3' }
  ];
```

```react
<ul>
  {
  list.map(item => (
    <li key={item.id}>{item}</li>
  ))
  }
</ul>
```



#### 🥪 Map 函数写法

```react
function App(){
    const listData = lists.map(item => (
        <li key={item.id}>{item.name}</li>
    ));

    return (
        <div>
            <ul>
                {listData}
            </ul>
        </div>
    );
}
```



#### 🥪 三元表达式

```react
{flag && <span>this is span</span>}
```

```react
{loading ? <span>loading...</span> : <span>this is span</span>}
```



#### 🥪 onCLick

```react
function App(){
	const clickHandler = () => {
		cosole.log('button按钮点击了')
	}
	
	return (
		<button onCLick={clickHanfler}></button>
	)
}
```

`Component` 写法

```react
import React, { Component } from 'react';

class App extends Component {
  clickHandler = () => {
    console.log('button按钮点击了');
  }

  render() {
    return (
      <button onClick={this.clickHandler}></button>
    );
  }
}

export default App;
```

`传递参数` 写法

```react
function App(){
	const clickHandler = (name) => {
		cosole.log('button按钮点击了')
	}
	
	return (
		<button onCLick={() => clickHanfler('Hoo')}></button>
	)
}
```

```react
function App(){
	const clickHandler = (name,e) => {
		cosole.log('button按钮点击了')
	}
	
	return (
		<button onCLick={(e) => clickHanfler('Hoo',e)}></button>
	)
}
```



#### 🥪 Style

（不推荐）

```react
<div style={{ color:'red' }}>this is div</div>
```

class类

```css
.foo {
	color:red
}
```

```react
import './index.css'

function App () {
	return (
		<div>
			<span className='foo'>this is span</span>
		</div>
	)
}
```

[className 插件官网]: https://github.com/JedWatson/classnames

安装

```
npm install classnames
```

使用

```react
import classNames from 'classnames'

className={classNames('nav-item', { active: type === item.type })}
```



#### 🥪 Filter

```react
List.filter(item => item.id !== id)
```



#### 🥪 受控表单绑定 (onChange)

```react
const [value, setValue] = useState('')
```

```react
<input 
	type="text"
	value={value}
	onChange={(e) => setValue(e.target.value)}
/>
```



## 🎆 父传子

props只是读，不能修改数据

```react
function Son(props){
	return <div>this is son {props.name}</div>
}

function App(){
	const name = 'this is app name'
	return (
		<div>
			<Son name={name} />
		</div>
	)
}
```

### 🥬 chilren

```react
function Son(props){
	return <div>this is son {props.chilren}</div>
}

function App(){
	const name = 'this is app name'
	return (
		<div>
			<Son>
				<span>this is span</span>
			</Son>
		</div>
	)
}
```



## 🎆 子传父

### 🥬 解构赋值 写法

```react
function Son({ onGetMsg }){
	const sonMsg = 'this is son msg'
	return (
		<div>
			<button onClick={() => onGetMsg(sonMsg)}>send</button>
		</div>
	)
}

function App(){
	const getMsg = (msg) => console.log(msg)
	return (
		<div>
			<Son onGetMsg={getMsg} />
		</div>
	)
}
```
### 🥬 Props 写法

```react
function Son(props){
	const sonMsg = 'this is son msg';
	return (
		<div>
			<button onClick={() => props.onGetMsg(sonMsg)}>send</button>
		</div>
	);
}
```









## 🎆 createContext()

```react
import { createContent } from "react"

const MsgContext = createContent()

function A(){
	return (
		<div>
			this is A component
			<B />
		</div>
	)
}

function B(){
const msg = useContext(MsgContext)
	return (
		<div>
			this is B component , { msg }
		</div>
	)
}

function App(){
const msg = 'this is app msg'
	return (
		<div>
			<MsgContext.Provider value={msg}>
				this is App
				<A />
			</MsgContext.Provider>
		</div>
	)
}
```





## ⚛ Hook

#### 🍧 useState

```react
import { useState } from 'react'

function App(){
	const [count, setCount] = useState(0)
	
	const handleClick = () => {
		setCount(count++)
	}
	
	return (
		<div>
			<button onClick={handleClick}>{count}</button>
		</div>
	)
}

export default App
```

模型

```react
import { useState } from 'react'

function App(){
	const [from, setFrom] = useState({
		name:'Hoo'
	})
	
	const handleClick = () => {
		setFrom({
			...from,
			name:'Hoo Weng Chin'
		})
	}
	
	return (
		<div>
			<button onClick={handleClick}>{from.name}</button>
		</div>
	)
}

export default App
```



#### 🍧 useRef

```react
import React, { useRef } from 'react';

function MyComponent() {
  const inputRef = useRef(null);

  function handleClick() {
    console.log('Input value:', inputRef.current.value);
  }

  return (
    <div>
      <input type="text" ref={inputRef} />
      <button onClick={handleClick}>Get Value</button>
    </div>
  );
}

export default MyComponent;
```

```react
inputRef.current.focus()
```



#### 🍧 useEffect

```react
import { useEffect } from "react"
```

#### useEffect + Axios

```react
import React, { useState, useEffect } from 'react';
import axios from 'axios';

function App() {
    const [invoices, setInvoices] = useState([]);

    useEffect(() => {
        const getInvoices = async () => {
            try {
                const response = await axios.get("/api/get_all_invoice");
                // 更新状态以反映获取的发票数据
                setInvoices(response.data.invoices);
            } catch (error) {
                console.error('Error fetching invoices:', error);
            }
        };

        getInvoices();
    }, []); // 空数组表示仅在组件挂载时运行一次

    return (
        <div>
            {/* 在此处使用invoices状态中的数据渲染UI */}
        </div>
    );
}

export default App;
```

#### useEffect 清除

```react
import React, { useState, useEffect } from 'react';
import axios from 'axios';

function App() {
    const [invoices, setInvoices] = useState([]);

    useEffect(() => {
        const timer = setInterval(() => {
        	console.log('定时执行中')
        },1000)
        
        return () => {
        	clearInterval(timer)
        }
    }, []); 

    return (
        <div>
            {/* 在此处使用invoices状态中的数据渲染UI */}
        </div>
    );
}

export default App;
```





## 💽 自定义Hook

封装函数就是自定义Hook

```react
function useToggle(){
	const [value, setValue] = useStaet(true)
	const toggle = () => setValue(!value)
	
	return {
		value,
		toggle
	}
}

function App(){
	const { value, toggle } = useToggle()
	return (
		<div>
			{value && <div>this is div</div>}
			<button onClick={toggle}>toggle</button>
		</div>
	)
}
```































