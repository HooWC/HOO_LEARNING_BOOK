## Javascript 基础

```javascript
console.log('You are ${age} years old')

.toFixed(2)

document.getElementById("p1").textContent = "Hoo" #给<p>赋值
document.getElementById("p1").onclick = function(){
	username = document.getElementById("myText").value; # input
	document.getElementById("myH1").textContent = `Hello ${username}`; # H1
}

window.prompt("...")
Number(age) #转换
String(age) #转换
Boolean() #转换
```

```javascript
increaseBtn.onclick = function(){
	count++;
	countLabel.textContent = count;
}
```

```javascript
Math.round(4.4) #四舍五入 #4
Math.ceil(4.2) #向上舍入 #5
Math.floor(4.7) #向下舍入 #4
Math.trunc(4.7) #返回整数部分  #4
Math.sign(4) #返回是否为负、空或正  #1 #-1
Math.pow(8,2); #返回 x 的 y 次方值 #64
Math.sqrt(64); #返回 x 的平方根 #8
Math.abs(-4.7); #返回 x 的绝对（正）值
Math.min(0, 150, 30, 20, -8, -200); 
Math.max(0, 150, 30, 20, -8, -200);
Math.random();
Math.random() * 10; # 0 - 10
```

```javascript
<input type="checkbox" id="mycheckBox"/>
if(mychackBox.checked){}

username = "Hoo"
username.charAt(0) #提取第一个字
username.indexOf("o") #寻找 o 的第一个index
username.lastIndexOf("o") #寻找 o 的最后一个index
username.length
username.trim()
username.startsWith(" ") #检查第一个字是不是空格
username.endsWith(" ")
username.includes(" ")

let phoneNumber = "123-456-7890"
phoneNumber.replaceAll("-","/") #123/456/7890

phoneNumber.padStart(15,"0") 前面自动加 15个 0
phoneNumber.padEnd(15,"0") 后面自动加 15个 0

============

slice
const fullname = "Bro Code";
let firstName = fullName.slice(0, 3); #Bro
let lastName = fullName.slice(4, 8); #Code
let lastChar = fullName.slice(-2); #最后 #de
let firstName = fullName.slice(0, fullname.indexOf(" ")); #Bro

============

email slice
const email = "Hoo@gmail.com"
let username = email.slice(0,email.indexOf("@")); #Hoo
let username = email.slice(email.indexOf("@") + 1); #gmail.com

============

.toUpperCase()
.toLowerCase()

============

let fruits = ["apple","orange","banana"];
fruits[2] = "AAA"
fruits.indexOf("Mango") #-1 没有

=============

join
username.join("-")
.join(" ")

=============

sum()

=============

const values = [];

values.push(value);
```

### Password 乱码

```javascript
function generatePassword(length, includeLowercase, includeUppercase, includeNumbers, includeSymbols){
	
	const lovercaseChars = "abcdefghijklmnopqrstuvwxyz";
	const uppercaseChars = "ABCDEFGHIJKLMNOPQRSTUVZXYZ";
	const numberChars = "0123456789";
	const symbolChars = "!@#$%^&*()_+-=";
	
	let allowedChars = "";
	let password = "";
	
	allowedChars += includeLowercase ? lovercaseChars : "";
	allowedChars += includeUppercase ? uppercaseChars : "";
	allowedChars += includeNumbers ? numberChars : "";
	allowedChars += includeSymbols ? symbolChars : "";
	
	if(length <= 0){
		return `(passworrd length must be at least 1)`;
	}
	if(allowedChars.length === 0){
		return `(At least 1 set of character needs to be selected)`;
	}
	
	for(let i = 0; i < length; i++){
		const randomIndex = Math.floor(Math.random() * allowedChars.length);
		password += allowedChars[randomIndex];
	}
	
	return password;
}

const passwordLength = 12;
const includeLowercase = true;
const includeUppercase = true;
const includeNumbers = true;
const includeSymbols = true;

const password = generatePassword(passwordLength, includeLowercase, includeUppercase, includeNumbers, includeSymbols);
```

### Foreach

```javascript
let numbers = [1,2,3,4,5];
numbers.forEach(display);

function display(element){
	console.log(element)
}
```

### Map

```javascript
const numbers = [1,2,3,4,5];
const squ = numbers.map(upperCase);

function upperCase(element){
	return element.toUpperCase();
}
```

### Filter

```javascript
let numbers = [1,2,3,4,5];
let evenNums = numbers.filter(isEven);

function isEven(element){
	return element % 2 === 0;
}

======

let numbers = [15,16,17,18,19,20];
let evenNums = numbers.filter(isEven);

function isEven(element){
	return element >= 18;
}
```

### Reduce

```javascript
# reduce() 方法只返回一个值：函数的累积结果。
const numbers = [175, 50, 25];
document.getElementById("demo").innerHTML = numbers.reduce(myFunc);

function myFunc(total, num) {
  return total - num;
}
```

### Reverse

```javascript
// Create an Array
const fruits = ["Banana", "Orange", "Apple", "Mango"];

// Reverse the Array
const fruits2 = fruits.reverse();
```

### Sort

```javascript
const fruits = ["Banana", "Orange", "Apple", "Mango"];

fruits.sort();
```

### Shift

```javascript
# shift() 删除数组的第一项：
const fruits = ["Banana", "Orange", "Apple", "Mango"];
fruits.shift();
```

### Some

```javascript
# Array.some() 方法会检查数组中是否有元素通过了测试（以函数形式提供）。
const ages = [3, 10, 18, 20];
ages.some(checkAdult);

function checkAdult(age) {
  return age > 18;
}

# true
```

### Splice

```javascript
# splice() 方法可添加或删除数组元素。

// Create an Array
const fruits = ["Banana", "Orange", "Apple", "Mango"];

// At position 2, add "Lemon" and "Kiwi"
fruits.splice(2, 0, "Lemon", "Kiwi");

# Banana,Orange,Lemon,Kiwi,Apple,Mango

=============

// Create an Array
const fruits = ["Banana", "Orange", "Apple", "Mango"];

// At position 2, remove 2 elements
fruits.splice(2, 2);

# Banana,Orange
```

### 箭头函数

```javascript
const hello = (name) => console.log(`Hello ${name}`);

hello("Bro");
```

### Objects

```javascript
const person1 = {
	firstName: "Hoo",
	lastName: "WC",
	age: 24,
	sayHello: function(){
		console.log(`Hi ${this.firstName}`)
	}
}

console.log(person1.firstName);

===========

function Car(make, model, year, color){
	this.make = make,
	this.model = model,
	this.year = year,
	this.color = color
}

const car1 = new Car("Ford", "Mustang", 2024, "red")

console.log(car1.make)
```

### Class

```javascript
class Car {
  constructor(name, year) {
    this.name = name;
    this.year = year;
  }
  
  age() {
    const date = new Date();
    return date.getFullYear() - this.year;
  }
}

const myCar = new Car("Ford", 2014);
document.getElementById("demo").innerHTML =
"My car is " + myCar.age() + " years old.";
```

### async

```javascript
async function myDisplay(){
    const w = await walk();
}

async function myDisplay() {
  let myPromise = new Promise(function(resolve) {
    resolve("I love You !!");
  });
  document.getElementById("demo").innerHTML = await myPromise;
}

myDisplay();

=========

async function myDisplay() {
  let myPromise = new Promise(function(resolve) {
    setTimeout(function() {resolve("I love You !!");}, 3000);
  });
  document.getElementById("demo").innerHTML = await myPromise;
}

myDisplay();
```

### isNaN

```
if (isNaN(prev) || isNaN(current)) return
```

