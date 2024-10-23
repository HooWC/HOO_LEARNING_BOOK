## Maven Spring MVC 基础

超长篇章！学程序 番外篇！

楠哥 教学篇--

[视频在线观看](https://www.bilibili.com/video/BV1G64y127xo?spm_id_from=333.788.videopod.episodes&vd_source=98bed7c6ffbd4c5daae519aceb54cc51)

---------------------------------------------

1. 创建 **Maven / Spring MVC** 项目

2. 如果遇到 **org.springframework** 无法安装的情况 ， [观看安装Tomcat，才可以安装](https://www.youtube.com/watch?v=c3dIEGXLgC4)

3. 配置 文件 / 代码

   **pom.xml**

```xml
<properties>
    <project.build.sourceEncoding>UTF-8</project.build.sourceEncoding>
    <maven.compiler.source>1.8</maven.compiler.source>
    <maven.compiler.target>1.8</maven.compiler.target>
  </properties>

  <dependencies>

    <dependency>
      <groupId>junit</groupId>
      <artifactId>junit</artifactId>
      <version>3.8.1</version>
      <scope>test</scope>
    </dependency>

    <!-- Spring Lombok -->
    <dependency>
      <groupId>org.projectlombok</groupId>
      <artifactId>lombok</artifactId>
      <version>1.18.34</version>
    </dependency>

    <!-- Spring springframework -->
    <dependency>
      <groupId>org.springframework</groupId>
      <artifactId>spring-framework-bom</artifactId>
      <version>5.3.32</version>
      <type>pom</type>
      <scope>import</scope>
    </dependency>

    <!-- Spring context -->
    <dependency>
      <groupId>org.springframework</groupId>
      <artifactId>spring-context</artifactId>
      <version>6.1.13</version>
    </dependency>

    <!-- Spring Core -->
    <dependency>
      <groupId>org.springframework</groupId>
      <artifactId>spring-core</artifactId>
      <version>6.1.13</version>
    </dependency>

    <!-- Spring Web MVC -->
    <dependency>
      <groupId>org.springframework</groupId>
      <artifactId>spring-webmvc</artifactId>
      <version>6.1.13</version>
    </dependency>

    <!-- Spring Web -->
    <dependency>
      <groupId>org.springframework</groupId>
      <artifactId>spring-web</artifactId>
      <version>6.1.13</version>
    </dependency>
      
      <!-- Fastjson -->
    <dependency>
      <groupId>com.alibaba</groupId>
      <artifactId>fastjson</artifactId>
      <version>2.0.51</version>
    </dependency>
      
    <!-- Servlet -->
    <dependency>
      <groupId>jakarta.servlet</groupId>
      <artifactId>jakarta.servlet-api</artifactId>
      <version>5.0.0</version>
      <scope>provided</scope>
    </dependency>

    <!-- JSTL 顺序 1 -->
    <dependency>
      <groupId>jakarta.servlet.jsp.jstl</groupId>
      <artifactId>jakarta.servlet.jsp.jstl-api</artifactId>
      <version>2.0.0</version>
    </dependency>

    <!-- JSTL 顺序 2 -->
    <dependency>
      <groupId>org.glassfish.web</groupId>
      <artifactId>jakarta.servlet.jsp.jstl</artifactId>
      <version>2.0.0</version>
    </dependency>

    <!-- JSTL 顺序 3 -->
    <dependency>
      <groupId>javax.servlet</groupId>
      <artifactId>jstl</artifactId>
      <version>1.2</version>
    </dependency>
      
    <!-- apache fileUpload 文件上传 -->
    <dependency>
      <groupId>commons-fileupload</groupId>
      <artifactId>commons-fileupload</artifactId>
      <version>1.5</version>
    </dependency>

    <!-- apache fileUpload 文件上传 -->
    <dependency>
      <groupId>commons-io</groupId>
      <artifactId>commons-io</artifactId>
      <version>2.17.0</version>
    </dependency>
      
      <!-- JSR-303 使用 导入 -->
    <!-- JSR-303 -->
    <dependency>
      <groupId>org.hibernate</groupId>
      <artifactId>hibernate-validator</artifactId>
      <version>8.0.1.Final</version>
    </dependency>

    <!-- JSR-303 -->
    <dependency>
      <groupId>javax.validation</groupId>
      <artifactId>validation-api</artifactId>
      <version>2.0.1.Final</version>
    </dependency>

    <!-- JSR-303 -->
    <dependency>
      <groupId>org.jboss.logging</groupId>
      <artifactId>jboss-logging</artifactId>
      <version>3.5.3.Final</version>
    </dependency>

    <!-- JSR-303 / JDK9以上 安装 -->
    <dependency>
      <groupId>javax.xml.bind</groupId>
      <artifactId>jaxb-api</artifactId>
      <version>2.4.0-b180830.0359</version>
    </dependency>

    <!-- JAXB API -->
    <dependency>
      <groupId>javax.xml.bind</groupId>
      <artifactId>jaxb-api</artifactId>
      <version>2.3.1</version>
    </dependency>

    <!-- JAXB Implementation -->
    <dependency>
      <groupId>org.glassfish.jaxb</groupId>
      <artifactId>jaxb-runtime</artifactId>
      <version>2.3.1</version>
    </dependency>

    <!-- JSR-303 / JDK9以上 安装 -->
    <dependency>
      <groupId>javax.activation</groupId>
      <artifactId>activation</artifactId>
      <version>1.1.1</version>
    </dependency>
    <!-- JSR-303 使用 导入 结束 -->

</dependencies>

<build>
    <finalName>springMVC</finalName>
    <plugins>
      <plugin>
        <groupId>org.apache.maven.plugins</groupId>
        <artifactId>maven-compiler-plugin</artifactId>
        <version>3.13.0</version>
        <configuration>
          <source>1.8</source>
          <target>1.8</target>
          <compilerArgs>
            <arg>-parameters</arg>
          </compilerArgs>
        </configuration>
      </plugin>
    </plugins>
</build>
```

##### 不需要理会以下内容了，目前不需要手动处理！！！

配置 JSTL 问题，需要额外下载文件，再手动引入项目里。

[JSTL 1.2版本下载地址](http://www.java2s.com/Code/Jar/j/Downloadjstl12jar.htm)

打开文件，放在apache-tomcat/lib  里面，然后打开项目 -> File -> Project Structure -> Libraries -> 点击 + 引入刚刚的 jstl 文件，就可以使用了。

如果遇到观看此视频 [点击这里观看](https://www.youtube.com/watch?v=q7w399IE6og)

​       **resource/spring.xml**

```jsp
<?xml version="1.0" encoding="UTF-8"?>
<beans xmlns="http://www.springframework.org/schema/beans"
       xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
       xmlns:context="http://www.springframework.org/schema/context"
       xmlns:mvc="http://www.springframework.org/schema/mvc"
       xsi:schemaLocation="
           http://www.springframework.org/schema/beans
           http://www.springframework.org/schema/beans/spring-beans.xsd
           http://www.springframework.org/schema/context
           http://www.springframework.org/schema/context/spring-context.xsd
           http://www.springframework.org/schema/mvc
           http://www.springframework.org/schema/mvc/spring-mvc.xsd">

    <!--配置自动扫描-->
    <context:component-scan base-package="com.xs"/>

    <!--视图解析器-->
    <bean class="org.springframework.web.servlet.view.InternalResourceViewResolver">
        <property name="prefix" value="/"/>
        <property name="suffix" value=".jsp"/>
    </bean>

    <bean id="conversionService" class="org.springframework.context.support.ConversionServiceFactoryBean">
        <property name="converters">
            <list>
                <bean class="com.xs.converter.DateConverter">
                    <constructor-arg type="java.lang.String" value="yyyy-MM-dd"/>
                </bean>
                <bean class="com.xs.converter.StudentConverter"/>
            </list>
        </property>
    </bean>

    <!-- 启用注解驱动的 Spring MVC -->
    <mvc:annotation-driven conversion-service="conversionService">
        <mvc:message-converters>
            <bean class="org.springframework.http.converter.StringHttpMessageConverter">
                <property name="supportedMediaTypes" value="text/html;charset=UTF-8"/>
            </bean>
            <!-- Fastjson -->
            <bean class="com.alibaba.fastjson.support.spring.FastJsonHttpMessageConverter"/>
        </mvc:message-converters>
    </mvc:annotation-driven>

    <!-- 图片上传配置 -->
    <bean id="multipartResolver" class="org.springframework.web.multipart.support.StandardServletMultipartResolver"/>
    
</beans>
```

​      **webapp/WEB-INF/web.xml**  (假如是使用 MVC的)

```jsp
<!DOCTYPE web-app PUBLIC
 "-//Sun Microsystems, Inc.//DTD Web Application 2.3//EN"
 "http://java.sun.com/dtd/web-app_2_3.dtd" >

<web-app xmlns="http://xmlns.jcp.org/xml/ns/javaee"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://xmlns.jcp.org/xml/ns/javaee
         http://xmlns.jcp.org/xml/ns/javaee/web-app_3_1.xsd"
         version="3.1">
  <display-name>Archetype Created Web Application</display-name>

  <!-- 显示中文 -->
  <filter>
    <filter-name>encodingFilter</filter-name>
    <filter-class>org.springframework.web.filter.CharacterEncodingFilter</filter-class>
    <init-param>
      <param-name>encoding</param-name>
      <param-value>UTF-8</param-value>
    </init-param>
  </filter>

  <filter-mapping>
    <filter-name>encodingFilter</filter-name>
    <url-pattern>/*</url-pattern>
  </filter-mapping>

  <!-- 能够使用Form的时候，PUT，DELETE -->
  <filter>
    <filter-name>HiddenHttpMethodFilter</filter-name>
    <filter-class>org.springframework.web.filter.HiddenHttpMethodFilter</filter-class>
  </filter>

  <filter-mapping>
    <filter-name>HiddenHttpMethodFilter</filter-name>
    <url-pattern>/*</url-pattern>
  </filter-mapping>

  <servlet>
    <servlet-name>springmvc</servlet-name>
    <servlet-class>org.springframework.web.servlet.DispatcherServlet</servlet-class>
    <init-param>
      <param-name>contextConfigLocation</param-name>
      <param-value>classpath:spring.xml</param-value>
    </init-param>

    <!-- 图片上传 配置 -->
    <load-on-startup>1</load-on-startup>
    <multipart-config>
      <max-file-size>10485760</max-file-size>
      <max-request-size>10485760</max-request-size>
      <file-size-threshold>0</file-size-threshold>
    </multipart-config>
    
  </servlet>

  <servlet-mapping>
    <servlet-name>springmvc</servlet-name>
    <url-pattern>/</url-pattern>
  </servlet-mapping>

  <!-- Spring MVC 静态资源访问 -->
  <servlet-mapping>
    <servlet-name>default</servlet-name>
    <url-pattern>*.js</url-pattern>
  </servlet-mapping>

  <!-- Spring MVC 显示图片 格式 -->
  <servlet-mapping>
    <servlet-name>default</servlet-name>
    <url-pattern>*.png</url-pattern>
  </servlet-mapping>

  <!-- Spring MVC 显示图片 格式 -->
  <servlet-mapping>
    <servlet-name>default</servlet-name>
    <url-pattern>*.jpg</url-pattern>
  </servlet-mapping>

  <!-- Spring MVC 显示图片 格式 -->
  <servlet-mapping>
    <servlet-name>default</servlet-name>
    <url-pattern>*.jpeg</url-pattern>
  </servlet-mapping>

</web-app>
```





## 正式开始

#### @Controller

#### @RequestMapping("/index")

```java
package com.xs.controller;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
@RequestMapping("/hello")
public class HelloHandler {

    @RequestMapping("/index")
    public String index(){
        System.out.println("接收请求");
        // 返回 视图
        return "index";
    }

}
```

**Method**

```
@RequestMapping(value = "/index", method = RequestMethod.POST)
```

**Params**

```
@RequestMapping(value = "/index", method = RequestMethod.POST, params = "id")
```

```
@RequestMapping(value = "/index", method = RequestMethod.POST, params = {"id", "name", "age"})
```

URL**?id=1&name=Hoo**,  x

```
@RequestMapping(value = "/index", method = RequestMethod.POST, params = {"id=1", "name=Hoo"})
```



#### Rest 风格

RestFul 功能, 使代码更加方便快速

```java
	@RequestMapping("/index/{id}/{name}")
    public String restfulWay(Integer id, String name){
        System.out.println(id + " " + name);
        // 返回 视图
        return "index";
   	}
```

JSP 页面的转发 和 重定向

```java
@RequestMapping("/restful/{id}/{name}")
    public String restfulWay(Integer id, String name){
        System.out.println(id + " " + name);
        // 返回 视图
        return "redirect:/index.jsp";
    }
```

或

```java
return "forward:/index.jsp";
```



#### Spring MVC 数据绑定

**`required = true`** 表示这个请求参数是必须的，也就是说，如果客户端的请求中没有包含这个参数，Spring MVC 会抛出异常（通常是 `MissingServletRequestParameterException`），并返回一个错误响应。

```java
    @RequestMapping("/baseType")
    @ResponseBody
    public String baseType(int id){
        return "id:"+id;
    }

    @RequestMapping("/baseType")
    @ResponseBody
    public String packageType(@RequestParam(value="id", required = true, defaultValue = "0") int id){
        return "id:"+id;
    }
```



#### 数组

```java
@RequestMapping("/arrayType")
    @ResponseBody
    public String arrayType(String[] names){
        StringBuffer s = new StringBuffer();
        for(String str:names){
            s.append(str).append(" ");
        }
        return "names:"+s.toString();
    }
```



#### POJO

```java
package com.xs.entity;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class User {
    private Integer id;
    private String name;
}
```

```jsp
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <form action="hello/test" method="post">
        <table>
            <tr>
                <td>编号：</td>
                <td>
                    <input type="text" name="id"/>
                </td>
            </tr>
            <tr>
                <td>姓名：</td>
                <td>
                    <input type="text" name="name"/>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="提交"/>
                </td>
            </tr>
        </table>
    </form>
</head>
<body>

</body>
</html>
```

```java
@RequestMapping(value = "/add", method = RequestMethod.POST)
    public String add(User user){
        System.out.println(user);
        // 返回 视图
        return "index";
    }

@RequestMapping(value = "/add", method = RequestMethod.POST)
@ResponseBody
    public String add(User user){
        return user.toString()
    }
```



#### List

1.

```java
@Controller
public class StudentController {

    @RequestMapping("/getStudents")
    public String getStudents(HttpServletRequest request) {
        // 创建一个学生的列表
        List<Student> students = new ArrayList<>();
        students.add(new Student(1, "Alice"));
        students.add(new Student(2, "Bob"));
        students.add(new Student(3, "Charlie"));

        // 将学生列表设置为请求属性，传递给 JSP
        request.setAttribute("students", students);

        // 返回视图名 (例如 students.jsp)
        return "students";
    }
}
```

2.

```java
@RequestMapping(value = "/listType", method = RequestMethod.POST)
    @ResponseBody
    public String listType(UserList userList){
        StringBuffer stri = new StringBuffer();
        for(User u:userList.getUsers()){
            stri.append(u);
        }
        return "用户" + stri.toString();
    }
```

```java
package com.xs.entity;

import lombok.Data;

import java.util.List;

@Data
public class UserList {
    private List<User> users;
}
```

```java
package com.xs.entity;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class User {
    private Integer id;
    private String name;
}
```

```jsp
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <title>Title</title>
</head>
<body>

    <form action="hello/listType" method="post">
        用户1 ID: <input type="text" name="users[0].id"/><br/>
        用户1 Name: <input type="text" name="users[0].name"/><br/>

        用户2 ID: <input type="text" name="users[1].id"/><br/>
        用户2 Name: <input type="text" name="users[1].name"/><br/>

        用户3 ID: <input type="text" name="users[2].id"/><br/>
        用户3 Name: <input type="text" name="users[2].name"/><br/>

        <input type="submit" value="提交"/>
    </form>

</body>
</html>
```

`List.of` 创建的列表是不可变的，这意味着一旦创建，就无法添加、删除或更改其元素。

```java
List<String> immutableList = List.of("apple", "banana", "cherry");
```

```java
List<Map.Entry<String, Integer>> keyValuePairs = List.of(
                Map.entry("1", 101),
                Map.entry("2", 102)
        );
```

```java
List<UserEntity> userdata = List.of(
                new UserEntity(101, "avatar1.png", "John", "0", "123 Street", 5),
                new UserEntity(102, "avatar2.png", "Jane", "1", "456 Avenue", 10)
        );
```



#### 引入 Jquery 文件 或者 其他

需要 点击 Build -> Rebuild Project

重新打包项目给 target



#### Spring MVC 视图解析

EL 表达式

```jsp
<%@ page isELIgnored="false" %>
```

将数据传递到视图， 但 `Model` 是 Spring 框架推荐的方式，具有更多的功能和灵活性。

```java
@RequestMapping("/map")
    public String map(Map<String, Object> map){
        User u = new User();
        u.setId(1);
        u.setName("Hoo");
        map.put("user", u); // 将 User 对象存入 map，键为 "user"
        return "show"; // 返回视图名 "show"
    }

    @RequestMapping("/model")
    public String model(Model model){
        User u = new User();
        u.setId(1);
        u.setName("Hoo");
        model.addAttribute("user",u); // 将 User 对象存入 model，键为 "user"
        return "show"; // 返回视图名 "show"
    }
```

```jsp
<p>User ID: ${user.id}</p>
<p>User Name: ${user.name}</p>
```

ModelAndView

`ModelAndView` 是 Spring MVC 中用于处理模型数据和视图名的一个类，它结合了模型和视图的功能，允许你同时设置模型数据和返回的视图。使用 `ModelAndView` 的方法通常比单独使用 `Map` 或 `Model` 更加清晰和灵活。

`ModelAndView` 允许通过方法链的方式添加多个模型对象，例如：

```java
mav.addObject("user", u).addObject("age", 25);
```

```java
@RequestMapping("/mav")
    public ModelAndView modelAndView(){
        ModelAndView mav = new ModelAndView(); // 创建 ModelAndView 对象
        User u = new User(); // 创建 User 对象
        u.setId(1); // 设置用户 ID
        u.setName("Hoo"); // 设置用户名称
        mav.addObject("user", u); // 将 User 对象存入 mav，键为 "user"
        mav.setViewName("show"); // 设置视图名为 "show"
        return mav; // 返回 ModelAndView 对象
    }
```

HttpServletRequest

```java
@RequestMapping("/request")
    public String request(HttpServletRequest request){
        User u = new User(); // 创建 User 对象
        u.setId(1); // 设置用户 ID
        u.setName("Hoo"); // 设置用户名称
        request.setAttribute("user", u); // 将 User 对象存入 request，键为 "user"
        return "show"; // 返回视图名 "show"
    }
```

@ModelAttribute

```java
@RequestMapping("/modelAttribute")
    public String modelAttribute(){
        return "show";
    }

    @ModelAttribute
    public User getUser(){
        User u = new User();
        u.setId(1);
        u.setName("Hoo");
        return u;
    }
```

HttpSession

```java
@RequestMapping("/session")
public String session(HttpSession session) {
    User u = new User();
    u.setId(1);
    u.setName("Hoo");
    session.setAttribute("user", u); // 将 User 对象存入 session，键为 "user"
    return "show"; // 返回视图名 "show"
}
```

```jsp
<p>ID: ${sessionScope.user.id}</p>
<p>Name: ${sessionScope.user.name}</p>
```



#### Spring MVC 自定义数据类型转换器

1. 创建一个自定义的类型转换器

   ```java
   package com.xs.converter;
   
   import org.springframework.core.convert.converter.Converter;
   
   import java.text.ParseException;
   import java.text.SimpleDateFormat;
   import java.util.Date;
   
   public class DateConverter implements Converter<String, Date> {
   
   //    这个 DateConverter 类是一个自定义的类型转换器，旨在将 String 类型的日期字符串转换为 Date 类型的对象。
   //    它实现了 Converter<String, Date> 接口，表示它可以将一个 String 转换为一个 Date.
   
       private String pattern;
   
       public DateConverter(String pattern){
           this.pattern = pattern;
       }
   
       @Override
       public Date convert(String source) {
           SimpleDateFormat simple = new SimpleDateFormat(this.pattern);
           try{
               return simple.parse(source);
           }catch (ParseException e){
               e.printStackTrace();
           }
          return null;
       }
   
   }
   ```

   2. 配置 spring.xml

      ```xml
      <bean id="conversionService" class="org.springframework.context.support.ConversionServiceFactoryBean">
              <property name="converters">
                  <list>
                      <bean class="com.xs.converter.DateConverter">
                          <constructor-arg type="java.lang.String" value="yyy-MM-dd"/>
                      </bean>
                  </list>
              </property>
          </bean>
      ```

      pom.xml

      ```xml
      <build>
          <finalName>springMVC_03</finalName>
          <plugins>
            <plugin>
              <groupId>org.apache.maven.plugins</groupId>
              <artifactId>maven-compiler-plugin</artifactId>
              <version>3.13.0</version>
              <configuration>
                <source>1.8</source>
                <target>1.8</target>
                <compilerArgs>
                  <arg>-parameters</arg>
                </compilerArgs>
              </configuration>
            </plugin>
          </plugins>
        </build>
      ```

      

      3. ```java
         @Controller
         @RequestMapping("/converter")
         public class ConverterHandler {
         
             @RequestMapping("/date")
             @ResponseBody
             public String date(@RequestParam("date") Date date) {
                 return date.toString();
             }
         
         }
         ```

         ```jsp
         <%@ page contentType="text/html;charset=UTF-8" language="java" %>
         <html>
         <head>
             <title>Title</title>
         </head>
         <body>
         
         <form action="converter/date" method="post">
             <input type="text" name="date"/> (2020-01-01)
             <input type="submit" value="提交"/>
         </form>
         
         </body>
         </html>
         ```

         

#### Student Class 自定义转换器

```java
package com.xs.converter;

import com.xs.entity.Student;
import org.springframework.core.convert.converter.Converter;

public class StudentConverter implements Converter<String, Student>{

    @Override
    public Student convert(String source) {
        String[] a = source.split("-");
        Student student = new Student();
        student.setId(Integer.parseInt(a[0]));
        student.setName(a[1]);
        student.setAge(Integer.parseInt(a[2]));
        return student;
    }
}
```

配置 spring.xml

```
<bean id="conversionService" class="org.springframework.context.support.ConversionServiceFactoryBean">
        <property name="converters">
            <list>
                <bean class="com.xs.converter.DateConverter">
                    <constructor-arg type="java.lang.String" value="yyyy-MM-dd"/>
                </bean>
                // 这里 Student 配置
                <bean class="com.xs.converter.StudentConverter"/>
            </list>
        </property>
    </bean>
```

使用 Handler

```java
@RequestMapping("/student")
    @ResponseBody
    public Student student(Student s, HttpServletResponse res) {
        res.setCharacterEncoding("UTF-8");
        return s;
    }
```



#### Spring MVC 与 RESTful 的集成

1. Handler

   ```java
   @PutMapping("/update")
       @ResponseBody
       public String update(HttpServletResponse res){
           res.setCharacterEncoding("UTF-8");
           return "Update 接收了";
       }
   
       @DeleteMapping("/delete")
       @ResponseBody
       public String delete(HttpServletResponse res){
           res.setCharacterEncoding("UTF-8");
           return "Delete 接收了";
       }
   ```

   2. 配置， 已配置在Web.xml

      ```xml
      <filter>
          <filter-name>HiddenHttpMethodFilter</filter-name>
          <filter-class>org.springframework.web.filter.HiddenHttpMethodFilter</filter-class>
        </filter>
      
        <filter-mapping>
          <filter-name>HiddenHttpMethodFilter</filter-name>
          <url-pattern>/*</url-pattern>
        </filter-mapping>
      ```
      
      3. JSP
      
         ```jsp
         <form action="rest/update" method="post">
             <input type="hidden" name="_method" value="PUT"/>
             <input type="submit" value="PUT 提交"/>
         </form>
         
         <form action="rest/delete" method="post">
             <input type="hidden" name="_method" value="DELETE"/>
             <input type="submit" value="DELETE 提交"/>
         </form>
         ```
      
         

#### 实践 代码 CRUD

1，Course 实体类

```java
package com.xs.entity;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class Course {
    private  Integer id;
    private String name;
    private Double price;
}
```

2，CourseRepository

```java
package com.xs.repository;

import com.xs.entity.Course;
import org.springframework.stereotype.Repository;

import java.util.Collection;
import java.util.HashMap;
import java.util.Map;

@Repository
public class CourseRepository {

    private Map<Integer, Course> courseMap;

    public CourseRepository(){
        courseMap = new HashMap<>();
        courseMap.put(1,new Course(1,"Java基础",Double.parseDouble("500")));
        courseMap.put(2,new Course(2,"Java高级",Double.parseDouble("700")));
        courseMap.put(3,new Course(3,"企业家",Double.parseDouble("800")));

    }

    public Collection<Course> findAll(){
        return courseMap.values();
    }

    public Course findById(Integer id){
        return courseMap.get(id);
    }

    public void saveOrUpdate(Course course){
        courseMap.put(course.getId(),course);
    }

    public void deleteById(Integer id){
        courseMap.remove(id);
    }

}
```

3，配置 JSP  index.jsp

```jsp
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ page isELIgnored="false" %>
```

```jsp
<%--
  Created by IntelliJ IDEA.
  User: Hoo
  Date: 10/19/2024
  Time: 4:07 PM
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page isELIgnored="false" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>

<html>
<head>
  <title>Title</title>
</head>
<body>

<table>
  <tr>
    <th>编号</th>
    <th>名称</th>
    <th>价格</th>
    <th>操作</th>
  </tr>
  <c:forEach items="${list}" var="course">
    <tr>
      <td>${course.id}</td>
      <td>${course.name}</td>
      <td>${course.price}</td>
      <td>
        <form action="${pageContext.request.contextPath}/course/deleteById/${course.id}" method="post">
          <input type="hidden" name="_method" value="DELETE" />
          <input type="submit" value="删除"/>
        </form>
        <a href="${pageContext.request.contextPath}/course/findById/${course.id}">修改</a>
      </td>
    </tr>
  </c:forEach>
</table>

</body>
</html>
```

4，Handler

```java
package com.xs.controller;

import com.xs.entity.Course;
import com.xs.repository.CourseRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.ModelAndView;

@Controller
@RequestMapping("/course")
public class CourseController {

    @Autowired
    private CourseRepository courseRepository;

    @PostMapping("/save")
    public String save(Course c){
        courseRepository.saveOrUpdate(c);
        return "redirect:/course/findAll";
    }

    @GetMapping("/findAll")
    public ModelAndView findAll(){
        ModelAndView mav = new ModelAndView();
        mav.setViewName("index");
        mav.addObject("list",courseRepository.findAll());
        return mav;
    }

    @DeleteMapping("/deleteById/{id}")
    public String deleteById(@PathVariable("id") Integer id){
        courseRepository.deleteById(id);
        return "redirect:/course/findAll";
    }

    @GetMapping("/findById/{id}")
    public ModelAndView findById(@PathVariable("id") Integer id){
        ModelAndView mav = new ModelAndView();
        mav.setViewName("edit");
        mav.addObject("course",courseRepository.findById(id));
        return mav;
    }

    @PutMapping("/update")
    public String update(Course c){
        courseRepository.saveOrUpdate(c);
        return "redirect:/course/findAll";
    }

}
```

5，save.jsp

```jsp
<%--
  Created by IntelliJ IDEA.
  User: Hoo
  Date: 10/19/2024
  Time: 10:09 PM
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <title>Title</title>
</head>
<body>

<form action="course/save" method="post">
    <table>
        <tr>
            <td>课程编号：</td>
            <td>
                <input type="text" name="id"/>
            </td>
        </tr>
        <tr>
            <td>课程名称：</td>
            <td>
                <input type="text" name="name"/>
            </td>
        </tr>
        <tr>
            <td>课程价格：</td>
            <td>
                <input type="text" name="price"/>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="提交"/>
            </td>
        </tr>
        <tr>
            <td>
                <input type="reset" value="重置"/>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
```

6，edit.jsp

```jsp
<%--
  Created by IntelliJ IDEA.
  User: Hoo
  Date: 10/19/2024
  Time: 10:52 PM
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page isELIgnored="false" %>
<html>
<head>
    <title>Title</title>
</head>
<body>

<form action="${pageContext.request.contextPath}/course/update" method="post">
    <input type="hidden" name="_method" value="PUT"/>
    <table>
        <tr>
            <td>编号：</td>
            <td>
                <input type="text" name="id" readonly value="${course.id}"/>
            </td>
        </tr>
        <tr>
            <td>名称：</td>
            <td>
                <input type="text" name="name" value="${course.name}"/>
            </td>
        </tr>
        <tr>
            <td>价格：</td>
            <td>
                <input type="text" name="price" value="${course.price}"/>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="修改"/>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
```



#### Spring MVC 实现图片文件上传下载

配置

1，web.xml

```xml
<!-- Spring MVC 显示图片 格式 -->
  <servlet-mapping>
    <servlet-name>default</servlet-name>
    <url-pattern>*.png</url-pattern>
  </servlet-mapping>

  <!-- Spring MVC 显示图片 格式 -->
  <servlet-mapping>
    <servlet-name>default</servlet-name>
    <url-pattern>*.jpg</url-pattern>
  </servlet-mapping>

  <!-- Spring MVC 显示图片 格式 -->
  <servlet-mapping>
    <servlet-name>default</servlet-name>
    <url-pattern>*.jpeg</url-pattern>
  </servlet-mapping>
```

2，pom.xml

```xml
<!-- apache fileUpload 文件上传 -->
    <dependency>
      <groupId>commons-fileupload</groupId>
      <artifactId>commons-fileupload</artifactId>
      <version>1.5</version>
    </dependency>

    <!-- apache fileUpload 文件上传 -->
    <dependency>
      <groupId>commons-io</groupId>
      <artifactId>commons-io</artifactId>
      <version>2.17.0</version>
    </dependency>
```

3，spring.xml

```xml
<!-- 图片上传配置 -->
    <bean id="multipartResolver" class="org.springframework.web.multipart.support.StandardServletMultipartResolver"/>
```

1，upload.jsp

```jsp
<%--
  Created by IntelliJ IDEA.
  User: Hoo
  Date: 10/19/2024
  Time: 11:17 PM
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page isELIgnored="false" %>
<html>
<head>
    <title>Title</title>
</head>
<body>
<form action="/file/upload" method="post" enctype="multipart/form-data">
    <input type="file" name="img"/>
    <input type="submit" value="文件上传"/>
</form>
<img src="${pageContext.request.contextPath}${src}" alt="Uploaded Image" />

</body>
</html>
```

2，Controller

```java
package com.xs.controller;

import jakarta.servlet.http.HttpServletRequest;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.multipart.MultipartFile;

import java.io.File;
import java.io.IOException;

@Controller
@RequestMapping("/file")
public class FileHandler {


    @PostMapping("/upload")
    public String upload(@RequestParam("img") MultipartFile img, HttpServletRequest req) {

        if(img.getSize() > 0){
            String path = req.getSession().getServletContext().getRealPath("file");
            File directory = new File(path);

            // 检查目标目录是否存在，如果不存在则创建
            if (!directory.exists()) {
                directory.mkdirs();
            }

            // 处理文件名冲突
            String fileName = img.getOriginalFilename();
            String newFileName = System.currentTimeMillis() + "_" + fileName; // 添加时间戳
            File file = new File(directory, newFileName);

            try {
                img.transferTo(file);
                req.setAttribute("src","/file/" + newFileName);
            } catch (IOException e) {
                e.printStackTrace();
            }
        }

        return "upload"; // 返回的视图名称
    }

}
```

#### 多图片文件上传

1，uploads.jsp

```jsp
<%--
  Created by IntelliJ IDEA.
  User: Hoo
  Date: 10/20/2024
  Time: 2:08 AM
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ page isELIgnored="false" %>
<html>
<head>
    <title>Title</title>
</head>
<body>

<form action="/file/uploads" method="post" enctype="multipart/form-data">
    file1:<input type="file" name="imgs"/><br/>
    file2:<input type="file" name="imgs"/><br/>
    file3:<input type="file" name="imgs"/><br/>

    <input type="submit" value="提交"/>
</form>

<c:forEach items="${list}" var="path">
    <img width="300px" src="${pageContext.request.contextPath}${path}"/>
</c:forEach>

</body>
</html>
```

2，Controller

```java
@PostMapping("/uploads")
    public String uploads(@RequestParam("imgs") MultipartFile[] imgs, HttpServletRequest req) {

        List<String> pathList = new ArrayList<>();

        for(MultipartFile img:imgs){
            String path = req.getSession().getServletContext().getRealPath("file");
            File directory = new File(path);

            // 检查目标目录是否存在，如果不存在则创建
            if (!directory.exists()) {
                directory.mkdirs();
            }

            // 处理文件名冲突
            String fileName = img.getOriginalFilename();
            String newFileName = System.currentTimeMillis() + "_" + fileName; // 添加时间戳
            File file = new File(directory, newFileName);

            try {
                img.transferTo(file);
                pathList.add("/file/" + newFileName);
            } catch (IOException e) {
                e.printStackTrace();
            }
        }

        req.setAttribute("list",pathList);
        return "uploads"; // 返回的视图名称
    }
```



#### 图片 文件下载

1，download.jsp

```jsp
<%--
  Created by IntelliJ IDEA.
  User: Hoo
  Date: 10/20/2024
  Time: 2:53 PM
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <title>Title</title>
</head>
<body>

<a href="/file/download?fileName=1729361780490_1.jpeg">1</a><br/>
<a href="/file/download?fileName=1729361780494_2.jpg">2</a><br/>
<a href="/file/download?fileName=1729361780510_3.png">3</a><br/>

</body>
</html>
```

2，Controller

```java
 @GetMapping("/download")
    public void download(String fileName, HttpServletRequest req, HttpServletResponse res){

        if(fileName != null){
            // 获取文件的真实路径
            String path = req.getSession().getServletContext().getRealPath("file");
            File file = new File(path, fileName);
            OutputStream outputStream = null;
            if(file.exists()){
                res.setContentType("application/force-download");
                res.setHeader("Content-Disposition","attachment;filename=" + fileName);

                try{
                    outputStream = res.getOutputStream();
                    outputStream.write(FileUtils.readFileToByteArray(file));
                    outputStream.flush();
                }
                catch (IOException e){
                    e.printStackTrace();
                }
                finally {
                    if(outputStream != null){
                        try{
                            outputStream.close();
                        }
                        catch (IOException e){
                            e.printStackTrace();
                        }
                    }
                }

            }

        }
    }
```



#### Spring MVC 数据校验

复杂方式

1，添加校验文件 **validation**

2，添加数据 Models

```java
package com.xs.entity;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class XStudent {
    private String name;
    private String password;
}
```

3，添加 XStudent 数据校验

```java
package com.xs.validation;

import com.xs.entity.XStudent;
import org.springframework.validation.Errors;
import org.springframework.validation.ValidationUtils;
import org.springframework.validation.Validator;

public class XStudentValidation implements Validator {

    // 检查这个验证器是否支持验证给定类
    @Override
    public boolean supports(Class<?> clazz) {
        return XStudent.class.equals(clazz);
    }

    // 执行校验逻辑
    @Override
    public void validate(Object target, Errors errors) {
        // 进行校验，如果 name 字段为空则添加错误信息
        ValidationUtils.rejectIfEmpty(errors, "name", null, "姓名不能空");
        ValidationUtils.rejectIfEmpty(errors, "password", null, "密码不能空");
    }
}
```

4，添加 ValidateHandler

```java
package com.xs.controller;

import com.xs.entity.XStudent;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
@RequestMapping("/validate")
public class ValidateHandler {

    @GetMapping("/login")
    public String login(Model model){
        model.addAttribute("XStudent", new XStudent());
        return "login";
    }

    @PostMapping("/login")
    public String login(@Validated XStudent xs, BindingResult bindingResult){
        if(bindingResult.hasErrors()){
            return "login";
        }
        return "success";
    }


}
```

5，添加 login.jsp

```jsp
<%--
  Created by IntelliJ IDEA.
  User: Hoo
  Date: 10/20/2024
  Time: 3:31 PM
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form" %>
<html>
<head>
    <title>Title</title>
</head>
<body>

<h1>学生登入</h1>
<form:form modelAttribute="XStudent" action="/validate/login" method="post">
    学生姓名:<form:input path="name"/><form:errors path="name"/><br/>
    学生密码:<form:input path="password"/><form:errors path="password"/><br/>
    <input type="submit" value="提交"/>
</form:form>

</body>
</html>
```

6，添加 在 spring.xml

```xml
<!-- XStudent 数据校验 -->
    <mvc:annotation-driven validator="xstudentValidator"/>
    <bean id="xstudentValidator" class="com.xs.validation.XStudentValidation"/>
```

7，success.jsp

```jsp
<%--
  Created by IntelliJ IDEA.
  User: Hoo
  Date: 10/20/2024
  Time: 4:05 PM
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <title>Title</title>
</head>
<body>
<h1>success</h1>
</body>
</html>
```

数据校验 推荐方式

#### Annotation JSR-303

1，导入 pom.ml

```xml
<!-- JSR-303 使用 导入 -->
    <!-- JSR-303 -->
    <dependency>
      <groupId>org.hibernate</groupId>
      <artifactId>hibernate-validator</artifactId>
      <version>8.0.1.Final</version>
    </dependency>

    <!-- JSR-303 -->
    <dependency>
      <groupId>javax.validation</groupId>
      <artifactId>validation-api</artifactId>
      <version>2.0.1.Final</version>
    </dependency>

    <!-- JSR-303 -->
    <dependency>
      <groupId>org.jboss.logging</groupId>
      <artifactId>jboss-logging</artifactId>
      <version>3.5.3.Final</version>
    </dependency>

    <!-- JSR-303 / JDK9以上 安装 -->
    <dependency>
      <groupId>javax.xml.bind</groupId>
      <artifactId>jaxb-api</artifactId>
      <version>2.4.0-b180830.0359</version>
    </dependency>

    <!-- JAXB API -->
    <dependency>
      <groupId>javax.xml.bind</groupId>
      <artifactId>jaxb-api</artifactId>
      <version>2.3.1</version>
    </dependency>

    <!-- JAXB Implementation -->
    <dependency>
      <groupId>org.glassfish.jaxb</groupId>
      <artifactId>jaxb-runtime</artifactId>
      <version>2.3.1</version>
    </dependency>

    <!-- JSR-303 / JDK9以上 安装 -->
    <dependency>
      <groupId>javax.activation</groupId>
      <artifactId>activation</artifactId>
      <version>1.1.1</version>
    </dependency>
    <!-- JSR-303 使用 导入 结束 -->
```

2，创建实体类

```java
package com.xs.entity;

import jakarta.validation.constraints.Pattern;
import jakarta.validation.constraints.Size;
import lombok.Data;
import org.hibernate.validator.constraints.Email;
import org.hibernate.validator.constraints.NotEmpty;

@Data
public class Account {
    @NotEmpty(message = "用户名不能为空")
    private String username;
    @Size(min = 6, max = 20, message = "密码长度为 6 - 20")
    private String password;
    @Email(regexp = "^[a-zA-Z0-9._%+-]+@gmail\\.com$", message = "请输入有效的 Gmail 地址")
    private String email;
    @Pattern(regexp = "^(\\+60\\d{1,2}-\\d{7}|0\\d{1,2}-\\d{7}|(\\+60\\d{1,2}|0\\d{1,2})\\d{7})$",
            message = "请输入正确电话格式")
    private String phone;
}
```

3，Controller

```java
@GetMapping("/register")
    public String register(Model model) {
        model.addAttribute("account", new Account()); // 使用小写
        return "register";
    }

    @PostMapping("/register")
    public String register(@Valid Account a, BindingResult bindingResult) {
        if (bindingResult.hasErrors()) {
            return "register";
        }
        return "success";
    }
```

4，配置 spring.xml

```xml
<mvc:annotation-driven/>
```

5，register.jsp

```jsp
<%--
  Created by IntelliJ IDEA.
  User: Hoo
  Date: 10/20/2024
  Time: 4:32 PM
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form" %>
<html>
<head>
    <title>Title</title>
</head>
<body>

<h1>用户注册</h1>
<form:form modelAttribute="account" action="/validate/register" method="post">
    用户姓名:<form:input path="username"/><form:errors path="username"/><br/>
    用户密码:<form:input path="password"/><form:errors path="password"/><br/>
    用户邮件:<form:input path="email"/><form:errors path="email"/><br/>
    用户电话:<form:input path="phone"/><form:errors path="phone"/><br/>
    <input type="submit" value="提交"/>
</form:form>

</body>
</html>
```



#### Spring MVC 表单库

1，Student 实体类 和 Address 实体类

```java
package com.xs.entity2;

import lombok.Data;

import java.util.List;

@Data
public class Student {
    private Integer id;
    private String name;
    private String password;
    private Integer age;
    private String gender;
    private Address address;
    private Boolean flag;
    private List<String> hobby;
    private List<String> selectHobby;
}
```

```java
package com.xs.entity2;

import lombok.Data;

@Data
public class Address {
    private Integer id;
    private String name;
}
```

2，Handler

```java
package com.xs.controller;

import com.xs.entity2.Student;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
@RequestMapping("/student")
public class StudentHandler {

    @RequestMapping("/get")
    public String get(Model model){
        Student stu = new Student();
        stu.setId(1);
        stu.setPassword("1313");
        stu.setName("Hoo");
        stu.setAge(24);
        stu.setGender("男");
        stu.setFlag(true);
        stu.setHobby(Arrays.asList("读书","看电影","玩游戏"));
        stu.setSelectHobby(Arrays.asList("读书","看电影"));
        Address address = new Address();
        address.setId(1);
        address.setName("幸福路");
        stu.setAddress(address);
        model.addAttribute("student",stu);
        return "student2";
    }

    @PostMapping("/update")
    public String update(Student stu){
        System.out.println(stu);
        return "student2";
    }
    
}
```

3，常见 表单

```jsp
<%--
  Created by IntelliJ IDEA.
  User: Hoo
  Date: 10/20/2024
  Time: 8:29 PM
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page isELIgnored="false"%>
<html>
<head>
    <title>Title</title>
</head>
<body>

<h1>学生信息</h1>
<form action="" method="post">
  编号：<input type="text" name="id" value="${student.id}" readonly/><br/>
  名字：<input type="text" name="name" value="${student.name}"/><br/>
  年龄：<input type="text" name="age" value="${student.age}"/><br/>
  性别：<input type="text" name="gender" value="${student.gender}"/><br/>
  <input type="submit" value="提交"/>
</form>

</body>
</html>
```

使用 新表单

```jsp
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
```

```jsp
<form:form modelAttribute="student" action="/student/update" method="post">
  编号：<form:input path="id"/><br/>
  名字：<form:input path="name"/><br/>
  密码：<form:password path="password"/><br/>
  年龄：<form:input path="age"/><br/>
  性别：<form:input path="gender"/><br/>
  地址：<form:input path="address.name"/><br/>

  checkbox：<form:checkbox path="flag" value="1"/><br/>

<%--  <form:checkbox path="hobby" value="读书"/>读书<br/>--%>
<%--  <form:checkbox path="hobby" value="看电影"/>看电影<br/>--%>
<%--  <form:checkbox path="hobby" value="玩游戏"/>玩游戏<br/>--%>

  <form:checkboxes path="selectHobby" items="${student.hobby}"/><br/>

<%-- 其他的自己看上网吧.... --%>

  <input type="submit" value="提交"/>
</form:form>
```

Password 标签

数据不会显示出来

```jsp
<form:password path="password"/>
```

checkbox 标签

```jsp
<form:checkbox path="hobby" value="读书"/>
```



#### Spring MVC 国际化

国际化是显示不同语言

1，配置 spring.xml

```xml
<!-- 国际化 -->
    <bean id="messageSource" class="org.springframework.context.support.ReloadableResourceBundleMessageSource">
        <property name="basename" value="classpath:language"/>
        <property name="useCodeAsDefaultMessage" value="true"/>
    </bean>

    <!-- 国际化 拦截器 -->
    <mvc:interceptors>
        <bean id="localeChangeInterceptor" class="org.springframework.web.servlet.i18n.LocaleChangeInterceptor">
            <property name="paramName" value="lang"/>
        </bean>
    </mvc:interceptors>

    <!-- 国际化 配置 -->
    <bean id="localeResolver" class="org.springframework.web.servlet.i18n.SessionLocaleResolver"/>
```

2，创建文件 

resources -> language_en_US.properties

```properties
language.cn = \u4E2D\u6587
language.en = English
info = login
username = username
password = password
repassword = repassword
tel = tel
email = email
submit = submit
reset = reset
```

resources -> language_zh_CN.properties

```properties
language.cn = \u4E2D\u6587
language.en = English
info = \u767B\u9646
username = \u7528\u6237\u540D
password = \u5BC6\u7801
repassword = \u786E\u8BA4\u5BC6\u7801
tel = \u7535\u8BDD
email = \u7535\u5B50\u90AE\u7BB1
submit = \u63D0\u4EA4
reset = \u91CD\u7F6E
```

3，Handler

```java
package com.xs.controller;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
@RequestMapping("/inter")
public class InterHandler {

    @GetMapping("/index")
    public String index(){
        return "inter";
    }
    
}
```

4，intel.jsp

```jsp
<%--
  Created by IntelliJ IDEA.
  User: Hoo
  Date: 10/20/2024
  Time: 9:19 PM
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<html>
<head>
    <title>Title</title>
</head>
<body>

<a href="index?lang=en_US">English</a>
<a href="index?lang=zh_CN">中文</a>

<spring:message code="info"/>
<form>
    <spring:message code="username"/>:<input type="text"/><br/>
    <spring:message code="password"/>:<input type="password"/><br/>
    <spring:message code="repassword"/>:<input type="password"/><br/>
    <spring:message code="tel"/>:<input type="text"/><br/>
    <spring:message code="email"/>:<input type="text"/><br/>
    <input type="submit" value="<spring:message code="submit"/>"/>
    <input type="reset" value="<spring:message code="reset"/>"/>
</form>

</body>
</html>
```

实现语言切换

http://localhost:8080/inter/index?lang=en_US

http://localhost:8080/inter/index?lang=zh_CN





## Spring MVC 功能大全

```
@ResponseBody
@RequestMapping(value = "/index", method = RequestMethod.POST, params = "id")
@Controller
@RequestBody
@ModelAttribute
@ResponseBody
@RequestBody
@GetMapping("/find")
@Repository
@Data
@AllArgsConstructor
@NoArgsConstructor
@Autowired
@RestController
@RequestParam
@RequestParam(value="id", required = true, defaultValue = "0") int id
@PathVariable
@Valid
@Validated

HttpServletRequest
ModelAndView
Map
Model
HttpSession
HttpServletResponse
MultipartFile
BindingResult

${pageContext.request.contextPath}

<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form" %>
<%@ page isELIgnored="false" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
```

**`@RequestBody`**：告诉 Spring MVC 从请求体中读取数据，并自动将 JSON 转换为 `User` 对象。

```javascript
$(function(){
        var user = {
            "id" : 1,
            "name" : "Hoo"
        }

        $.ajax({
            type: "POST",
            url: "hello/jsonType",
            dataType: "JSON",
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(user),
            success: function (data) {
                alert(data.id);
                alert(data.name);
            }
        })
    })
```

```java
@RequestMapping(value = "/jsonType", method = RequestMethod.POST)
    @ResponseBody
    public User jsonType(@RequestBody User user) {
        System.out.println(user);
        return user;
    }
```

**`@Repository`** 通常用于标记负责与数据库交互的类，如实现了 `CRUD`（创建、读取、更新、删除）操作的类。

**`@PathVariable`** 是 Spring MVC 中的一个注解，用于从请求的 URL 路径中提取变量值，并将其映射到方法参数。换句话说，它可以让你从 URL 中获取某个动态部分（路径变量），并在控制器方法中使用该值。

`http://localhost:8080/courses/1` 中，`1` 可以用 `@PathVariable` 获取。

```java
@RestController
public class UserController {
    @GetMapping("/user/{id}")
    public String getUserById(@PathVariable("id") Integer id) {
        return "User ID: " + id;
    }
}
```

```java
@GetMapping("/courses/{id}")
public String getCourseById(@PathVariable("id") Integer courseId) {
    // 根据 ID 获取课程
    return "courseDetails";
}
```

**`**@RestController`**** 的方法返回的数据直接作为 HTTP 响应的主体内容，而不是返回视图。

**自动序列化**：返回的对象会自动转换为 JSON 或 XML 格式（取决于客户端请求的内容类型）。

**典型应用场景**：主要用于创建 RESTful API，特别是当你需要返回 JSON 或 XML 数据时。

```java
@RestController
public class UserController {

    @GetMapping("/user/{id}")
    public User getUser(@PathVariable Integer id) {
        // 返回 JSON 格式的 User 对象
        return new User(id, "John");
    }
}
```

**什么时候用**：当你的应用部署在非根路径（不是 `/`）下时，比如 `/myApp`，需要用 `${pageContext.request.contextPath}` 来确保生成的链接路径正确。如果不加这个，路径可能会找不到资源，导致 404 错误。

**${pageContext.request.contextPath} 是什么**：它是 JSP 中的一个表达式，用来获取你应用的 **上下文路径**（`contextPath`），即应用在服务器上的部署路径。例如，如果你的应用部署在 `/myApp`，`${pageContext.request.contextPath}` 就会返回 `/myApp`。

```jsp
// http://localhost:8080/springMVC_03     /course/deleteById/${course.id}
<form action="${pageContext.request.contextPath}/course/deleteById/${course.id}" method="post">
          <input type="hidden" name="_method" value="DELETE" />
          <input type="submit" value="删除"/>
</form>
```

 **@RequestParam**

`http://localhost:8080/courses?sort=asc` 中的 `sort` 参数可以用 `@RequestParam` 获取。

```java
@GetMapping("/courses")
public String getCourses(@RequestParam("sort") String sortOrder) {
    // 处理排序逻辑
    return "courses";
}
```

**`MultipartFile`** 是处理文件上传的核心接口，提供了上传文件的各种方法和功能。



#### 打包项目

```
mvn clean package
```



#### RESTful API

```java
@Controller
@RequestMapping("/rest")
public class RESTHandler {

    private Map<Integer, Course> courseMap;

    // 测试 使用 可以 删掉
    public CourseRepository(){
        courseMap = new HashMap<>();
        courseMap.put(1,new Course(1,"Java基础",Double.parseDouble("500")));
        courseMap.put(2,new Course(2,"Java高级",Double.parseDouble("700")));
        courseMap.put(3,new Course(3,"企业家",Double.parseDouble("800")));

    }

    public Collection<Course> findAll(){
        return courseMap.values();
    }

    public Course findById(Integer id){
        return courseMap.get(id);
    }

    public void saveOrUpdate(Course course){
        courseMap.put(course.getId(),course);
    }

    public void deleteById(Integer id){
        courseMap.remove(id);
    }

}
```

#### 返回视图

```java
// 返回 视图
return "redirect:/index.jsp";
```

#### Java Spring MVC LINQ 语法

1. 普通输出

这是 C# LINQ 语法

```c#
var Admin = (from c in Admin_list
			select new PostData
			{
			  Title = c.title,
			  Username = "",
			  Date_post = DateTime.Parse(c.date_post.ToString()).ToString("yyyy-M-d hh:mm tt", new System.Globalization.CultureInfo("en-US")),
			  Role = c.role,
			  Img = c.imglist == "Null" ? false : true,
			  Imgurl = c.imglist,
			  UserId = 0,
			  PostId = c.Id,
			  View = c.View,
			  Comment = c.Comment,
			  PostType = c.type_post.Remove(c.type_post.Length - 1),
			  Color = c.Color,
			  typedata = "none",
			}).ToList();
```

这是Spring MVC

```java
public List<PostData> getAdminData(List<AdminEntity> adminList) {
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-M-d hh:mm a", Locale.US);

        return adminList.stream()
                .map(c -> new PostData(
                        c.getTitle(),
                        "", // Username is empty
                        LocalDateTime.parse(c.getDatePost().toString()).format(formatter), // Parse date and format
                        c.getRole(),
                        !"Null".equals(c.getImglist()), // Img condition
                        c.getImglist(),
                        0, // UserId is 0
                        c.getId(),
                        c.getView(),
                        c.getComment(),
                        c.getTypePost().substring(0, c.getTypePost().length() - 1), // Remove last character
                        c.getColor(),
                        "none" // typedata is "none"
                ))
                .collect(Collectors.toList());
    }
```

2. Where 搜寻

   这是 C# 语法

   ```c#
   ar Admin_Data = (from c in User_list
   							  where c.userid == 1
   							  select new PostData
   							  {
   								  Title = c.title,
   								  Username = "",
   								  Date_post = DateTime.Parse(c.date_post.ToString()).ToString("yyyy-M-d hh:mm tt", new System.Globalization.CultureInfo("en-US")),
   								  Role = c.role,
   								  Img = c.imglist == "Null" ? false : true,
   								  Imgurl = c.imglist,
   								  UserId = 0,
   								  PostId = c.Id,
   								  View = c.View,
   								  Comment = c.Comment,
   								  PostType = c.type_post.Remove(c.type_post.Length - 1),
   								  Color = c.Color,
   								  typedata = "none",
   							  }).ToList();
   
   ```

   这是 Spring MVC 语法

   ```java
   public List<PostData> getAdminData(List<UserEntity> userList) {
           DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-M-d hh:mm a", Locale.US);
   
           // 过滤出 userid == 1 的数据并转换为 PostData
           List<PostData> adminData = userList.stream()
                   .filter(c -> c.getUserid() == 1) // 相当于 LINQ 的 where c.userid == 1
                   .map(c -> new PostData(
                           c.getTitle(),
                           "", // Username is empty
                           LocalDateTime.parse(c.getDatePost().toString()).format(formatter), // 解析日期并格式化
                           c.getRole(),
                           !"Null".equals(c.getImglist()), // 三元操作符
                           c.getImglist(),
                           0, // UserId is 0
                           c.getId(),
                           c.getView(),
                           c.getComment(),
                           c.getTypePost().substring(0, c.getTypePost().length() - 1), // 移除最后一个字符
                           c.getColor(),
                           "none" // typedata 是 "none"
                   ))
                   .collect(Collectors.toList());
   
           return adminData;
       }
   ```

3. Join 链接

C# 语法

```c#
var db = (from c in User_list
					  join us in user_list on c.userid equals us.Id
					  select new PostData
					  {
						  Title = c.title,
						  Username = us.username,
						  Date_post = DateTime.Parse(c.date_post.ToString()).ToString("yyyy-M-d hh:mm tt", new System.Globalization.CultureInfo("en-US")),
						  Role = c.role,
						  Img = c.imglist == "Null" ? false : true,
						  Imgurl = c.imglist,
						  UserId = us.Id,
						  PostId = c.Id,
						  View = c.View,
						  Comment = c.Comment,
						  PostType = c.type_post.Remove(c.type_post.Length - 1),
						  Color = c.Color,
						  typedata = "none",
					  }).OrderByDescending(x => x.PostId).ToList();
```

Spring MVC 语法

```java
public List<PostData> getJoinedAdminData(List<UserEntity> userList, List<UserEntity> otherUserList) {
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-M-d hh:mm a", Locale.US);

        // 连接 User_list 和 user_list 的数据，通过 userid 进行匹配
        List<PostData> joinedData = userList.stream()
                .flatMap(c -> otherUserList.stream()
                        .filter(us -> c.getUserid() == us.getId()) // 相当于 LINQ 的 join 条件
                        .map(us -> new PostData(
                                c.getTitle(),
                                us.getUsername(), // 从连接的结果中获取用户名
                                LocalDateTime.parse(c.getDatePost().toString()).format(formatter), // 解析日期并格式化
                                c.getRole(),
                                !"Null".equals(c.getImglist()), // 三元操作符
                                c.getImglist(),
                                us.getId(), // 关联后的 UserId
                                c.getId(), // PostId
                                c.getView(),
                                c.getComment(),
                                c.getTypePost().substring(0, c.getTypePost().length() - 1), // 移除最后一个字符
                                c.getColor(),
                                "none" // typedata 是 "none"
                        ))
                )
                .sorted((x, y) -> Integer.compare(y.getPostId(), x.getPostId())) // 按 PostId 降序排序
                .collect(Collectors.toList());

        return joinedData;
    }
```

4. 完整 语法  (where, select 和 join 逻辑)

   ```java
    // Public方法，包含 where, select 和 join 逻辑
       public List<PostData> getPostData(List<UserEntity> userList, List<UserEntity> otherUserList, int filterUserId) {
           
           // 直接进行 where, select, join 和排序操作
           List<PostData> postDataList = userList.stream()
                   .filter(c -> c.getUserid() == filterUserId || filterUserId == 0) // where 条件，0时不过滤
                   .flatMap(c -> otherUserList.stream()
                           .filter(us -> c.getUserid() == us.getId()) // join 条件
                           .map(us -> new PostData(
                                   c.getTitle(),
                                   us.getUsername(), // 从 otherUserList 获取的 Username
                                   LocalDateTime.parse(c.getDatePost().toString()).format(formatter), // 日期格式化
                                   c.getRole(),
                                   !"Null".equals(c.getImglist()), // 判断 imglist 是否为 "Null"
                                   c.getImglist(),
                                   us.getId(), // 关联后的 UserId
                                   c.getId(), // PostId
                                   c.getView(),
                                   c.getComment(),
                                   c.getTypePost().substring(0, c.getTypePost().length() - 1), // 去掉最后一个字符
                                   c.getColor(),
                                   "none" // typedata 默认是 "none"
                           ))
                   )
                   .sorted((x, y) -> Integer.compare(y.getPostId(), x.getPostId())) // 按 PostId 降序排序
                   .collect(Collectors.toList());
   
           return postDataList;
       }
   ```

   5. 返回 Json 格式

      ```java
      // 示例方法，类似于 C# 中的返回 JSON 的方式
          @GetMapping("/getJsonData")
          @ResponseBody
          public List<Map<String, Object>> getJsonData() {
              // 模拟的数据：keyValuePairs 和 userdata 列表
              List<Map.Entry<String, Integer>> keyValuePairs = List.of(
                      Map.entry("1", 101),
                      Map.entry("2", 102)
              );
      
              List<UserEntity> userdata = List.of(
                      new UserEntity(101, "avatar1.png", "John", "0", "123 Street", 5),
                      new UserEntity(102, "avatar2.png", "Jane", "1", "456 Avenue", 10)
              );
      
              // Join 操作：根据 keyValuePairs 的 value 和 userdata 的 Id 进行连接
              List<Map<String, Object>> json = keyValuePairs.stream()
                      .flatMap(c -> userdata.stream()
                              .filter(user -> c.getValue().equals(user.getId())) // join 条件
                              .map(user -> Map.of(
                                      "id", c.getKey(),
                                      "avatar", user.getAvatar(),
                                      "name", user.getUsername(),
                                      "gender", "0".equals(user.getGender()) ? "Male" : "Female",
                                      "address", user.getAddress(),
                                      "lv", "LV." + user.getLevel()
                              ))
                      )
                      .collect(Collectors.toList());
      
              // 返回 JSON 响应
              return json;
          }
      ```

      





































































































```
@Data
@AllArgsConstructor
@NoArgsConstructor

@Repository
```















