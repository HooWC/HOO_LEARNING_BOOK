## SCSS

### 安装

```
npm install -g sass
```

### 文件

```
project/
│
├── scss/
│   ├── _reset.scss // 全局变量
│   ├── _variables.scss // 定义变量
│   ├── _mixins.scss // 函数
│   └── style.scss // 转换这个就可以了
│
└── css/
    └── style.css 
```

### 转换 Css 文件

```
sass style.scss style.css
```

### 变量

```
$myFont: Helvetica, sans-serif;
$myColor: red;
$myFontSize: 18px;
$myWidth: 680px;
```

### Global

```
$myColor: red;

h1 {
  $myColor: green !global;
  color: $myColor;
}

p {
  color: $myColor;
}
```

```
@import "文件名";
```

```
nav {
  ul {
    margin: 0;
    padding: 0;
    list-style: none;
  }
  li {
    display: inline-block;
  }
  a {
    display: block;
    padding: 6px 12px;
    text-decoration: none;
  }
}
```

### Class 创建 @mixin

```
@mixin important-text {
  color: red;
  font-size: 25px;
  font-weight: bold;
  border: 1px solid blue;
}

selector {
  @include mixin-name;
}

===

@mixin special-text {
  @include important-text;
  @include link;
  @include special-border;
}

===

@mixin bordered($color, $width) {
  border: $width solid $color;
}

.myArticle {
  @include bordered(blue, 1px);  // Call mixin with two values
}

.myNotes {
  @include bordered(red, 2px); // Call mixin with two values
}

```

### @extend 引用

```
.button-basic  {
  border: none;
  padding: 15px 30px;
  text-align: center;
  font-size: 16px;
  cursor: pointer;
}

.button-report  {
  @extend .button-basic;
  background-color: red;
}

.button-submit  {
  @extend .button-basic;
  background-color: green;
  color: white;
}
```













