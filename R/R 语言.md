# R 语言

https://www.bilibili.com/video/BV1YD421P7Py/?p=4&spm_id_from=pageDriver&vd_source=98bed7c6ffbd4c5daae519aceb54cc51

### 加法

```
1:5+6:10 #两个相加
c(1,3,6,10,15)+c(0,1,3,6,10) #两个相加
sum(1:5) #1-5所有数字之和
median(1:5) #1-5的中间值
```

### 减法

```
c(2,3,5,7,11,13)-2 #每个元素减2
```

### 乘法

```
-2:2*-2:2 #每个原声相乘
```

### 除法

```
1:10/3 #除法
1:10%/%3 #整数除法
1:10%%3 #余数
```

### Factorial

```
factorial(5) #5!=5x4x3x2x1=120
```

### 关系运算符

```
c(3,4-1,1+1+1)==3 #TRUE TRUE TRUE
1:3!=3:1 #TRUE FALSE TRUE
(1:5)^2>=16 #FALSE FALSE FALSE TRUE TRUE
sqrt(2)^2==2 #FALSE
```

### 赋值

```
x <- 1:5
y = 6:10
```

```
x+2*y-3
```

### 全局变量赋值

```
x <<- sqrt(4)
```

### 使用assign函数赋值

```
assign("变量名",9^3+10^3)
assign("变量名",9^3+10^3,globalenv()) #globalenv()是全局变量的意思
```



















