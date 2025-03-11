```
Business Rules（服务器端逻辑）
Script Includes（可复用的代码片段）
REST API（如何用 ServiceNow 处理 API 请求）
Table Relationships（如何管理不同表之间的数据关系）
```

```
servicenow portal design
	. https://www.youtube.com/watch?v=QAjxTAt7d30
	. https://www.youtube.com/watch?v=d2-Ykh3gWvw&list=PLn3f4cT59y6epFfIFCks-YdsDM1VixHgS&index=1
	
看地图
```

```
你好， 我想确认一下我的 Offer Letter 是否可以提供？

Hello, I would like to confirm whether my Offer Letter is available?
```



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

`stats.do` 是 ServiceNow 的 **系统统计信息页面**，主要用于 **性能监控、调试和系统健康检查**。它会显示当前 ServiceNow 实例的各种系统参数、缓存使用情况、数据库连接、节点信息等。

```
https://dev204508.service-now.com/stats.do  // 信息
```

```
https://dev204508.service-now.com/sp  // home
```

```
https://dev204508.service-now.com/   // 登入 kJbd$*nUR3B5
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



```
在 ServiceNow 的搜索框里，使用 * 号是通配符，表示模糊匹配。

*laptop → 搜索包含“laptop”的数据（比如 "Dell Laptop", "My laptop is new"）。
laptop* → 搜索以“laptop”开头的数据（比如 "laptop model", "laptop123"）。
*laptop* → 搜索任意位置包含“laptop”的数据（比如 "My laptop is new", "Buy a laptop now"）。
!*laptop → 搜索不包含“laptop”的数据。
!*laptop 适用于 排除某个关键词 的搜索，意思是「查找所有不包含 'laptop' 的数据」。
```



```
代码论坛中的讨论：在代码论坛上，开发者们分享他们遇到的问题、提供不同的解决方法或建议，大家根据自己的经验来分析和讨论这些问题的根本原因，最终得出最有效的解决方案。

Root Cause Analysis（RCA）：类似的，Root Cause Analysis 也是一个深入分析问题的过程。在 ServiceNow 的 Problem Management 中，IT 团队会收集数据、分析症状，提出可能的根本原因，并记录这个分析过程，就像论坛上的讨论一样，目标是找到问题的源头。
```



```
Incident 是单个故障或问题，通常是即时的，快速处理。
Problem 是多个 Incident 引起相同或相似问题的集合，用来查找和处理根本原因。
```



### ===========

### 功能

```
System UI - Welcome Page Content // 显示信息
```

```
System Properties - Basic Configuration UI16 // 更换 logo
```



### ===========

### 学习进度

```
1. 明白什么是ITSM，类似高级版的Todo Task。
2. 更换Logo，Basic 16 // 信息
3. 简单代码快速创建
4. List save filter 重复使用 Filter
5. Email Notifications (自动化)
6. 创建 knownledge 文章 && Import 文章 && Attachment link (Approved) 下载文章
7. roles 查看自己有什么权限
8. Process flow (state is new) + 实现自动流转（比如 24 小时没人处理就自动 On Hold）
9. system definition - table & columns (创建新的database) [玩]
10. Problem table （Root Cause Analysis, RCA）
11. Change Management
12. Flow （Incident Priority 自动化分配人员）
13. Client Script
14. Fix Script 【修复小问题的Script】
15. Request management + Work Flow 【50%】

让不同角色只能更改特定状态（比如客户不能直接改 Resolved）
触发通知（状态变更时发送邮件或 Slack 提醒）
```

```
sys_properties.list
```



#### Problen RCA

```
📝 示例 1：邮件服务器频繁崩溃
Problem（问题）： 公司邮件服务器频繁崩溃，导致员工无法正常收发邮件。

📌 Root Cause Analysis (RCA) 填写：

Root Cause（根本原因）: 服务器的存储空间不足，导致邮件服务器无法正常运行。
Fix（修复方案）: 增加服务器存储空间，并配置磁盘监控告警。
Workaround（临时解决方案）: 清理旧邮件日志，临时释放空间，使邮件服务器恢复运行。
Lessons Learned（经验教训）: 设置磁盘使用率监控，避免类似情况再次发生。
📝 示例 2：用户无法访问公司 VPN
Problem（问题）： 许多员工报告在远程工作时无法连接 VPN，影响正常办公。

📌 Root Cause Analysis (RCA) 填写：

Root Cause（根本原因）: VPN 服务器上的证书已过期，导致所有连接请求被拒绝。
Fix（修复方案）: 重新申请并安装新的 VPN 证书，同时配置自动提醒功能。
Workaround（临时解决方案）: 手动分发本地 VPN 访问密钥，允许部分关键用户访问。
Lessons Learned（经验教训）: 定期检查所有证书的有效期，提前更新，避免影响业务。
📝 示例 3：网站访问速度极慢
Problem（问题）： 客户反馈公司官网加载速度极慢，影响用户体验。

📌 Root Cause Analysis (RCA) 填写：

Root Cause（根本原因）: 数据库查询没有加索引，导致查询时间过长，占用大量服务器资源。
Fix（修复方案）: 在数据库表中添加索引，并优化查询语句，减少查询时间。
Workaround（临时解决方案）: 部分数据改为缓存，提高页面加载速度。
Lessons Learned（经验教训）: 在新功能上线前进行数据库性能测试，确保查询效率。
```



#### Flow

```
Trigger
Trigger: Created or Updated
Table: Incident
Condition: none
Run Trigger: For every update

==

Flow Logic
Duration : explicit duration 
Wait for:00 h 00 m 30 s 
During the following schedule : 24 x 7

Action
Action: Update Record
Record: INC0010014
Table: Incident
Fields: State   /  On Hold
```

```
// incident 自动分配人员
1️⃣ Trigger:

Created or Updated
Table: Incident [incident]
Condition: Priority is 1 - Critical
Run Trigger: Once

2️⃣ Action: "Update Record"

Action: "Update Record"
Record: Trigger - Record Created or Updated➛Incident Record
Table: Incident [incident]
Fields:
	Assigned to - Software Manager
```



#### & 解释

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

#### & 创建

```
Change Management -> Create -> All -> Normal
```

#### & 解释

```
什么时候使用 Request → New 和 Service Catalog → New：
Request → New(Service Catalog)

用于创建不通过服务目录的请求。例如，用户想要手动创建某个请求，可能不适用任何预定义的服务目录项。
这种方式会直接创建 Request 记录，但不一定包含具体的服务项。
Service Catalog → New：

当用户需要请求 Service Catalog 中的服务、软件、硬件、访问权限等时，会通过 Service Catalog 提交请求。
通过这种方式提交的请求会自动创建一个 Request 记录，并在 Requested Items 中创建相应的项。
```

#### & 解释

```
是的，你的理解是对的！在 ServiceNow 的 Email Notifications 中，你设置的条件 priority = changes to = 1 critical，意味着 当某个 Incident 任务的优先级更改为 "1 - Critical" 时，系统会自动触发通知。

你在 System Logs → Emails 看到的信息，说明 ServiceNow 已经成功触发了邮件通知。这些日志可以帮助你确认邮件是否成功发送，或者是否有任何错误导致邮件未能发出。

如果你想进一步测试：

尝试更改一个 Incident 的优先级，看邮件是否发送成功。
检查 "Who will receive" 设置，确认通知的收件人是否正确。
查看邮件模板，确保邮件的内容和格式符合你的预期。
如果你有更具体的问题，或者想优化通知规则，可以继续调整 Conditions 或者 Recipients 设置！🚀
```



#### Client Script

| **方法** | **颜色** | **用途** |
| -------- | -------- | -------- |

| `g_form.addErrorMessage()` | 🔴 红色 | 重要错误，需要用户修正 |
| -------------------------- | ------ | ---------------------- |

| `g_form.addWarningMessage()` | 🟠 橙色 | 警告信息，提醒用户注意 |
| ---------------------------- | ------ | ---------------------- |

| `g_form.addInfoMessage()` | ✅ 绿色 | 普通信息，提示操作成功 |
| ------------------------- | ------ | ---------------------- |

| `g_form.showFieldMsg()` | 🔴🔵🟠  | 在字段下方显示错误或提示 |
| ----------------------- | ---- | ------------------------ |

| `g_form.clearMessages()` | 🚀 清除 | 清除 `addErrorMessage` 等消息 |
| ------------------------ | ------ | ----------------------------- |

```javascript
g_form.setMandatory('field_name', true);  // 将字段设为必填
g_form.setMandatory('field_name', false); // 取消必填
```

```javascript
function onSubmit() {
    if (!g_form.getValue('short_description')) {
        g_form.flash('short_description', 'red', 3000);
        alert('请填写 Short Description！');
        return false; // 阻止提交
    }
    return true;
}
```



```javascript
// 01
// onChange 当priority 是高级就出现alert

function onChange(control, oldValue, newValue, isLoading, isTemplate) {
   if (isLoading || newValue === '') {
      return;
   }

   //Type appropriate comment here, and begin script below

   if(newValue == '1'){
	alert("You are going to create P1 Incident");
   }  
}
```

```javascript
// 02
// 自动填 Caller

// name : Set Caller
// table: Incident
// type: onLoad

function onLoad() {
   //Type appropriate comment here, and begin script below
   
	if(g_form.isNewRecord()){
		var user = g_user.userID;

		g_form.setValue('caller_id', user);
	}
}
```

```javascript
// 03

function onChange(control, oldValue, newValue, isLoading) {
    if (isLoading) return;  // 忽略加载时的变化

    if (control.name == 'priority' && newValue == '1') {  // 假设 '1' 表示高级
        // 设置分配给 Software Manager（假设 Software Manager 的用户 ID 为 'software_manager_id'）
        g_form.setValue('assigned_to', 'software_manager_id');
    }
}
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

### Flow Designer

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

### 安装

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

```
Assign role
inbound action
gmail
```



### ===========

### 询问

```
1. Wifi 密码

```

===========

带

```
1. 口罩
2. 笔
3. 书
4. hard disk
5. 电话
6. 充电
7. 水
8. 包
9. 眼镜
```

