# Typescript 🌀

🍉 安装**Typescript**的步骤

```
npm install -g typescript

tsc --version
```

*创建文件 <文件名称>.ts*

转换**Javascript**文件

```
tsc <文件名称>.ts
```

### 📱 启动 `Javascript`代码

```
node main.js
```



1. 基本数据类型：
   - `number`：表示数值，可以是整数或浮点数。
   - `string`：表示字符串。
   - `boolean`：表示布尔值，只有 `true` 或 `false`。
   - `null`：表示一个空值对象，常用于初始化变量为一个空值。
   - `undefined`：表示未定义的值，通常用于初始化变量为未赋值状态。
   - `symbol`：表示唯一的、不可变的值，通常用于对象属性的键。
   - `bigint`：表示任意精度的整数，可以用于表示超出 `number` 类型范围的整数。
2. 复合数据类型：
   - `object`：表示对象类型，包括普通对象、数组、函数等。
   - `array`：表示数组，包含多个元素的列表。
   - `function`：表示函数类型。
   - `tuple`：表示元组类型，可以包含不同类型的固定数量的元素。
   - `enum`：表示枚举类型，用于定义一组命名的常量值。
   - `any`：表示任意类型，可以是任何类型的值，相当于关闭了类型检查。
   - `void`：表示没有返回值的函数。
   - `never`：表示永远不会有返回值的函数，或者抛出异常的函数。
