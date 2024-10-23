## MyBatis 基础

新关卡！新篇章！ 番外篇！**黑暗神鸟篇章！**



主流的 **ORM 框架**，之前叫 **iBatis**, 后来改名 **MyBatis**

如果你使用的是 **Spring MyBatis** 而不是 **Spring Boot**，并希望自动将实体类生成数据库表（类似于 JPA 的自动表生成），**MyBatis** 本身并不支持这种功能。**MyBatis** 是一个 **ORM 框架**，用于映射 SQL 语句和 Java 对象，但它不会像 JPA 那样自动创建数据库表。

不能自动创建数据库表，不支持！



是的，**MyBatis** 本身只能使用已经存在的数据库和表结构，它不会像 JPA 或 Hibernate 那样自动生成数据库表结构。



可以 **CRUD**



#### MyBatis 入门

1，配置 pom.xml

```xml
<dependencies>

        <!-- MyBatis -->
        <dependency>
            <groupId>org.mybatis</groupId>
            <artifactId>mybatis</artifactId>
            <version>3.5.16</version>
        </dependency>

        <!-- MySQL -->
        <dependency>
            <groupId>mysql</groupId>
            <artifactId>mysql-connector-java</artifactId>
            <version>8.0.33</version>
        </dependency>

        <!-- lombok -->
        <dependency>
            <groupId>org.projectlombok</groupId>
            <artifactId>lombok</artifactId>
            <version>1.18.34</version>
        </dependency>
    
    <!-- ehcache -->
        <dependency>
            <groupId>net.sf.ehcache</groupId>
            <artifactId>ehcache-core</artifactId>
            <version>2.6.11</version>
        </dependency>

        <!-- ehcache -->
        <dependency>
            <groupId>org.mybatis</groupId>
            <artifactId>mybatis-ehcache</artifactId>
            <version>1.0.0</version>
        </dependency>

    </dependencies>

    <build>
        <resources>
            <resource>
                <directory>src/main/resources</directory>
                <includes>
                    <include>**/*.xml</include>
                </includes>
            </resource>
        </resources>
    </build>
```

2，创建实体类

```java
package com.xs.entity;

import lombok.Data;

@Data
public class People {
    private Integer id;
    private String name;
    private Double money;
}
```

3，配置 config.xml

```xml
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE configuration PUBLIC "-//mybatis.org//DTD Config 3.0//EN" "http://mybatis.org/dtd/mybatis-3-config.dtd">
<configuration>
    <!-- 配置 MyBatis 运行 -->
    <environments default="development">
        <environment id="development">
            <transactionManager type="JDBC"/>
            <dataSource type="POOLED">
                <property name="driver" value="com.mysql.cj.jdbc.Driver"/>
                <property name="url" value="jdbc:mysql://localhost:3306/mybatistest?useUnicode=true&amp;charset=UTF-8"/> <!-- 修改你自己的database 名称 -->
                <property name="username" value="root"/>
                <property name="password" value=""/>
            </dataSource>
        </environment>
    </environments>

    <mappers>
        <!-- 修改为 resources 根目录的映射文件 -->
        <mapper resource="mapper/PeopleMapper.xml"/> <!-- 这里的路径要与实际文件位置一致 -->
    </mappers>

</configuration>
```

4，配置 resource/mapper/PeopleMapper.xml

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE mapper PUBLIC "-//mybatis.org//DTD Mapper 3.0//EN" "http://mybatis.org/dtd/mybatis-3-mapper.dtd">
<mapper namespace="PeopleMapper">
    <select id="findById" parameterType="java.lang.Integer" resultType="com.xs.entity.People">
        select * from people where id = #{id}
    </select>
</mapper>
```

5，Mysql 里创建一个数据

6，main

```java
package com.xs.test;

import com.xs.entity.People;
import org.apache.ibatis.session.SqlSession;
import org.apache.ibatis.session.SqlSessionFactory;
import org.apache.ibatis.session.SqlSessionFactoryBuilder;

import java.io.InputStream;

public class Test {

    public static void main(String[] args) {
        
        // 加载 MyBatis 配置文件
        InputStream inp = Test.class.getClassLoader().getResourceAsStream("config.xml");
        SqlSessionFactoryBuilder sqlSFB = new SqlSessionFactoryBuilder();
        SqlSessionFactory sqlF = sqlSFB.build(inp);

        // 获取 SqlSession
        SqlSession sqlS = sqlF.openSession();
        String statement = "PeopleMapper.findById"; // 匹配的 namespace 和 id
        People people = sqlS.selectOne(statement,1);
        System.out.println(people);
        sqlS.close();

    }

}
```



#### Mapper 代理实现自定义接口

使用这个方式 ， 比较熟悉

1，自定义 接口

```java
package com.xs.repository;

import com.xs.entity.People;
import java.util.List;

public interface PeopleRepository {
    public int save(People people);
    public int deleteById(Integer id);
    public int update(People people);
    public People findById(Integer id);
    public List<People> findAll();
//    public People findById2(int id);
//    public People findByIdAndName(int id, String name);
}
```

2，配置 resource/repository/PeopleRepository

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE mapper PUBLIC "-//mybatis.org//DTD Mapper 3.0//EN" "http://mybatis.org/dtd/mybatis-3-mapper.dtd">
<!-- 接口的路径 -->
<mapper namespace="com.xs.repository.PeopleRepository">
    <insert id="save" parameterType="com.xs.entity.People">
        insert into people(name, money) values(#{name},#{money})
    </insert>

    <delete id="deleteById" parameterType="java.lang.Integer">
        delete from people where id = #{id}
    </delete>

    <update id="update" parameterType="com.xs.entity.People">
        update people set name = #{name}, money = #{money} where id = #{id}
    </update>

    <select id="findById" parameterType="java.lang.Integer" resultType="com.xs.entity.People">
        select * from people where id = #{id}
    </select>

    <select id="findAll" resultType="com.xs.entity.People">
        select * from people
    </select>
    
<!--    <select id="findById2" parameterType="int" resultType="com.xs.entity.People">-->
<!--        select * from people where id = #{num}-->
<!--    </select>-->

</mapper>
```

3，配置 config.xml

```xml
<mappers>
        <!-- 修改为 resources 根目录的映射文件 -->
        <mapper resource="repository/PeopleRepository.xml"/> <!-- xml的路径 -->
    </mappers>
```

4，main

```java
package com.xs.test;

import com.xs.entity.People;
import com.xs.repository.PeopleRepository;
import org.apache.ibatis.session.SqlSession;
import org.apache.ibatis.session.SqlSessionFactory;
import org.apache.ibatis.session.SqlSessionFactoryBuilder;

import java.io.InputStream;

public class Test2 {

    public static void main(String[] args) {
        
        // 加载 MyBatis 配置文件
        InputStream inp = Test2.class.getClassLoader().getResourceAsStream("config.xml");
        SqlSessionFactoryBuilder sqlSFB = new SqlSessionFactoryBuilder();
        SqlSessionFactory sqlF = sqlSFB.build(inp);

        // 获取 SqlSession
        SqlSession sqlS = sqlF.openSession();
        PeopleRepository peopleRepository = sqlS.getMapper(PeopleRepository.class);

        // add & save
//        People p = new People();
//        p.setName("July");
//        p.setMoney(Double.parseDouble("657"));
//        peopleRepository.save(p);

        // update
//        People p = peopleRepository.findById(2);
//        p.setName("哈哈");
//        p.setMoney(Double.parseDouble("111"));
//        peopleRepository.update(p);
        
        // findAll
//        List<People> list = peopleRepository.findAll();
//        for(People people:list){
//            System.out.println(people);
//        }

        sqlS.commit(); // 不要忘记提交事务
        sqlS.close();

    }

}
```



#### 实现 一 对 多 关系

**两个数据库 连接 自定义**

1，Classes 和 Student

```java
package com.xs.entity;

import lombok.Data;

import java.util.List;

@Data
public class Classes {
    private Integer id;
    private String name;
    private List<Student> students; //不需要放在phpMyadmin
}
```

```java
package com.xs.entity;

import lombok.Data;

@Data
public class Student {
    private Integer id;
    private String name;
    private Classes cid;
}
```

2，创建 Student 接口

```java
package com.xs.repository;

import com.xs.entity.Student;

public interface StudentRepository {
    public Student findById(Integer id);
}
```

3，创建 Student xml

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE mapper PUBLIC "-//mybatis.org//DTD Mapper 3.0//EN" "http://mybatis.org/dtd/mybatis-3-mapper.dtd">
<!-- 接口的路径 -->
<mapper namespace="com.xs.repository.StudentRepository">

    <!-- 输出结果： Student(id=1, name=Hoo, cid=Classes(id=1, name=一班)) -->
    <resultMap id="studentMap" type="com.xs.entity.Student">
        <id column="sid" property="id"/>
        <result column="sname" property="name"/>
        <association property="cid" javaType="com.xs.entity.Classes">
            <id column="cid" property="id"/>
            <result column="cname" property="name"/>
        </association>
    </resultMap>

    <select id="findById" parameterType="java.lang.Integer" resultMap="studentMap">
        select s.id sid,s.name sname,c.id cid,c.name cname from student s, classes c where s.id = #{id} and s.cid = c.id
    </select>

</mapper>
```

4， 配置 config.xml

```xml
<mapper resource="repository/StudentRepository.xml"/> <!-- xml的路径 -->
```

5，main

```java
package com.xs.test;

import com.xs.entity.Classes;
import com.xs.entity.People;
import com.xs.entity.Student;
import com.xs.repository.ClassesRepository;
import com.xs.repository.StudentRepository;
import org.apache.ibatis.session.SqlSession;
import org.apache.ibatis.session.SqlSessionFactory;
import org.apache.ibatis.session.SqlSessionFactoryBuilder;

import java.io.InputStream;

public class Test4 {

    public static void main(String[] args) {
        // 加载 MyBatis 配置文件
        InputStream inp = Test.class.getClassLoader().getResourceAsStream("config.xml");
        SqlSessionFactoryBuilder sqlSFB = new SqlSessionFactoryBuilder();
        SqlSessionFactory sqlF = sqlSFB.build(inp);

        // 获取 SqlSession
        SqlSession sqlS = sqlF.openSession();

        // Student
//        StudentRepository studentRepository = sqlS.getMapper(StudentRepository.class);
//        Student student = studentRepository.findById(1);
//        System.out.println(student);

        // Classes
        ClassesRepository classesRepository = sqlS.getMapper(ClassesRepository.class);
        Classes classes = classesRepository.findById(1);
        System.out.println(classes);
        
    }

}
```



**Classes**

1，接口

```Java
package com.xs.repository;

import com.xs.entity.Classes;

public interface ClassesRepository {
    public Classes findById(Integer id);
}
```

2，ClassesRepository.xml 配置 和 代码

```xml
<mapper resource="repository/ClassesRepository.xml"/> <!-- xml的路径 -->
```

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE mapper PUBLIC "-//mybatis.org//DTD Mapper 3.0//EN" "http://mybatis.org/dtd/mybatis-3-mapper.dtd">
<!-- 接口的路径 -->
<mapper namespace="com.xs.repository.ClassesRepository">

    <resultMap id="classesMap" type="com.xs.entity.Classes">
        <id column="cid" property="id"/>
        <result column="cname" property="name"/>
        <collection property="students" ofType="com.xs.entity.Student">
            <id column="sid" property="id"/>
            <result column="sname" property="name"/>
        </collection>
    </resultMap>

    <select id="findById" parameterType="java.lang.Integer" resultMap="classesMap">
        select c.id cid,c.name cname,s.id sid,s.name sname from classes c, student s where c.id = #{id} and c.id = s.cid
    </select>

</mapper>
```



#### MyBatis 逆向工程

#### 禁！自动生成已存在的表单在项目里

1，配置 pom

```xml
<dependency>
      <groupId>org.mybatis</groupId>
      <artifactId>mybatis</artifactId>
      <version>3.5.16</version>
    </dependency>

    <dependency>
      <groupId>mysql</groupId>
      <artifactId>mysql-connector-java</artifactId>
      <version>8.0.33</version>
    </dependency>

    <dependency>
      <groupId>org.mybatis.generator</groupId>
      <artifactId>mybatis-generator-core</artifactId>
      <version>1.4.0</version>
    </dependency>
```

2，创建 generatorConfig.xml

```xml
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE generatorConfiguration
        PUBLIC "-//mybatis.org//DTD MyBatis Generator Configuration 1.0//EN"
        "http://mybatis.org/dtd/mybatis-generator-config_1_0.dtd">
<generatorConfiguration>
    <context id="MySqlContext" targetRuntime="MyBatis3">
        <jdbcConnection driverClass="com.mysql.cj.jdbc.Driver"
                        connectionURL="jdbc:mysql://localhost:3306/testmybatis"
                        userId="root"
                        password=""/>
        <javaModelGenerator targetPackage="com.xs.entity" targetProject="src/main/java"/>
        <sqlMapGenerator targetPackage="mapper" targetProject="src/main/resources"/>
        <javaClientGenerator type="XMLMAPPER" targetPackage="com.xs.mapper" targetProject="src/main/java"/>

        <table tableName="student" domainObjectName="Student"/>
        <table tableName="people" domainObjectName="People"/>
        <table tableName="classes" domainObjectName="Classes"/>
    </context>
</generatorConfiguration>
```

## 配置 DTD

3，下载 mybatis-generator-config_1_0.dtd 文件，在Setting -> Languages & Frameworks -> Schemas and DTDs 引入

URI 名称： http://mybatis.org/dtd/mybatis-generator-config_1_0.dtd

URI 名称： http://mybatis.org/dtd/mybatis-3-config.dtd

```
mybatis-3-config.dtd  也一样要引入
```

4，创建 generator -> MyBatisGeneratorRunner.java  启动

```java
package com.xs.generator;

import org.mybatis.generator.api.MyBatisGenerator;
import org.mybatis.generator.config.Configuration;
import org.mybatis.generator.config.xml.ConfigurationParser;
import org.mybatis.generator.internal.DefaultShellCallback;

import java.io.File;
import java.util.ArrayList;
import java.util.List;

public class MyBatisGeneratorRunner {
    public static void main(String[] args) throws Exception {
        List<String> warnings = new ArrayList<>();
        boolean overwrite = true;
        File configFile = new File("src/main/resources/generatorConfig.xml"); // 修改为您的配置文件路径
        ConfigurationParser cp = new ConfigurationParser(warnings);
        Configuration config = cp.parseConfiguration(configFile);
        DefaultShellCallback callback = new DefaultShellCallback(overwrite);
        MyBatisGenerator myBatisGenerator = new MyBatisGenerator(config, callback, warnings);
        myBatisGenerator.generate(null);

        // 输出生成的警告
        for (String warning : warnings) {
            System.out.println(warning);
        }
    }
}
```



#### MyBatis 延迟加载

使用延迟加载（`lazyLoadingEnabled=true`）的好处在于，MyBatis 只会在需要时加载相关的数据，减少不必要的数据加载，优化性能。具体的好处包括：

1. **提高性能**：
   - 延迟加载意味着 MyBatis 只会在你真正使用关联对象时，才会去查询数据库。例如，一个 `Student` 对象有一个关联的 `Classes` 对象，只有在你调用 `student.getClasses()` 时，才会去加载 `Classes` 对象。这样可以减少不必要的查询，提升应用的性能。
2. **减少内存占用**：
   - 如果你有大量关联对象，但是并不需要立即访问它们，延迟加载可以避免一次性加载大量数据到内存中，节省内存消耗。
3. **更高的灵活性**：
   - 延迟加载让你可以按需加载关联的数据。如果某个场景下你不需要关联数据，MyBatis 不会去查询关联表。这给开发者更多控制，避免了数据库的过度查询。
4. **提高响应速度**：
   - 对于一些只需要部分数据的场景，延迟加载可以让你更快地获取初始数据，而不是一次性加载所有相关联的数据，从而减少初始查询时间，提高接口响应速度。

1，config.xml 配置

```xml
<configuration>

    <!-- 延迟加载 -->
    <settings>
        <setting name="logImpl" value="STDOUT_LOGGING"/>
        <setting name="lazyLoadingEnabled" value="true"/>
    </settings>
```

2，创建 order 和 customer

```java
package com.xs.entity;

import lombok.Data;

@Data
public class Order {
    private Integer id;
    private String name;
    private Customer customer;
}
```

```java
package com.xs.entity;

import lombok.Data;

import java.util.List;

@Data
public class Customer {
    private Integer id;
    private String name;
    private List<Order> orders;
}
```

3，创建 repository

```java
package com.xs.repository;

import com.xs.entity.Order;

public interface OrderRepository {
    public Order findById(Integer id);
}
```

```java
package com.xs.repository;

import com.xs.entity.Customer;

public interface CustomerRepository {
    public Customer findById(Integer id);
}
```

4，repository.xml

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE mapper PUBLIC "-//mybatis.org//DTD Mapper 3.0//EN" "http://mybatis.org/dtd/mybatis-3-mapper.dtd">
<!-- 接口的路径 -->
<mapper namespace="com.xs.repository.OrderRepository">

    <resultMap id="orderMap" type="com.xs.entity.Order">
        <id column="id" property="id"/>
        <result column="name" property="name"/>
        <association property="customer" javaType="com.xs.entity.Customer" select="com.xs.repository.CustomerRepository.findById" column="cid"/>
    </resultMap>

    <select id="findById" parameterType="java.lang.Integer" resultMap="orderMap">
        SELECT * FROM `order` WHERE id = #{id}
    </select>

</mapper>
```

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE mapper PUBLIC "-//mybatis.org//DTD Mapper 3.0//EN" "http://mybatis.org/dtd/mybatis-3-mapper.dtd">
<!-- 接口的路径 -->
<mapper namespace="com.xs.repository.CustomerRepository">

    <resultMap id="orderMap" type="com.xs.entity.Order">
        <id column="id" property="id"/>
        <result column="name" property="name"/>
        <association property="customer" javaType="com.xs.entity.Customer" select="com.xs.repository.CustomerRepository.findById" column="cid"/>
    </resultMap>

    <select id="findById" parameterType="java.lang.Integer" resultType="com.xs.entity.Customer">
        select * from customer where id = #{id}
    </select>

</mapper>
```

5，配置 config.xml

```xml
<mapper resource="repository/CustomerRepository.xml"/> <!-- xml的路径 -->
<mapper resource="repository/OrderRepository.xml"/> <!-- xml的路径 -->
```

6，main

```java
package com.xs.test;

import com.xs.entity.Order;
import com.xs.repository.OrderRepository;
import org.apache.ibatis.session.SqlSession;
import org.apache.ibatis.session.SqlSessionFactory;
import org.apache.ibatis.session.SqlSessionFactoryBuilder;

import java.io.InputStream;

public class Test5 {

    public static void main(String[] args) {
        // 加载 MyBatis 配置文件
        InputStream inp = Test.class.getClassLoader().getResourceAsStream("config.xml");
        SqlSessionFactoryBuilder sqlSFB = new SqlSessionFactoryBuilder();
        SqlSessionFactory sqlF = sqlSFB.build(inp);

        // 获取 SqlSession
        SqlSession sqlS = sqlF.openSession();
        OrderRepository orderRepository = sqlS.getMapper(OrderRepository.class);
        Order order = orderRepository.findById(4);
        System.out.println(order);
        // 结果
        // Order(id=4, name=订单4, customer=Customer(id=3, name=Vn, orders=null))
        
    }

}
```



#### MyBatis 缓存

使用 MyBatis 的 **二级缓存** 有以下几个好处：

##### 1. **减少数据库查询次数**

二级缓存将查询结果存储在缓存中，当相同的查询再次发出时，直接从缓存中读取数据，而不是每次都从数据库中重新获取。这减少了对数据库的访问频率，提高了系统的响应速度。

##### 2. **提升系统性能**

通过减少对数据库的访问，降低了数据库负载，尤其是在数据变化不频繁但查询频繁的场景中。缓存能够显著提升系统性能，尤其是对于高并发的应用场景。

##### 3. **节约资源**

数据库是系统中耗费资源较多的部分，减少对其查询可以节省 CPU 和 I/O 资源。缓存可以缓解数据库的压力，减少响应时间，提升用户体验。

##### 4. **跨 Session 的共享**

与一级缓存不同，二级缓存可以跨 `SqlSession` 共享。这意味着在同一个 MyBatis 应用中，不同的 `SqlSession` 可以共享缓存数据，进一步减少重复查询。

##### 5. **持久化缓存数据**

如果配置了合适的缓存存储策略，二级缓存的数据可以持久化到磁盘或其他存储介质，这样即使应用重启也能从缓存中快速恢复数据，减少重新查询数据库的开销。

##### 适用场景

二级缓存适合以下场景：

- **读多写少**：数据更新较少，而查询频繁的系统，如用户信息、产品目录等。
- **高并发读请求**：高流量的读请求场景中，通过缓存可以显著提高查询效率。

##### 注意事项

- **缓存数据的一致性问题**：二级缓存会缓存查询结果，当数据库中的数据发生变更时，必须确保缓存中的数据也能够及时失效或更新，以避免数据不一致的问题。
- **缓存的存储空间**：缓存占用内存或磁盘空间，因此要合理配置缓存的大小，以避免占用过多资源。

在恰当的场景下，使用二级缓存能显著提高系统的效率。

1，配置 pom

```xml
<!-- ehcache -->
        <dependency>
            <groupId>net.sf.ehcache</groupId>
            <artifactId>ehcache-core</artifactId>
            <version>2.6.11</version>
        </dependency>

        <!-- ehcache -->
        <dependency>
            <groupId>org.mybatis.caches</groupId>
            <artifactId>mybatis-ehcache</artifactId>
            <version>1.2.1</version> <!-- 请根据最新版本选择 -->
        </dependency>

<!-- slf4j 缓存 -->
        <dependency>
            <groupId>org.slf4j</groupId>
            <artifactId>slf4j-simple</artifactId>
            <version>1.7.36</version> <!-- 选择适合的版本 -->
        </dependency>
```

2，实体类

```java
package com.xs.entity;

import lombok.Data;

import java.io.Serializable;

@Data
public class MyClass implements Serializable {
    private Integer id;
    private String name;
}
```

3，Repository JAVA

```java
package com.xs.repository;

import com.xs.entity.MyClass;

public interface MyClassRepository {
    public MyClass findById(Integer id);
}
```

4，Repository XML

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE mapper PUBLIC "-//mybatis.org//DTD Mapper 3.0//EN" "http://mybatis.org/dtd/mybatis-3-mapper.dtd">
<!-- 接口的路径 -->
<mapper namespace="com.xs.repository.MyClassRepository">

    <!-- 配置 二级缓存 -->
    <cache type="org.mybatis.caches.ehcache.EhcacheCache">
        <property name="timeToIdleSeconds" value="3600"/>
        <property name="timeToLiveSeconds" value="3600"/>
        <property name="memoryStoreEvictionPolicy" value="LRU"/>
    </cache>

    <select id="findById" parameterType="java.lang.Integer" resultType="com.xs.entity.MyClass">
        SELECT * FROM classes WHERE id = #{id}
    </select>

</mapper>
```

5，配置 二级缓存

```xml
<settings>
        
        <!-- 二级缓存 -->
        <setting name="cacheEnabled" value="true"/>
    </settings>
```

6，配置 config.xml

```xml
<mapper resource="repository/MyClassRepository.xml"/> <!-- xml的路径 -->
```

7，main

```java
package com.xs.test;

import com.xs.entity.MyClass;
import com.xs.entity.Order;
import com.xs.repository.MyClassRepository;
import com.xs.repository.OrderRepository;
import org.apache.ibatis.session.SqlSession;
import org.apache.ibatis.session.SqlSessionFactory;
import org.apache.ibatis.session.SqlSessionFactoryBuilder;

import java.io.InputStream;

public class Test6 {

    public static void main(String[] args) {
        // 加载 MyBatis 配置文件
        InputStream inp = Test.class.getClassLoader().getResourceAsStream("config.xml");
        SqlSessionFactoryBuilder sqlSFB = new SqlSessionFactoryBuilder();
        SqlSessionFactory sqlF = sqlSFB.build(inp);

        // 获取 SqlSession
        SqlSession sqlS = sqlF.openSession();
        MyClassRepository myClassRepository = sqlS.getMapper(MyClassRepository.class);

        // 第一次查询
        MyClass mc1 = myClassRepository.findById(1);
        System.out.println(mc1);
        
        sqlS.close();

        // 第二次查询，同样的查询应该命中缓存
        sqlS = sqlF.openSession();
        myClassRepository = sqlS.getMapper(MyClassRepository.class);
        MyClass mc2 = myClassRepository.findById(1);
        System.out.println(mc2);

        sqlS.close();

    }

}
```

8，在 resource 创建 ehcache.xml

```xml
<ehcache xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="http://www.ehcache.org/ehcache.xsd"
         updateCheck="false"
         monitoring="autodetect"
         dynamicConfig="true">

    <!-- 默认缓存配置 -->
    <defaultCache
            maxEntriesLocalHeap="1000"
            eternal="false"
            timeToIdleSeconds="120"
            timeToLiveSeconds="120"
            overflowToDisk="true"
            diskSpoolBufferSizeMB="30"
            maxEntriesLocalDisk="10000000"
            diskPersistent="false"
            diskExpiryThreadIntervalSeconds="120"
            memoryStoreEvictionPolicy="LRU"/>

    <!-- 自定义缓存配置 -->
    <cache name="exampleCache"
           maxEntriesLocalHeap="1000"
           eternal="false"
           timeToIdleSeconds="300"
           timeToLiveSeconds="600"
           overflowToDisk="true"
           diskSpoolBufferSizeMB="20"
           maxEntriesLocalDisk="10000000"
           diskPersistent="false"
           memoryStoreEvictionPolicy="LRU">
    </cache>

    <!-- 另外一个自定义缓存 -->
    <cache name="anotherCache"
           maxEntriesLocalHeap="500"
           eternal="true"
           overflowToDisk="true"
           diskSpoolBufferSizeMB="50"
           maxEntriesLocalDisk="500000"
           diskPersistent="true"
           diskExpiryThreadIntervalSeconds="60"
           memoryStoreEvictionPolicy="FIFO">
    </cache>

</ehcache>
```



#### MyBatis 动态 SQL

1，实体类

```java
package com.xs.entity;

import lombok.Data;

@Data
public class User {
    private Integer id;
    private String username;
    private String password;
    private Integer age;
}
```

2，Repository JAVA

```java
package com.xs.repository;

import com.xs.entity.User;

public interface UserRepository {
    public User findByUser(User user);
}
```

3，配置 config.xml

```xml
<mapper resource="repository/UserRepository.xml"/> <!-- xml的路径 -->
```

4，Repository XML

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE mapper PUBLIC "-//mybatis.org//DTD Mapper 3.0//EN" "http://mybatis.org/dtd/mybatis-3-mapper.dtd">
<!-- 接口的路径 -->
<mapper namespace="com.xs.repository.UserRepository">

    <select id="findByUser" parameterType="com.xs.entity.User" resultType="com.xs.entity.User">
        SELECT * FROM user
        <where>
            <if test="id!=null">
                id = #{id}
            </if>
            <if test="username!=null">
                and username = #{username}
            </if>
            <if test="password!=null">
                and password = #{password}
            </if>
            <if test="age!=null">
                and age = #{age}
            </if>
        </where>
    </select>

</mapper>
```

5，main

```java
package com.xs.test;

import com.xs.entity.MyClass;
import com.xs.entity.Order;
import com.xs.entity.User;
import com.xs.repository.MyClassRepository;
import com.xs.repository.OrderRepository;
import com.xs.repository.UserRepository;
import org.apache.ibatis.session.SqlSession;
import org.apache.ibatis.session.SqlSessionFactory;
import org.apache.ibatis.session.SqlSessionFactoryBuilder;

import java.io.InputStream;

public class Test7 {

    public static void main(String[] args) {
        // 加载 MyBatis 配置文件
        InputStream inp = Test.class.getClassLoader().getResourceAsStream("config.xml");
        SqlSessionFactoryBuilder sqlSFB = new SqlSessionFactoryBuilder();
        SqlSessionFactory sqlF = sqlSFB.build(inp);

        // 获取 SqlSession
        SqlSession sqlS = sqlF.openSession();
        UserRepository userRepository = sqlS.getMapper(UserRepository.class);
        User u = new User();
        u.setId(2);
        u.setUsername("BGG");
//        u.setPassword("5566");
//        u.setAge(9);
        User user = userRepository.findByUser(u);
        System.out.println(user);

    }

}
```

##### Choose / When 动态 写法

```xml
<select id="findByUser" parameterType="com.xs.entity.User" resultType="com.xs.entity.User">
        SELECT * FROM user
        <where>
            <choose>
                <when test="id!=null">
                    id = #{id}
                </when>
                <when test="username!=null">
                    and username = #{username}
                </when>
                <when test="password!=null">
                    and password = #{password}
                </when>
                <when test="age!=null">
                    and age = #{age}
                </when>
            </choose>
        </where>
    </select>
```

##### Trim 动态 写法

```xml
<select id="findByUser" parameterType="com.xs.entity.User" resultType="com.xs.entity.User">
        SELECT * FROM user
        <trim prefix="where" prefixOverrides="and">
            <if test="id!=null">
                id = #{id}
            </if>
            <if test="username!=null">
                and username = #{username}
            </if>
            <if test="password!=null">
                and password = #{password}
            </if>
            <if test="age!=null">
                and age = #{age}
            </if>
        </trim>
    </select>
```

##### set 动态 写法

用于 **Update** 操作

1，Repository JAVA

```java
package com.xs.repository;

import com.xs.entity.User;

public interface UserRepository {
    public User findByUser(User user);
    public int update(User user);
}
```

2，Repository XML

```xml
<update id="update" parameterType="com.xs.entity.User">
        update user
        <set>
            <if test="username != null">
                username = #{username},
            </if>
            <if test="password != null">
                password = #{password},
            </if>
            <if test="age != null">
                age = #{age}
            </if>
        </set>
        where id = #{id}
    </update>
```























