# Python

### 基础

```python
print("Hi")
# 你好
my_name = "Hoo"
print(my_name)
age = 24
print(f"Age is {age}")
```

```python
name = input("请输入名字")
print(f"你的名字是 {name}")

name = int(input("请输入数字"))

============

def get_integer_input(prompt):
    while True:
        user_input = input(prompt)
        try:
            value = int(user_input)
            return value
        except ValueError:
            print("输入无效，请输入一个数字。")

# 使用示例
name = get_integer_input("请输入数字: ")
print(f"你输入的数字是: {name}")
```



### List 功能

```python
lst = [1, 2, 3]
second_item = lst.pop(1)
# 输出: 2

=========

lst = [1, 2, 3]
lst.clear()
# 输出: []

=========

# lst.index(2) 返回 2 在列表中的第一次出现位置
# lst.index(2, 2) 从索引 2 开始查找 2 的位置。
lst = [1, 2, 3, 2]
index_of_two = lst.index(2)
# 输出: 1
index_of_two_in_range = lst.index(2, 2)
# 输出: 3

=========

// count(item): 返回 item 在列表中出现的次数。
lst = [1, 2, 2, 3]
count_of_two = lst.count(2)

=========

lst = [3, 1, 2]
lst.sort()
# 输出: [1, 2, 3]

lst.sort(reverse=True)
# 输出: [3, 2, 1]

=========

lst = [1, 2, 3]
lst.reverse()
# 输出: [3, 2, 1]

=========

lst = [1, 2, 3]
copied_lst = lst.copy()
```

### Class

```python
class Person:
    def __init__(self, name, age):
        # 初始化实例的属性
        self.name = name
        self.age = age

    def greet(self):
        # 实例方法，输出一个问候语
        return f"Hello, my name is {self.name} and I am {self.age} years old."

    def have_birthday(self):
        # 实例方法，增加年龄
        self.age += 1
        return f"Happy Birthday, {self.name}! You are now {self.age} years old."

# 创建一个 Person 类的实例
person1 = Person("Alice", 30)

# 使用实例的方法
print(person1.greet())        # 输出: Hello, my name is Alice and I am 30 years old.
print(person1.have_birthday()) # 输出: Happy Birthday, Alice! You are now 31 years old.

# 访问实例的属性
print(person1.name)  # 输出: Alice
print(person1.age)   # 输出: 31
```

### 使用 `mysql-connector-python`

```
pip install mysql-connector-python
```

### **连接 MySQL 的代码示例**:

```python
import mysql.connector
from mysql.connector import Error

def create_connection():
    try:
        connection = mysql.connector.connect(
            host='localhost',
            user='your_username',
            password='your_password',
            database='your_database'
        )

        if connection.is_connected():
            print("Connected to MySQL database")
            return connection

    except Error as e:
        print(f"Error: {e}")
        return None

def close_connection(connection):
    if connection.is_connected():
        connection.close()
        print("Connection closed")

# 使用示例
conn = create_connection()
# 执行数据库操作
close_connection(conn)
```

### CRUD 操作示例代码

```python
import mysql.connector
from mysql.connector import Error

def create_connection():
    try:
        connection = mysql.connector.connect(
            host='localhost',
            user='your_username',
            password='your_password',
            database='test_db'
        )
        if connection.is_connected():
            print("Connected to MySQL database")
            return connection
    except Error as e:
        print(f"Error: {e}")
        return None

def close_connection(connection):
    if connection.is_connected():
        connection.close()
        print("Connection closed")

def create_employee(connection, name, position, salary):
    try:
        cursor = connection.cursor()
        query = "INSERT INTO employees (name, position, salary) VALUES (%s, %s, %s)"
        values = (name, position, salary)
        cursor.execute(query, values)
        connection.commit()
        print("Employee created successfully")
    except Error as e:
        print(f"Error: {e}")

def read_employees(connection):
    try:
        cursor = connection.cursor()
        query = "SELECT * FROM employees"
        cursor.execute(query)
        result = cursor.fetchall()
        for row in result:
            print(row)
    except Error as e:
        print(f"Error: {e}")

def update_employee(connection, emp_id, name, position, salary):
    try:
        cursor = connection.cursor()
        query = "UPDATE employees SET name = %s, position = %s, salary = %s WHERE id = %s"
        values = (name, position, salary, emp_id)
        cursor.execute(query, values)
        connection.commit()
        print("Employee updated successfully")
    except Error as e:
        print(f"Error: {e}")

def delete_employee(connection, emp_id):
    try:
        cursor = connection.cursor()
        query = "DELETE FROM employees WHERE id = %s"
        cursor.execute(query, (emp_id,))
        connection.commit()
        print("Employee deleted successfully")
    except Error as e:
        print(f"Error: {e}")

# 使用示例
conn = create_connection()
if conn:
    # Create a new employee
    create_employee(conn, "John Doe", "Software Engineer", 70000)

    # Read all employees
    print("Employees:")
    read_employees(conn)

    # Update an employee
    update_employee(conn, 1, "John Doe", "Senior Software Engineer", 80000)

    # Delete an employee
    delete_employee(conn, 1)

    # Close connection
    close_connection(conn)
```

### Lambda

```
fn1 = lambda a, b: a + b
print(fn1(2, 3))
```

### Matplotlib

```
pip install matplotlib
```













