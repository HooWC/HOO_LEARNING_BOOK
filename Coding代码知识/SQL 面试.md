

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

### Top

如何用 SQL 查询表中的前 10 条记录

```sql
SELECT TOP 10 * FROM Users;
```

```sql
SELECT u.UserName, o.OrderId, o.OrderDate
FROM Users u
INNER JOIN Orders o ON u.UserId = o.UserId
WHERE u.UserName = 'John';
```



### 示例数据：

假设我们有一个 `Orders` 表，包含以下数据：

| OrderId | UserId | OrderDate  |
| ------- | ------ | ---------- |
| 1       | 1      | 2023-01-05 |
| 2       | 1      | 2023-01-10 |
| 3       | 1      | 2023-01-15 |
| 4       | 2      | 2023-01-02 |
| 5       | 2      | 2023-02-01 |
| 6       | 2      | 2023-03-10 |
| 7       | 2      | 2023-04-15 |
| 8       | 2      | 2023-05-20 |
| 9       | 3      | 2023-01-01 |
| 10      | 3      | 2023-02-25 |
| 11      | 3      | 2023-03-11 |
| 12      | 3      | 2023-03-20 |
| 13      | 3      | 2023-04-05 |
| 14      | 3      | 2023-05-30 |

------

### 查询目标：

你想查询那些 **订单数量大于 5** 且 **订单日期在 2023-01-01 之后** 的用户。通过 SQL 查询：

```sql
SELECT UserId, COUNT(*) AS OrderCount
FROM Orders
WHERE OrderDate > '2023-01-01'
GROUP BY UserId
HAVING COUNT(*) > 5;
```

------

### 执行查询后的结果：

| UserId | OrderCount |
| ------ | ---------- |
| 2      | 5          |
| 3      | 6          |





### 01

### 1. **Users 表**（用户信息）

| UserId | UserName | Email             |
| ------ | -------- | ----------------- |
| 1      | John     | john@example.com  |
| 2      | Jane     | jane@example.com  |
| 3      | Alice    | alice@example.com |

### 2. **Orders 表**（订单信息）

| OrderId | UserId | OrderDate  |
| ------- | ------ | ---------- |
| 1       | 1      | 2023-01-01 |
| 2       | 1      | 2023-01-05 |
| 3       | 2      | 2023-01-10 |
| 4       | 3      | 2023-01-12 |
| 5       | 3      | 2023-02-01 |

### 3. **Products 表**（产品信息）

| ProductId | ProductName | Price |
| --------- | ----------- | ----- |
| 1         | Laptop      | 1000  |
| 2         | Phone       | 600   |
| 3         | Mouse       | 50    |

### **OrderDetails 表**（订单与产品关联，假设每个订单可能有多个产品）

| OrderDetailId | OrderId | ProductId | Quantity |
| ------------- | ------- | --------- | -------- |
| 1             | 1       | 1         | 1        |
| 2             | 1       | 2         | 2        |
| 3             | 2       | 3         | 1        |
| 4             | 3       | 1         | 1        |
| 5             | 5       | 2         | 1        |

------

### **JOIN 查询**：假设你想查询每个用户的订单信息、所购买的产品以及产品价格。

#### SQL 查询：

```sql
SELECT u.UserName, o.OrderDate, p.ProductName, od.Quantity, p.Price, (od.Quantity * p.Price) AS TotalPrice
FROM Users u
INNER JOIN Orders o ON u.UserId = o.UserId
INNER JOIN OrderDetails od ON o.OrderId = od.OrderId
INNER JOIN Products p ON od.ProductId = p.ProductId
ORDER BY o.OrderDate;
```

#### 结果：

| UserName | OrderDate  | ProductName | Quantity | Price | TotalPrice |
| -------- | ---------- | ----------- | -------- | ----- | ---------- |
| John     | 2023-01-01 | Laptop      | 1        | 1000  | 1000       |
| John     | 2023-01-01 | Phone       | 2        | 600   | 1200       |
| John     | 2023-01-05 | Mouse       | 1        | 50    | 50         |
| Jane     | 2023-01-10 | Mouse       | 1        | 50    | 50         |
| Alice    | 2023-01-12 | Laptop      | 1        | 1000  | 1000       |
| Alice    | 2023-02-01 | Phone       | 1        | 600   | 600        |

### **解释**：

- **Users 表**：存储用户信息，`UserId` 用作唯一标识。
- **Orders 表**：存储用户订单信息，`OrderId` 用作唯一标识。
- **Products 表**：存储产品信息，`ProductId` 用作唯一标识。
- **OrderDetails 表**：关联订单和产品，记录每个订单中每个产品的数量。

通过 `INNER JOIN` 将这三个表连接起来：

- `Users` 和 `Orders` 通过 `UserId` 连接。
- `Orders` 和 `OrderDetails` 通过 `OrderId` 连接。
- `OrderDetails` 和 `Products` 通过 `ProductId` 连接。

最终，你得到了每个用户的订单详情，包括产品名称、数量、价格和总价。



### 02

```sql
SELECT * FROM movies WHERE title LIKE "Toy Story%";
```

### 03

```sql
SELECT c.CustomerName, e.LastName AS E_Lastname, e.FirstName AS E_FirstName, p.ProductName, (od.Quantity * p.Price) AS Total, o.OrderDate
FROM Orders o
INNER JOIN Customers c ON o.CustomerID = c.CustomerID
INNER JOIN Employees e ON o.EmployeeID = e.EmployeeID
INNER JOIN OrderDetails od ON o.OrderID = od.OrderID
INNER JOIN Products p ON od.ProductID = p.ProductID
ORDER BY o.OrderDate
```

```sql
SELECT c.CustomerName, e.LastName AS E_Lastname, e.FirstName AS E_Firstname, p.ProductName, (od.Quantity * p.Price) AS Total, o.OrderDate
FROM (
((Orders o INNER JOIN Customers c ON o.CustomerID = c.CustomerID) INNER JOIN Employees e ON o.EmployeeID = e.EmployeeID)
INNER JOIN OrderDetails od ON o.OrderID = od.OrderID)
INNER JOIN Products
ORDER BY o.OrderDate;
```

### 04

AliceMusic

```sql
SELECT u.UserName, CASE WHEN u.Gender = 0 THEN 'Male' WHEN u.Gender = 1 THEN 'Female' ELSE 'UnKnow' END AS Gender,s.SingerName AS Collect
FROM SingerStores ss
INNER JOIN Users u ON ss.UserID = u.UserID
INNER JOIN Singers s ON ss.SingerID = s.SingerID;
```

### 05

```sql
CREATE DATABASE HRDB;
GO

USE HRDB;
GO

CREATE TABLE Employees
(
	Id INT IDENTITY PRIMARY KEY,
	Name VARCHAR(255)
);
GO

INSERT INTO Employees (Name)
VALUES ('Hoo');
GO

SELECT * FROM Employees
```

```
NVARCHAR
```

### 06 HRDB

#### 1. `Employees` 表

存储员工基本信息，每个员工有一个唯一的 ID。

```sql
CREATE TABLE Employees
(
    Id INT IDENTITY PRIMARY KEY,
    Name VARCHAR(255)
);
```

#### 2. `Departments` 表

存储部门信息，每个部门有一个唯一的 ID。

```sql
CREATE TABLE Departments
(
    Id INT IDENTITY PRIMARY KEY,
    DepartmentName VARCHAR(255)
);
```

#### 3. `EmployeeDepartments` 表

建立员工和部门之间的关系。一个员工可以属于多个部门，一个部门也可以有多个员工，因此这是一个多对多关系。

```sql
CREATE TABLE EmployeeDepartments
(
    EmployeeId INT,
    DepartmentId INT,
    PRIMARY KEY (EmployeeId, DepartmentId),
    FOREIGN KEY (EmployeeId) REFERENCES Employees(Id),
    FOREIGN KEY (DepartmentId) REFERENCES Departments(Id)
);
```

#### 全部

```sql
CREATE TABLE Employees
(
    Id INT IDENTITY PRIMARY KEY,
    Name VARCHAR(255)
);

CREATE TABLE Departments
(
    Id INT IDENTITY PRIMARY KEY,
    DepartmentName VARCHAR(255)
);

CREATE TABLE EmployeeDepartments
(
    EmployeeId INT,
    DepartmentId INT,
    PRIMARY KEY (EmployeeId, DepartmentId),
    FOREIGN KEY (EmployeeId) REFERENCES Employees(Id),
    FOREIGN KEY (DepartmentId) REFERENCES Departments(Id)
);
GO

SELECT * FROM EmployeeDepartments;

INSERT INTO Departments (DepartmentName)
VALUES ('HR'), ('IT'), ('Finance');

INSERT INTO Employees (Name)
VALUES ('Alice'), ('Bob'), ('Charlie');

INSERT INTO EmployeeDepartments (EmployeeId, DepartmentId)
VALUES (1, 1), (1, 2), (2, 2), (3, 3);

SELECT * FROM Employees;
SELECT * FROM Departments;
SELECT * FROM EmployeeDepartments

SELECT e.Name AS Employee_Name, d.DepartmentName AS Department
FROM EmployeeDepartments ed
JOIN Employees e ON ed.EmployeeId = e.Id
JOIN Departments d ON ed.DepartmentId = d.Id
```



### 07 HRDB 02

```sql
UNIQUE NOT NULL
```

```sql
CREATE DATABASE HRDB02
GO

CREATE TABLE Customer
(
    CustomerId INT IDENTITY PRIMARY KEY,  -- 主键
    CustomerName VARCHAR(255) NOT NULL,    -- 客户名
    Email VARCHAR(255) UNIQUE NOT NULL     -- 客户的电子邮件，要求唯一
);

CREATE TABLE Orders
(
    OrderId INT IDENTITY PRIMARY KEY,         -- 订单 ID
    OrderDate DATETIME NOT NULL,              -- 订单日期
    Amount DECIMAL(10, 2),                    -- 订单金额
    CustomerId INT,                           -- 外键，指向 Customer 表的 CustomerId
    FOREIGN KEY (CustomerId) REFERENCES Customer(CustomerId)  -- 外键约束
);

-- 向 Customer 表插入客户数据
INSERT INTO Customer (CustomerName, Email)
VALUES ('Alice', 'alice@example.com'),
       ('Bob', 'bob@example.com');

-- 向 Orders 表插入订单数据，注意 CustomerId 必须对应 Customer 表中存在的 CustomerId
INSERT INTO Orders (OrderDate, Amount, CustomerId)
VALUES ('2025-01-01', 100.50, 1),  -- Alice 的订单
       ('2025-01-02', 200.75, 2);  -- Bob 的订单


SELECT * FROM Orders;
```