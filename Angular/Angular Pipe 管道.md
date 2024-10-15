# Angular Pipe ⭐ 

在Angular中，管道（Pipe）是一种用于在模板中转换数据的工具。它们允许你以一种简单的方式对模板中显示的数据进行处理，例如格式化日期、货币、文本转换等。Angular内置了许多常用的管道，比如 `DatePipe`、`UpperCasePipe`、`LowerCasePipe` 等，你也可以创建自定义管道以满足特定需求。

管道通过在HTML模板中使用 `|` 符号来应用，后面跟着管道的名称和可能的参数。

```
<!-- 使用内置的管道 -->
<p>{{ birthday | date }}</p>

<!-- 使用自定义管道 -->
<p>{{ text | customPipe:param1:param2 }}</p>
```

### 使用方法

```
ng genrate pipe <文件名称>
```

##### 创建文件 <文件名称>.pipe.ts

##### 在Module注册文件



### ⭐ 组件代码 Component

```
import { Component } from '@angular/core';

@Component({
  selector: 'app-todo-list-pipe',
  templateUrl: './todo-list-pipe.component.html',
  styleUrl: './todo-list-pipe.component.css'
})

export class TodoListPipeComponent {
  lists: number[] = [1,0,0,0,1,1,0,1,0];
}
```

### ⭐ Pipe 代码

```
import { Pipe } from "@angular/core";

@Pipe({
    name: 'sex'
})

export class SexPipe{
    transform(val:number){
        if(val == 1){
            return '男';
        }else if(val == 0){
            return '女';
        }else{
            return '未知';
        }
    }
}
```

### ⭐ Html 代码

```
<ul>
    <li *ngFor="let item of lists; index as i">
        {{i+1}} - {{item}} - {{item | sex}}
    </li>
</ul>
```

```
{{item | sex : "long"}}
```

### 输出

```
1 - 1 - 男
2 - 0 - 女
3 - 0 - 女
4 - 0 - 女
5 - 1 - 男
6 - 1 - 男
7 - 0 - 女
8 - 1 - 男
9 - 0 - 女
```



# Pipe 其他功能 ⭐ ⭐ ⭐ 

[Pipe 文档]: https://angular.cn/api

```
{{item | lowercase}}

{{item | uppercase}}

{{item | titlecase}}

{{item | slice:0:3 }}

{{item | slice:3 }}

{{Lists | json }}

{{salary | number: '2'}}

{{salary | currency }} //钱

{{salary | currency : 'RM'}} //钱
```

[Date Pipe 文档]: https://angular.cn/api/common/DatePipe

```
{{e.birthday | date }}

{{e.birthday | date:'yyyy-MM-dd HH:mm:ss' }}
```

