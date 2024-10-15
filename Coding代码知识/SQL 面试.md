

# 🌒 SQL 面试 🌒

🐣 **SQL** (Structured Query Language:结构化查询语言) 是用于管理关系数据库管理系统（RDBMS）。 SQL 的范围包括数据插入、查询、更新和删除，数据库模式创建和修改，以及数据访问控制。



[SQL 高级教程]: https://www.runoob.com/sql/sql-top.html



## SQL 能做什么？

- SQL 面向数据库执行查询
- SQL 可从数据库取回数据
- SQL 可在数据库中插入新的记录
- SQL 可更新数据库中的数据
- SQL 可从数据库删除记录
- SQL 可创建新数据库
- SQL 可在数据库中创建新表
- SQL 可在数据库中创建存储过程
- SQL 可在数据库中创建视图
- SQL 可以设置表、存储过程和视图的权限



## 🥘 SELECT 语句

```
SELECT * FROM Websites;
```

```
SELECT name,country FROM Websites;
```



## 🥘 SQL SELECT DISTINCT 语句

在表中，一个列可能会包含多个重复值，有时您也许希望仅仅列出不同（distinct）的值。

DISTINCT 关键词用于返回唯一不同的值。

```
SELECT DISTINCT country FROM Websites;
```

```
SELECT COUNT(DISTINCT Country) FROM Customers;
```



## 🥘 SQL WHERE 语法

```
SELECT * FROM Websites WHERE country='CN';

SELECT * FROM Websites WHERE id=1;
```

| 运算符  | 描述                                                       |
| :------ | :--------------------------------------------------------- |
| =       | 等于                                                       |
| <>      | 不等于。**注释：**在 SQL 的一些版本中，该操作符可被写成 != |
| >       | 大于                                                       |
| <       | 小于                                                       |
| >=      | 大于等于                                                   |
| <=      | 小于等于                                                   |
| BETWEEN | 在某个范围内                                               |
| LIKE    | 搜索某种模式                                               |
| IN      | 指定针对某个列的多个可能值                                 |

```
SELECT * FROM Products
WHERE Price BETWEEN 50 AND 60;
```

```
SELECT * FROM Customers
WHERE City IN ('Paris','London');
```

```
SELECT * FROM Customers
WHERE City LIKE 's%';
```



## 🥘 SQL AND & OR 运算符

```
SELECT * FROM Websites
WHERE country='CN'
AND alexa > 50;


SELECT * FROM Websites
WHERE country='USA'
OR country='CN';

SELECT * FROM Websites
WHERE alexa > 15
AND (country='CN' OR country='USA');
```



## 🥘 SQL ORDER BY 语法

- **ASC**：表示按升序排序。
- **DESC**：表示按降序排序。

```
SELECT * FROM Websites
ORDER BY alexa;

SELECT * FROM Websites
ORDER BY alexa DESC;

SELECT * FROM Websites
ORDER BY country,alexa;
```



## 🥘 SQL INSERT INTO 语法

```
INSERT INTO Websites (name, url, alexa, country)
VALUES ('百度','https://www.baidu.com/','4','CN');

INSERT INTO Websites (name, url, country)
VALUES ('stackoverflow', 'http://stackoverflow.com/', 'IND');
```



## 🥘 SQL UPDATE 语法

```
UPDATE Websites 
SET alexa='5000', country='USA' 
WHERE name='菜鸟教程';
```



## 🥘 SQL DELETE 语法

```
DELETE FROM Websites
WHERE name='Facebook' AND country='USA';

DELETE FROM table_name;
```



