```
https://community.fabric.microsoft.com/t5/Themes-Gallery/bd-p/ThemesGallery
https://metricalist.com/powerbi-solutions/category/themes/
```

```
1. 主页 -> 输入数据 [创建 Measures]
2. （Database）Conditional Column（条件列） [进入 "主页"（Home） 选项卡, 点击 "转换数据"（Transform Data），这会打开 Power Query 编辑器。]
3. （Database）示例中的例 -> 从所选的内容 [修改一列的data所有格式， 例如 6 -> 6 year]
4. （Database）合并，创建放入其他table的id
5. （Database）拆分，替换
6. （Database）添加列 -> 索引 （添加自动 ID）
7. （Database） 主页 -> 将第一行。。。
```



### ====

### 语法

```postgresql
Total Emp = COUNTROWS('HR Analytics Data')

Male = CALCULATE([Total Emp],'HR Analytics Data'[Gender]="male")

Due for promotion = IF(
    ISBLANK(CALCULATE([Total Emp], 'HR Analytics Data'[Promotion Status] = "due for promotion")),
    0,
    CALCULATE([Total Emp], 'HR Analytics Data'[Promotion Status] = "due for promotion")
)
```

### %

```postgresql
% male = FORMAT(DIVIDE([Male], [Total Emp], 0) * 100, "0") & "%"

% due for promotion = FORMAT(DIVIDE([Due for promotion],[Total Emp],0)* 100, "0") & "%"

% on service = FORMAT(DIVIDE([On Service], [Total Emp], 0) * 100, "0.0") & "%"
```

### 其他

```postgresql
Dates = CALENDAR(DATE(YEAR(MIN(Sales[Date])),1,1),Date(YEAR(MAX(Sales[Date])),12,31))

Year = YEAR(Dates[Date])

MonthNumber = MONTH(Dates[Date])
```



```
SQL
转换->检测数据类型
主页->选择例->选择例

设计
主页->输入数据（All Measures）

语法
1. SUMX() // 计算结果相加
&=Total Revenue = sumx(FactTable,FactTable[OrderQuantity] * RELATED(DimProduct[Price]))

2. RELATED() // Power BI DAX 中的一个函数，用于 从 "一对多" 关系中的 "一端" 获取数据
&=Total Revenue = sumx(FactTable,FactTable[OrderQuantity] * RELATED(DimProduct[Price]))

3. DATEDIFF() // DATEDIFF(开始日期, 结束日期, 单位) DATEDIFF(DimCustomer[BirthDate], TODAY(), YEAR)
&=Customer Age = DATEDIFF(DimCustomer[BirthDate], TODAY(),YEAR)

4. SWITCH(TRUE(), ...)
当 TRUE() 作为 SWITCH 的第一个参数时，它会 检查后续条件，并返回 第一个匹配的值
&=
Age Category = 
    SWITCH(
        TRUE(),
        DimCustomer[Customer Age] < 11, "0-10",
        DimCustomer[Customer Age] < 21, "11-20",
        DimCustomer[Customer Age] < 31, "21-30",
        DimCustomer[Customer Age] < 41, "31-40",
        DimCustomer[Customer Age] < 51, "41-50",
        DimCustomer[Customer Age] < 61, "51-60",
        DimCustomer[Customer Age] < 71, "61-70",
        "Over 70"
    )
```

