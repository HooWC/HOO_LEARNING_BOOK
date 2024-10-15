# 前端面试必看视频教程（Promise和其他）

- `setTimeout` 会在一定的延迟后执行一次指定的函数。
- `setInterval` 会以固定的时间间隔重复执行指定的函数。

`严肃模式`

```javascript
'use strict'

function func(){
'use strict'
}
```

`Promise`

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <div>
        <button id="btn">点击抽奖</button>
    </div>

    <script>
        function rand(m, n) {
            return Math.ceil(Math.random() * (n - m + 1)) + m - 1;
        }

        const btn = document.querySelector('#btn');

        btn.addEventListener('click', function () {

            const p = new Promise((resolve, reject) => {
                setTimeout(() => {
                    let n = rand(1, 100);

                    if (n <= 30) {
                        resolve(n); // 成功
                    } else {
                        reject(n); // 失败
                    }
                }, 1000);
            })

            p.then((value) => {
                alert('中奖 ' + value);
            }, (e) => {
                alert('再接再厉 ' + e)
            })

        })
    </script>

</body>
</html>
```

`读取文件内容`

```javascript
const fs = require('fs');

fs.readFile('./resource/content.txt', (err, data) => {
    if (err) throw err;

    console.log(data.toString());
})
```

`读取文件内容 Promise`

```javascript
const fs = require('fs');

const p = new Promise((resolve, reject) => {
    fs.readFile('./resource/content.txt', (err, data) => {
        if (err) reject(err);

        resolve(data);
    })
})

p.then((value) => {
    console.log(value.toString());
}, e => {
    console.log(e)
})
```

`方法 Promise`

```javascript
function mineReadFile(path){
    return new Promise((resolve, reject) => {
        require('fs').readFile(path, (err, data) => {
            if(err) reject(err);
            
            resolve(data);
        })
    })
}

mineReadFile('./resource/content.txt').then( value => {
    console.log(value.toString());
}, e => {
    console.log(e);
})
```



















































