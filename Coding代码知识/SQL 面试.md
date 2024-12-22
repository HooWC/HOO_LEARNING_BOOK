

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



## 进阶

### LIMIT

```
SELECT * FROM Customers LIMIT 10;
```

### IS NULL

```
SELECT CustomerName, ContactName, Address
FROM Customers
WHERE Address IS NULL;
```

### IS NOT NULL

```
SELECT CustomerName, ContactName, Address
FROM Customers
WHERE Address IS NOT NULL;
```

### ORDER BY

```
SELECT * FROM Customers
ORDER BY Country DESC;
```

### NOT

```
SELECT * FROM Customers
WHERE NOT Country='Germany';
```

### MIN()

```
SELECT MIN(Price) AS SmallestPrice
FROM Products; 
```

### MAX()

```
SELECT MAX(Price) AS LargestPrice
FROM Products; 
```

### COUNT()

```
SELECT COUNT(ProductID)
FROM Products;
```

### AVG()

```
SELECT AVG(Price)
FROM Products;
```

### SUM()

```
SELECT SUM(Quantity)
FROM OrderDetails;
```

### LIKE

```
SELECT * FROM Customers
WHERE CustomerName LIKE 'a%';
```

查询以 "a" 结尾的名字：

```
SELECT * FROM Customers
WHERE CustomerName LIKE '%a';
```

`%or%` 表示：在 `CustomerName` 中 **只要包含 "or"**，无论前后有什么字符，都会匹配。

```
SELECT * FROM Customers
WHERE CustomerName LIKE '%or%'
```

第二个字符是 "r" 的所有记录

```
SELECT * FROM Customers
WHERE CustomerName LIKE '_r%';
```

查询 `CustomerName` 中，**以 "a" 开头且至少有三个字符** 的记录。

```
SELECT * FROM Customers
WHERE CustomerName LIKE 'a__%';
```

查询 `ContactName` 中，**以 "a" 开头且以 "o" 结尾** 的所有记录。

```
SELECT * FROM Customers
WHERE ContactName LIKE 'a%o';
```



### NOT LIKE

```
SELECT * FROM Customers
WHERE CustomerName NOT LIKE 'a%';
```



### OFFSET 

**`OFFSET`** 用于跳过指定数量的记录，从而实现分页查询或控制结果集的起始点。

```
SELECT * 
FROM TableName 
LIMIT RowsToFetch OFFSET RowsToSkip;
```

#### **查询 1：获取前 3 条记录**

```
SELECT * FROM users LIMIT 3 OFFSET 0;
```

- 解释：
  - `LIMIT 3`：返回 3 条记录。
  - `OFFSET 0`：从第 0 条记录开始（即不跳过记录）。



#### **查询 2：跳过前 3 条，获取接下来的 3 条记录**

```
SELECT * FROM users LIMIT 3 OFFSET 3;
```

- 解释：
  - `LIMIT 3`：返回 3 条记录。
  - `OFFSET 3`：跳过前 3 条记录，从第 4 条开始。



