

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



### NOT IN

```
SELECT * FROM Customers
WHERE Country NOT IN ('Germany', 'France', 'UK');
```

### IN

```
SELECT * FROM Customers
WHERE Country IN (SELECT Country FROM Suppliers);
```

### BETWEEN

```
SELECT * FROM Products
WHERE Price BETWEEN 10 AND 20;
```

### NOT BETWEEN

```
SELECT * FROM Products
WHERE Price NOT BETWEEN 10 AND 20;
```

```
SELECT * FROM Products
WHERE Price BETWEEN 10 AND 20
AND CategoryID NOT IN (1,2,3);
```



## Alias

```
SELECT CustomerID AS ID, CustomerName AS Customer
FROM Customers;
```



### CONCAT_WS

```
SELECT CustomerName, CONCAT_WS(', ', Address, PostalCode, City, Country) AS Address
FROM Customers;
```

### 多 Database

老式的 SQL 语法，通常称为“隐式连接”

```
SELECT o.OrderID, o.OrderDate, c.CustomerName
FROM Customers AS c, Orders AS o
WHERE c.CustomerName='Around the Horn' AND c.CustomerID=o.CustomerID;
```

### INNER JOIN

```
SELECT Orders.OrderID, Customers.CustomerName, Orders.OrderDate
FROM Orders
INNER JOIN Customers
ON Orders.CustomerID=Customers.CustomerID;
```

```
SELECT Orders.OrderID, Customers.CustomerName, Orders.OrderDate, OrderDetails.ProductID, OrderDetails.Quantity
FROM Orders
INNER JOIN Customers ON Orders.CustomerID = Customers.CustomerID
INNER JOIN OrderDetails ON Orders.OrderID = OrderDetails.OrderID;
```



### INNER JOIN LV2

```
SELECT Orders.OrderID, Customers.CustomerName, Shippers.ShipperName
FROM ((Orders INNER JOIN Customers ON Orders.CustomerID = Customers.CustomerID)
INNER JOIN Shippers ON Orders.ShipperID = Shippers.ShipperID);
```

### LEFT JOIN

```
SELECT Customers.CustomerName, Orders.OrderID
FROM Customers
LEFT JOIN Orders
ON Customers.CustomerID=Orders.CustomerID
ORDER BY Customers.CustomerName;
```



### UNION

`UNION` 是 SQL 中的一个操作符，用于将两个或多个 `SELECT` 查询的结果合并成一个结果集。它会去除重复的行，返回唯一的结果。如果你希望包括所有的行（包括重复的行），可以使用 `UNION ALL`。



在你提供的 SQL 查询中：

```
SELECT City FROM Customers
UNION
SELECT City FROM Suppliers
ORDER BY City;
```

- 第一个 `SELECT` 查询从 `Customers` 表中选择 `City` 列。
- 第二个 `SELECT` 查询从 `Suppliers` 表中选择 `City` 列。
- `UNION` 将两个查询结果合并成一个结果集，并自动去除重复的城市。
- `ORDER BY City` 用于对结果按 `City` 列进行排序。

### 注意：

- `UNION` 需要确保两个查询返回的列数和数据类型是相同的。
- `UNION` 会去掉重复的记录，如果你希望保留重复的记录，可以使用 `UNION ALL`：

```
SELECT City FROM Customers
UNION ALL
SELECT City FROM Suppliers
ORDER BY City;
```

这个查询会包括重复的城市记录，而 `UNION` 则会自动去除重复值。



### GROUP BY

```
SELECT COUNT(CustomerID), Country
FROM Customers
GROUP BY Country;
```

```
SELECT COUNT(CustomerID), Country
FROM Customers
GROUP BY Country
ORDER BY COUNT(CustomerID) DESC;
```

### HAVING

```
SELECT COUNT(CustomerID), Country
FROM Customers
GROUP BY Country
HAVING COUNT(CustomerID) > 5;
```

```
SELECT COUNT(CustomerID), Country
FROM Customers
GROUP BY Country
HAVING COUNT(CustomerID) > 5
ORDER BY COUNT(CustomerID) DESC;
```

### EXISTS

```
SELECT SupplierName
FROM Suppliers
WHERE EXISTS (SELECT ProductName FROM Products WHERE Products.SupplierID = Suppliers.supplierID AND Price < 20);
```

### ANY()

```
SELECT ProductName 
FROM Products
WHERE ProductID = ANY (SELECT ProductID FROM OrderDetails WHERE Quantity = 10);
```

```
SELECT ProductName 
FROM Products 
WHERE ProductID > ANY (SELECT ProductID FROM OrderDetails WHERE Quantity = 10);
```



### 模拟数据：

**`Products` 表：**

| ProductID | ProductName |
| --------- | ----------- |
| 100       | Product A   |
| 101       | Product B   |
| 102       | Product C   |
| 103       | Product D   |
| 104       | Product E   |

**`OrderDetails` 表：**

| ProductID | Quantity |
| --------- | -------- |
| 101       | 10       |
| 102       | 10       |
| 103       | 10       |

------

### 查询 1：使用 `ANY`

```
SELECT ProductName
FROM Products
WHERE ProductID > ANY (SELECT ProductID FROM OrderDetails WHERE Quantity = 10);
```

**子查询**：`SELECT ProductID FROM OrderDetails WHERE Quantity = 10;`

- 返回：`[101, 102, 103]` 这三个 `ProductID`。

**外部查询**：`WHERE ProductID > ANY (...)`

- 外部查询将返回那些 `ProductID` 大于 `101`、`102` 或 `103` 中 **任意一个** 的 `ProductName`。

**执行结果**：

- `ProductID = 100` 小于所有子查询的 `ProductID`，不符合条件。
- `ProductID = 101` 等于子查询中的第一个 `ProductID`，不符合条件。
- `ProductID = 102` 等于子查询中的第二个 `ProductID`，不符合条件。
- `ProductID = 103` 等于子查询中的第三个 `ProductID`，不符合条件。
- `ProductID = 104` 大于 `101`、`102` 和 `103` 中的 **任意一个**，符合条件。

**最终结果**：

- `ProductName = "Product E"`（因为它的 `ProductID = 104`，大于 `101`、`102` 或 `103` 中的任何一个）。

------

### 查询 2：使用 `ALL`

```
SELECT ProductName
FROM Products
WHERE ProductID > ALL (SELECT ProductID FROM OrderDetails WHERE Quantity = 10);
```

**子查询**：`SELECT ProductID FROM OrderDetails WHERE Quantity = 10;`

- 返回：`[101, 102, 103]` 这三个 `ProductID`。

**外部查询**：`WHERE ProductID > ALL (...)`

- 外部查询将返回那些 `ProductID` 大于 **所有子查询返回的 `ProductID`** 的 `ProductName`。

**执行结果**：

- `ProductID = 100` 小于所有子查询的 `ProductID`，不符合条件。
- `ProductID = 101` 小于子查询中的 `102` 和 `103`，不符合条件。
- `ProductID = 102` 小于子查询中的 `103`，不符合条件。
- `ProductID = 103` 不大于子查询中的 `103`，不符合条件。
- `ProductID = 104` 大于 `101`、`102` 和 `103` 中 **所有的值**，符合条件。

**最终结果**：

- `ProductName = "Product E"`（因为它的 `ProductID = 104`，大于 `101`、`102` 和 `103` 中的所有值）。





### Comments

```
-- SELECT * FROM Customers;
```



### DROP

```
DROP DATABASE databasename;
```



### ALTER TABLE

**向 `Employees` 表中添加一个新的列 `Email`，其数据类型为 `VARCHAR(255)`**：

```
ALTER TABLE Employees
ADD Email VARCHAR(255);
```
