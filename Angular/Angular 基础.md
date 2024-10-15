# Angular

[Angular 官网]: https://angular.io/guide/setup-local

`Angular`是一个前端框架，用于构建客户端（前端）的Web应用程序。它主要关注于用户界面和用户体验，提供了一套工具和结构，帮助开发人员在浏览器中构建交互式的Web界面。虽然Angular本身是一个前端框架，但是它可以与后端技术（如Node.js、Java、Python等）结合使用，以构建完整的Web应用程序。

`Angular`是一个流行的前端JavaScript框架，用于构建动态Web应用程序。它由Google开发和维护，提供了一套工具和功能，帮助开发人员构建单页Web应用程序（SPA）和其他复杂的Web应用程序。Angular提供了诸如数据绑定、组件化、路由管理、依赖注入等功能，使得开发人员可以更轻松地管理和维护他们的Web应用程序。通过使用Angular，开发人员可以更高效地构建响应式、可维护和可扩展的Web应用程序。

### ✍ 安装 **Angular** 的步骤

```cmd
npm install -g @angular/cli

ng v

ng new <project-ame>
```

```
ng new <project-ame> --no-standalone   (module.ts) 安装这个
```

```
ng serve
```

### 快速构造组件

```
ng generate component servers
```

### 安装axios （如有需要）

```
ng install axios
```



# 基础

## ⭐  基本使用

##### ⭐ 绑定数据

```
title="{{ name }}"
```

```
[title]="name"
```

```
[title]="'This is my ' + name"
```



##### ⭐ 按钮绑定

```html
<button (click)="onClickFUnction()"></button>
```



##### ⭐ Foreach

```
*ngFor="let item of lists"
```

```
*ngFor="let item of lists; index as i"
```

```html
<ng-template ngFor let-item [ngForOf]="lists" let-i="index" let-odd="odd">

</ng-template>
```

```html
<ng-template ngFor let-item [ngForOf]="items">
  <div>{{ item }}</div>
</ng-template>
```



##### ⭐ If

```
*ngIf="isOpen"
```

```html
<div *ngIf="age >= 18; else forChildren">
	<p>大人</p>
</div>
<ng-template #forChildren>
	<p>小孩子</p>
</ng-template>
```

```html
<div *ngIf="age >= 18; else ifTeenager">
  <p>大人</p>
</div>
<ng-template #ifTeenager>
  <div *ngIf="age >= 13; else forChildren">
    <p>青少年</p>
  </div>
</ng-template>
<ng-template #forChildren>
  <p>小孩子</p>
</ng-template>
```



##### ⭐ If Button

```html
<button *ngIf="hasMore; else noMore" (click)="loadMore()">
	<p>加载更多</p>
</button>
<ng-template #noMore>
	<p>完了</p>
</ng-template>
```



##### *⭐ ngModel*

[ngModel 官网文档]: https://angular.io/api/forms/NgModel#description
[ngModel 视频教学]: https://www.bilibili.com/video/BV1R54y1J75g?p=20&amp;spm_id_from=pageDriver&amp;vd_source=98bed7c6ffbd4c5daae519aceb54cc51

✎ *需要在Module文件引入*

```javascript
import { FormsModule } from '@angular/forms'

imports:[
	... ,
	FormsModule,
]
```

*ngModel 使用*

```html
<input [(ngModel)]="name" required /> 
```

```
name: string = "Hoo";
```

*基本用在密码长度、合适、太短了、太长了*

```html
<input [(ngModel)]="name" (ngModelChange)="handleNameChange()" required /> 
```

*$Event*

```html
<input (ngModelChange)="handleNameChange($event)" required /> 
```

```javascript
handleNameChange(e:any){
	console.log(e.target.value)
}
```

*事件绑定 (模板变量)*

```html
<input #userName (ngModelChange)="handleNameChange($event)" />
<button (click)="getUserName(userName.value)">获取userName</button>
```

```
getUserName(v:string){
	console.log(v)
}
```



##### ⭐⭐⭐  *ReactiveFormsModule* 动态表单

*引用*

```
import { FormsModule  , ReactiveFormsModule } from '@angular/forms';

imports:[
	... ,
	FormsModule,
	ReactiveFormsModule
]
```

*在 `component` 引用*

```
import { FormControl } from '@angular/forms'
```

*使用*

```javascript
age: FormControl = new FormControl('')
```

*前端*

```html
<input type="text" [formControl]="age"
<p>{{ age.value }}
```

*方法*

```html
<button (click)="ageChangeFUnction()">长大</button>

ageChangeFUnction(){
	this.age.setValue(18)
}
```



⭐ *FormGroup*

```
import { FormControl, FormHroup } from '@angular/forms'

loginForm:FormGroup = new FormGroup({
	userName: new FormControl(''),
	password: new FormControl(''),
})
```

*前端*

```html
<form [formGroup]="loginForm">
	<label>
    	账号:
        <input type="text" formControlName="userName" />
    </label>
    <label>
    	密码:
        <input type="text" formControlName="password" />
    </label>
    <button (click)="subFormFUnction()">
        提交
    </button>
</form>
```



### 👺 自定义的验证方法

`FormBuilder` 是一个 Angular 提供的用于简化表单组件中创建表单控件的辅助工具类。

`Validators` 是一个提供常用验证器的工具类，用于在表单控件中执行验证。

```javascript
import { FormControl, FormGroup, FormBuilder, Validators } from '@angular/forms'

constructor(private fb: FormBuilder) { }

  valiDataForm: FormGroup = this.fb.group({
    userName: [
      '',
      [Validators.required, Validators.maxLength(18), Validators.minLength(6)],
    ],
    password: ['', [this.passwordVal]],
    phone: ['', [Validators.required, this.phoneVal]],
  });

  passwordVal(password: FormControl): object {
    const value = password.value || '';
    if (!value) {
      return { msg: '请输入密码' };
    } else {
      const valid = value.match(/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/);
      return valid ? {} : { msg: '密码至少包含6位数字或英文，长度6-20' };
    }
  }

  phoneVal(phone: FormControl): object {
    const value = phone.value || '';
    if (!value) return { msg: '请输入手机号' };
    const valid = value.match(/[0-9]{11}/);
    return valid ? {} : { msg: '联系电话必须是11位数字' };
  }

  subFormFunction() {
    console.log(this.valiDataForm.get('userName')?.value);
    console.log(this.valiDataForm.get('password')?.value);
    console.log(this.valiDataForm.get('phone')?.value);
  }
```

*前端*

```html
<form [formGroup]="valiDataForm">

    <label>
        账号: <input type="text" formControlName="userName" />
    </label>

    <p *ngIf="valiDataForm.get('userName')?.errors?.['required']">请输入账号</p>
    <p *ngIf="valiDataForm.get('userName')?.errors?.['minlength']?.requiredLength
        ||valiDataForm.get('userName')?.errors?.['maxlength']?.requiredLength">账号长度在6-18位之间</p>

    <br />

    <label>
        密码: <input type="text" formControlName="password" />
    </label>

    <p *ngIf="valiDataForm.get('password')?.errors?.['msg']">{{ valiDataForm.get('password')?.errors?.['msg'] }}</p>

    <br />

    <label>
        手机号: <input type="text" formControlName="phone" />
    </label>

    <p *ngIf="valiDataForm.get('phone')?.errors?.['msg']">{{ valiDataForm.get('phone')?.errors?.['msg'] }}</p>


    <br />

    <button (click)="subFormFunction()">
        提交
    </button>
</form>
```



## ⭐  组件交互

#### @Input

父组件传递给子组件数据

```javascript
//父组件
<app-son [name]="'Hoo'"></app-hello>

//子组件
import { Component, Input } from '@angular/core';
@input()
name: string
```

#### @Output

父组件给子组件传递一个事件，子组件通过 `@output` 弹射触发事件

```javascript
//父组件
<app-son (addList)="addListFunction($event)"></app-hello>

list:Array<string> = ['Angular']
addListFunction(str:string){
	this.list?.push(str)
}

//子组件
import { Component, Output, EventEmitter } from '@angular/core';
@output() addList = new EventEmitter()

addBtnFun(){
	this.addList.emit('vue')
}
```

#### @ViewChild()

获取元素的属性、调用子元素的方法等。`@ViewChild()` 的作用就是允许你在组件类中引用模板中的元素，并与之进行交互。

```javascript
//父组件
<app-son #mychild [name]="'Hoo'"></app-hello>
<button (click)="addFun()">获取子组件的方法</button>

//父组件 后端
import { Component, ViewChild } from '@angular/core';

@VIewChild('mychild') child: any;

list:Array<string> = ['Angular']

addFun(){
	this.child.addBtnFun()
}


//子组件
import { Component, Output, EventEmitter } from '@angular/core';
@output() addList = new EventEmitter()

addBtnFun(){
	this.addList.emit('vue')
}
```



## ⭐   Injectable (Service)

`依赖注入`

安装 `service`

```
ng generate service (serviceName) list
```

在 `modeule` 引入

```javascript
import { ListService } from './server/list.service'

providers:[
	... ,
	ListService ,
]
```

`component `  使用

```javascript
//引入
import { ListService } from '../server/list.service'

construtor(private listService: ListService) { }

ngOnInit():void {
	// console.log(this.listService)
	this.list = this.listService.getList()
}

addNode(){
	this.listService.addList('Node')
}
```

```
 constructor(
    private listService: ListService,
    private fb: FormBuilder
  ) { 
    // 你可以在这里使用 listService 和 fb
  }
```

`Service` 文件

```javascript
//例子
export class ListService {
	list:Array<string>=['Angular','React','Vue']
	
	getList(){
		return this.list;
	}
	
	addList(str:string){
		this.list.push(str)
	}
}
```



## ⭐   Route

`app-routing.module.ts`

```javascript
// 例子
import { HomeComponent } from './home/home.component'
import { SonComponent } from './son/son.component'

const routes: Routes = [
	{
		path: '',
		component: HomeComponent
	},
	{
		path: 'son',
		component: SonComponent
	},
]
```

`app.component.html`

```html
<router-outlet></router-outlet>
```

`其他使用`

```html
<a [routerLink]="['']">Home</a>
<a [routerLink]="['/son']">Son</a>
```

### children

```javascript
// 例子
import { HomeComponent } from './home/home.component'
import { SonComponent } from './son/son.component'
import { ListComponent } from './list/list.component'

const routes: Routes = [
	{
		path: '',
		component: HomeComponent
	},
	{
		path: 'son',
		component: SonComponent
		children: [
			{
				path: 'list',
				component: ListComponent
			},
		]
	},
	{
		path:'**',
		component: 404ErrorPage
	}
]
```

`前端` localhost/son/list

```html
<a [routerLink]="['/son/list']">List</a>

<router-outlet></router-outlet>
```



### 路由传参

`queryParams` 方法

```html
<a [routerLink]="['/son']" [queryParams]="{id:1, name:'Hoo'}">Son</a>
```

`Son 的 component`

```javascript
import { ActivateRoute } from '@angular/router';

constructor(private routerinfo:ActivaRoute) { }

ngOnInit(){
	// id为参数名字
	this.id = this.routerinfo.snapshot.queryParams["id"]
}
```



`params` 方法

```javascript
{
	path: 'son/:name',
	component: SonComponent
}

{
	path: 'son/:id/:name',
	component: SonComponent
}
```

```html
<a [routerLink]="['/son','我的名字叫Hoo']">Son</a>
```

```javascript
import { ActivateRoute, Params } from '@angular/router';

constructor(private routerinfo:ActivaRoute) { }

ngOnInit(){
	this.routerinfo.params.subscribe((params:Params) => {
		this.name = params['name']
	})
}
```



## 🍺 Axios （Api）

```javascript
list:Array<any> = [];

ngOnInit():void {
	axios.get('https://www.fastmock.site/mock/323354e56ef21147c3f550e18435baa1/api/getList').then( res => {
		this.list = res.data.data
	})
}
```

其他例子

```javascript
list:Array<any> = [];
page:number = 0;

ngOnInit():void {
	axios.get('https://www.fastmock.site/mock/323354e56ef21147c3f550e18435baa1/api/getList').then( res => {
		let list:Array<any> = res.data.data
		for(let index = 0 ; index < list.length; index++){
			this.list.push(list.slice(index, index + 10))
			index += 9
		}
	})
}
```

```html
<tr *ngIf="let item of list[page]">
	<td>{{  item.id }}</td>
	<td>{{  item.title }}</td>
</tr>
```



## 🌛 HttpClientModule 

```javascript
import { HttpClientModule } from '@angular/common/http';

@NgModule({
  declarations: [
    // 声明的组件
  ],
  imports: [
    // 其他模块
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
```

然后，您可以在您的组件中使用 HttpClient 来发送请求并处理响应。这里是一个简单的示例：

```javascript
import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-invoices',
  templateUrl: './invoices.component.html',
  styleUrls: ['./invoices.component.css']
})
export class InvoicesComponent implements OnInit {
  invoices: any[] = [];

  constructor(private http: HttpClient) { }

  ngOnInit(): void {
    this.getInvoices();
  }

  getInvoices(): void {
    this.http.get<any>('/api/get_all_invoice')
      .subscribe(
        (response) => {
          // 更新组件中的发票数据
          this.invoices = response.invoices;
        },
        (error) => {
          console.error('Error fetching invoices:', error);
        }
      );
  }
}
```



















