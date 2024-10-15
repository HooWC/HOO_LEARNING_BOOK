# React localStorage 

`localStorage` 是 Web 浏览器提供的一种持久化存储机制，用于在浏览器中存储键值对数据。它允许你将数据存储在浏览器中，并在同一域名下的页面间共享数据。这些数据可以在页面重新加载后保持不变，甚至在浏览器关闭后重新打开时也可以保持不变，直到被显示地删除。

```react
import React, { useState } from 'react';

const App = () => {
  const [text, setText] = useState('');

  const handleChange = (event) => {
    setText(event.target.value);
  };

  const handleSave = () => {
    localStorage.setItem('data', text);
    alert('Data saved successfully!');
  };

  const handleLoad = () => {
    const data = localStorage.getItem('data');
    if (data) {
      setText(data);
    } else {
      alert('No data found!');
    }
  };

  return (
    <div>
      <input type="text" value={text} onChange={handleChange} />
      <button onClick={handleSave}>Save Data</button>
      <button onClick={handleLoad}>Load Data</button>
    </div>
  );
};

export default App;
```













