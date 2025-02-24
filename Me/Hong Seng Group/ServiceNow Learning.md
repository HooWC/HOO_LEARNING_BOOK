### 基础

```
职位的官方名称
Software Developer & IT Support

==
Software Engineer 
```

```
ServiceNow
email:business
pass: 9096844HWChwc&newboxx
```

```
ServiceNow Developer
```

```
SD 我的user id
6816f79cc0a8016401c5a33be04be441
```



### ===========

### **ITSM 的核心功能**

ITSM 主要有四个核心模块：

| **模块**                            | **作用**                                         |
| ----------------------------------- | ------------------------------------------------ |
| **Incident Management（事件管理）** | 处理 IT 故障（电脑坏了、网络断了）               |
| **Problem Management（问题管理）**  | 解决重复发生的 IT 问题（比如公司 WiFi 总是掉线） |
| **Change Management（变更管理）**   | 控制 IT 变更（比如更新服务器系统）               |
| **Request Management（请求管理）**  | 处理 IT 需求（申请新电脑、安装软件）             |

### ===========

###  **如何创建 Assignment Group**

📌 **步骤**： 1️⃣ **打开 ServiceNow**，在左侧导航栏搜索 `Groups`。
2️⃣ **进入 `User Administration > Groups`**。
3️⃣ **点击 `New` 创建一个新的 Group**。

### ===========

** `Roles` 在 Group 首页 vs. 在 Group Members 里，有什么区别？**

**📌 1. Group 首页的 `Roles`（作用于整个 Group）**

- 这里添加的 `Roles` **适用于整个 Group**，即**所有 Group Members 都会继承这些角色**。
- **✅ 推荐做法：** **如果整个 `Group` 里的所有人都需要 `ITIL` 角色**，你可以在这里添加 `ITIL` 角色。

------

**📌 2. Group Members 里的 `Roles`（作用于单个成员）**

- 这里的 `Roles` 只会**作用于该 Group 里的某个特定成员**。
- **✅ 推荐做法：** 如果**你不想让所有 Group 成员都继承 `ITIL` 角色**，你可以在 `User Administration > Users` 里**单独给某个用户添加 `ITIL`**。

### ===========



### ===========

### 学习进度

```
1. 明白什么是ITSM，类似高级版的Todo Task。
```

```
Incident Management（事件管理） 目标是快速解决问题

Problem Management（问题管理） 处理的是 长期性 或 根本性 的问题

Incident Management（事件管理）：
处理时间通常较短，重点是快速修复。
可能在几分钟或几小时内解决。

Problem Management（问题管理）：
处理时间较长，因为需要深入调查和分析根本原因。
可能需要几天、几周或更长时间才能彻底解决问题。
```

```
Change Management -> Create -> All -> Normal
```

```
什么时候使用 Request → New 和 Service Catalog → New：
Request → New(Service Catalog)

用于创建不通过服务目录的请求。例如，用户想要手动创建某个请求，可能不适用任何预定义的服务目录项。
这种方式会直接创建 Request 记录，但不一定包含具体的服务项。
Service Catalog → New：

当用户需要请求 Service Catalog 中的服务、软件、硬件、访问权限等时，会通过 Service Catalog 提交请求。
通过这种方式提交的请求会自动创建一个 Request 记录，并在 Requested Items 中创建相应的项。
```



### ===========

### Script 

```javascript
gs.log("test","Hoo")

System Logs -> All
System Definition -> Script Background

gs.info
gs.error
gs.print
name.query();
name.setLimit(10);
name.orderBy("number");
name.addQuery("active=true")
```

#### 基础 print 总数

```javascript
// GlideRecord
// 你可以把 GlideRecord 想象成一个用于查询、更新、插入数据的 API。通过这个对象，你可以访问指定表的数据。

var grInc = new GlideRecord("incident");  // 创建一个 GlideRecord 对象，指向 'incident' 表
grInc.query();  // 执行查询，获取所有的 incident 表记录

gs.print(grInc.getRowCount());  // 输出该表中记录的总行数
```

#### 基础 print `table`

```javascript
var grInc = new GlideRecord("incident");
grInc.query();

//gs.print("Total Records: " + grInc.getRowCount());  // 打印记录总数
//gs.print("Has Next: " + grInc.hasNext());  // 打印是否有下一条记录 // True

while(grInc.next()) {
    gs.print("Incident Number: " + grInc.number);  // 打印每条记录的编号
    gs.print("Short Description: " + grInc.short_description);  // 打印每条记录的简短描述
    // 你可以根据需要打印更多字段
}
```

#### 好看的 `table` 设计

```javascript
var grInc = new GlideRecord("incident");
grInc.query();  // 查询所有记录

// 打印表头
gs.print("------------------------------------------------------");
gs.print("| Incident Number    | Short Description          |");
gs.print("------------------------------------------------------");

// 遍历所有记录并打印每一条记录的编号和简短描述
while(grInc.next()) {
    // 使用 format() 或手动拼接字符串，确保字段对齐
    var incidentNumber = grInc.number;
    var shortDescription = grInc.short_description;

    // 确保短描述长度不超过 25 个字符，超过部分用 "..." 代替
    if (shortDescription.length > 25) {
        shortDescription = shortDescription.substring(0, 25) + "...";
    }

    // 打印每一行，确保列对齐
    gs.print("| " + incidentNumber.padEnd(18) + " | " + shortDescription.padEnd(25) + " |");
}

gs.print("------------------------------------------------------");
```

#### 寻找 `user id`

```javascript
var grUser = new GlideRecord('sys_user');
grUser.addQuery('email', 'wengchinbusiness@gmail.com'); // 替换为实际的电子邮件地址
grUser.query();
if (grUser.next()) {
    gs.print('The sys_id of the caller is: ' + grUser.sys_id); // 输出 sys_id
} else {
    gs.print('No user found with the given email.');
}
```

#### 创建 `Incident`

```javascript
var grInc = new GlideRecord('incident'); // 创建 GlideRecord 实例，指向 incident 表
grInc.initialize(); // 初始化一个新记录

// 设置字段值
grInc.short_description = 't:Hoo, My computer is not working';
grInc.description = 'The computer is showing a blue screen and not starting properly.';
grInc.caller_id = '6816f79cc0a8016401c5a33be04be441'; // 你需要提供一个有效的 sys_id，指代呼叫者
grInc.category = 'Software';  // 示例：设置 category 字段
grInc.subcategory = 'Enail';  // 示例：设置 subcategory 字段
grInc.service = '';  // 可选，根据需要设置服务
grInc.service_offering = '';  // 可选，设置服务提供方式
grInc.configuration_item = '';  // 可选，设置配置项
grInc.channel = '-- None --';  // 设置渠道
grInc.state = 1;  // 设置状态（1 = New）
grInc.impact = 3;  // 设置影响程度（3 = Low）
grInc.urgency = 3;  // 设置紧急程度（3 = Low）
grInc.priority = 5;  // 设置优先级（5 = Planning）
grInc.assignment_group = '';  // 可选，设置分配组
grInc.assigned_to = '';  // 可选，设置负责人

// 插入记录到数据库
grInc.insert();  // 将新记录插入到 incident 表中

// 输出新创建的 incident 编号
gs.print('New Incident Created with Number: ' + grInc.number); // 输出新创建的 incident 编号
```

#### 创建 `Problem`

```javascript
var grProblem = new GlideRecord('problem'); // 'problem' 表是用来存储问题记录的
grProblem.initialize(); // 初始化一个新记录

// 使用点符号设置字段值
grProblem.short_description = 't:Hoo, Example Problem Description'; // 设置简短描述 // Problem statement
grProblem.description = 'Detailed description of the problem'; // 设置详细描述
grProblem.caller_id = '6816f79cc0a8016401c5a33be04be441'; // 使用 sys_id 来指代呼叫者
grProblem.category = 'Software';  // 设置问题的类别
grProblem.subcategory = 'Email';
grProblem.state = 1;  // 设置状态，1 表示 New
grProblem.impact = 3;  // 设置影响度，3 代表低
grProblem.urgency = 3;  // 设置紧急度，3 代表低
grProblem.priority = 5;  // 设置优先级，5 代表 Planning
grProblem.assignment_group = '';  // 设置分配组（可以为空）
grProblem.assigned_to = '';  // 设置负责人（可以为空）

// 插入记录到数据库
var problemSysId = grProblem.insert(); // 插入新记录并返回其 sys_id

// 输出新创建的 Problem 编号
gs.print('New Problem Created with sys_id: ' + problemSysId);
```

#### 创建 `Change`

```javascript
var grChange = new GlideRecord('change_request');  // 'change_request' 表是用来存储变更请求的
grChange.initialize();  // 初始化一个新的变更请求记录

// 设置字段值
grChange.short_description = 'T:Hoo, Test Change Request: System Upgrade';  // 简短描述
grChange.description = 'T:Hoo, This change request is to perform a system upgrade for the database.';  // 描述
grChange.requested_by = '6816f79cc0a8016401c5a33be04be441';  // 提出变更请求的用户的 sys_id
grChange.category = 'Other';  // 类别
grChange.service = '';  // 可选：服务
grChange.service_offering = '';  // 可选：服务提供方式
grChange.configuration_item = '';  // 可选：配置项
grChange.priority = 4;  // 优先级（4 - Low）
grChange.risk = 'Moderate';  // 风险
grChange.impact = 3;  // 影响程度（3 - Low）
grChange.model = 'Normal';  // 模型
grChange.type = 'Normal';  // 类型
grChange.state = 1;  // 状态（1 = New）
grChange.conflict_status = 'Not Run';  // 冲突状态
grChange.conflict_last_run = '';  // 冲突最后运行时间（可选）
grChange.assignment_group = '';  // 可选：分配组
grChange.assigned_to = '';  // 可选：负责人

// 插入记录到数据库
grChange.insert();  // 将新的变更请求记录插入到 change_request 表中

// 输出新创建的变更请求编号
gs.print('New Change Request Created with Number: ' + grChange.number);  // 输出新创建的变更请求编号
```



### ===========

Flow Designer

```
Playbook - 主要用于安全响应（Security Incident Response）。
Flow ✅ - 完整的工作流，适用于审批、通知、数据处理等。
Subflow - 用于封装可复用的流程，类似于子流程。
Action - 用于创建可复用的单个操作，类似于 API 或函数。
Decision Table - 用于复杂的条件判断和规则决策。
```



### ===========

### 其他

```
Assignment Lookup Rules
Assignment 
User Administration -> group // 创建 group 和 添加 member
```



```
Assignment Rules（自动分配任务）
Service Catalog（创建用户可以提交的请求）
Workflow Automation（自动化流程，比如审批）
Reports & Dashboards（数据分析）
```



```
Problem Management（问题管理）
这个模块帮助你识别和解决根本原因的问题，防止重复的事件发生。你可以学习如何创建和管理问题、进行根本原因分析，并最终解决这些问题。

Change Management（变更管理）
变更管理是ITSM的一个核心部分，帮助管理IT基础设施的变更，确保变更不会对服务造成意外影响。你可以学习如何创建变更请求、评估风险、实施变更以及后续跟踪。

Request Management（请求管理） Service Catalog
这个模块用于管理用户的服务请求，如软件安装、硬件更换等。你可以学习如何创建、处理和跟踪请求。

Configuration Management Database (CMDB)
CMDB是管理IT资产和配置项的核心工具，它能够帮助你了解和管理组织中所有IT资源的状态和关系。你可以了解如何维护和更新CMDB，确保它反映正确的资源和配置。

Service Catalog（服务目录）
服务目录提供了一个自助式的界面，供最终用户浏览和请求各种IT服务。你可以学习如何创建、配置和管理服务目录中的项，提供用户友好的服务体验。

Knowledge Management（知识管理）
知识管理是帮助组织捕捉、存储和共享知识的一种方式。通过创建知识库，用户可以快速查找解决方案。你可以学习如何创建、审核和发布知识文章。

Service Level Management（服务级别管理）
该模块帮助管理和跟踪服务级别协议（SLA），确保提供的服务符合约定的标准。学习如何定义SLA、跟踪性能和生成报告。
```



```
聊天功能
MSP
```





### ===========

安装

```
plugins -> advanced work ass -> Agent Chat x
```

### ===========

### 要学

```
ServiceNow
Power BI

==

Visual Basic
ERP
```

### ===========

### 询问

```
1. Wifi 密码

```

