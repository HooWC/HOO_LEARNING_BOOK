# C# SQL Hosting 安装

🦋🦋🦋🦋🦋

## ❄ SQL导出 

右键你的 `table` -> `任务` -> `生成脚步` -> 下一步 -> 选择 `（为整个数据库）` 下一步 -> 点击 `高级` ， 选择 `仅限数据` ， 点击 `另存为脚步文件` -> 下一步 -> 完成



## ❄ SQL 导入

连接你的SQL数据库 ， 在你的代码先 `add-migration` , 上传你的 `model`

打开刚刚下载的SQL文件 ， 名字换成你目前的SQL数据库，点击 `执行` 💘



## ❄ C# Migration

```
add-migration <name>

update-database
```



## ❄ C# Hosting

[myasp.net 官网 Hosting]: https://www.myasp.net/

注册 `myasp.net`

请使用 `UrbanVPN` 注册 `myasp.net` ， 一个电脑的localhost只能注册一个 



以下是 `免费60天` 方法



### ㊗ 网页注册

打开 `Webdeploy` 点击 `Get Publish Setting` 下载文件

在你的 `vs code` 右键你的项目，点击 `public 发布`  ，再点击 `新建配置文件` ， 选择刚刚下载的文件

按发布，输入你的 `myasp.net` 密码 , 等待上传...... 😬



在`myasp` 网站点击你的 `file manager` ，修改文件内容 ， 如下：

`web.config`

```
<?xml version="1.0" encoding="utf-8"?>
<configuration>
  <location path="." inheritInChildApplications="false">
    <system.webServer>
      <handlers>
        <add name="aspNetCore" path="*" verb="*" modules="AspNetCoreModuleV2" resourceType="Unspecified" />
      </handlers>
      <aspNetCore processPath="dotnet" arguments=".\Platform.dll" stdoutLogEnabled="false" stdoutLogFile=".\logs\stdout" hostingModel="inprocess" />
    </system.webServer>
  </location>
</configuration>
<!--ProjectGuid: b9d33727-8907-40aa-a1c8-0379143c2633-->
```



### ㊗ API注册

#### 第一步：

点击 `DATABASES` ， 然后点击 `+ Add Database` 

然后点击 `<···>` 获取连接 `SQL` 代码 😀

如下  `ASP.NET` 

```
"Data Source=SQL5106.site4now.net;Initial Catalog=db_aa57d8_platform;User Id=db_aa57d8_platform_admin;Password=YOUR_DB_PASSWORD"				
```

在你的 `appsettings.json` 配置

```
"ConnectionStrings": {
        "sql-name": "Data Source=SQL9001.site4now.net;Initial Catalog=db_aa7a3f_platform;User Id=db_aa7a3f_platform_admin;Password=9096844hhwwcc"
    }
```



#### 第二步：

打开 `Webdeploy` 点击 `Get Publish Setting` 下载文件

在你的vs code 右键你的项目，点击 `public 发布`  ，再点击 `新建配置文件` ， 选择刚刚下载的文件

按发布，输入你的 `myasp.net` 密码 , 等待上传...... 😀😀😀



#### 第三步：

然后来到 `myasp` 网站 `SSL` 界面， 点击 `Request Free SSL` 按钮 ， 等待 `install`



#### 第四步：

在`myasp` 网站点击你的 `file manager` ，修改文件内容 ， 如下：

`web.config`

```
<?xml version="1.0" encoding="utf-8"?>
<configuration>
  <location path="." inheritInChildApplications="false">
    <system.webServer>
      <handlers>
        <add name="aspNetCore" path="*" verb="*" modules="AspNetCoreModuleV2" resourceType="Unspecified" />
      </handlers>
      <aspNetCore processPath="dotnet" arguments=".\Api_Platform.dll" stdoutLogEnabled="false" stdoutLogFile=".\logs\stdout" hostingModel="inprocess" >
   <environmentVariables>
        <environmentVariable name="ASPNETCORE_ENVIRONMENT" value="Development" />
      </environmentVariables>
      </aspNetCore>
    </system.webServer>
  </location>
</configuration>
<!--ProjectGuid: 9c74e3a3-8ca5-4d51-88c8-f8efad429c13-->
```

`appsettings.Development.json `  这里要换你自己的 `SQL连接` 代码

```
{
    "Logging": {
        "LogLevel": {
            "Default": "Information",
            "Microsoft.AspNetCore": "Warning"
        }
    },
    "AllowedHosts": "*",
    "ConnectionStrings": {
        "Platform": "Data Source=SQL5106.site4now.net;Initial Catalog=db_aa57d8_platform;User Id=db_aa57d8_platform_admin;Password=9096844hwc"
    }
}
```

