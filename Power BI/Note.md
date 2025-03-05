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

