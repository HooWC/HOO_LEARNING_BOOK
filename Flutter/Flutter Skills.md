两种写法不一样

```
StatelessWidget
StatefulWidget // 动态
```



## initState

`initState()` 是 `StatefulWidget` 中 `State` 类的一部分，它是在 `State` 对象插入到树中时调用的生命周期方法。这个方法通常用于初始化一些数据或执行只需要执行一次的操作。它在 `build()` 方法之前执行，并且只会执行一次（在 `State` 对象生命周期的开始阶段）。

### 主要用途：

1. **初始化数据**：你可以在 `initState()` 中做一些数据的初始化工作，比如从网络加载数据，设置动画，初始化控制器等。
2. **添加监听器**：如果你需要监听一些对象的变化（如 `AnimationController` 或其他事件），你可以在 `initState()` 中注册监听器。

#### 代码示例：

```dart
class MyHomePage extends StatefulWidget {
  @override
  _MyHomePageState createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  String _data = "Initial data";

  @override
  void initState() {
    super.initState();
    // 在这里初始化数据
    _data = "Updated data"; // 或者从网络获取数据
    print("initState called");
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("initState Example")),
      body: Center(child: Text(_data)),
    );
  }
}
```



## 获取手机大小

```
var screenHeight = MediaQuery.of(context).size.height;
var screenWidth = MediaQuery.of(context).size.width;
```



### **`Scaffold` 是什么？**

`Scaffold` 是 Flutter 中提供的一个页面结构框架，专门用于构建常见的 Material Design 风格的页面。
它帮你管理应用的基本布局，比如标题栏、底部导航栏、悬浮按钮等。

#### 常见的属性：

- **`appBar`**: 页面顶部的标题栏。
- **`body`**: 页面主内容，放置主要的 UI 部分。
- **`floatingActionButton`**: 悬浮按钮，一般用于常用的快速操作。
- **`drawer`**: 抽屉菜单，用于侧边栏导航。
- **`bottomNavigationBar`**: 底部导航栏。

#### 示例：

```dart
Scaffold(
  appBar: AppBar(title: Text('Scaffold 示例')),
  body: Center(child: Text('这是主内容')),
  floatingActionButton: FloatingActionButton(
    onPressed: () {},
    child: Icon(Icons.add),
  ),
)
```



### 获取 json 数据

```dart
Future<List<Widget>> createList() async {
  List<Widget> items = <Widget>[];
  String dataString = await DefaultAssetBundle.of(context).loadString("assets/data.json");
  List<dynamic> dataJSON = jsonDecode(dataString);

  // 将数据保存在 items 里，最后返回
  dataJSON.forEach((object) {
    String finalString = "";
    List<dynamic> dataList = object["placeItems"];
    dataList.forEach((item) {
      finalString = finalString + item + " | ";
    });

    items.add(
      Padding(
        padding: EdgeInsets.all(2.0),
        child: Container(
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.all(Radius.circular(10.0)),
            boxShadow: [
              BoxShadow(
                color: Colors.black12,
                spreadRadius: 2.0,
                blurRadius: 5.0,
              ),
            ],
          ),
          margin: EdgeInsets.all(5.0),
          child: Row(
            mainAxisSize: MainAxisSize.max,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              ClipRRect(
                borderRadius: BorderRadius.only(
                  topLeft: Radius.circular(10.0),
                  bottomLeft: Radius.circular(10.0),
                ),
                child: Image.asset(
                  object["placeImage"],
                  width: 80,
                  height: 80,
                  fit: BoxFit.cover,
                ),
              ),
              SizedBox(
                width: 250,
                child: Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(object["placeName"]),
                      Padding(
                        padding: const EdgeInsets.only(top: 2.0, bottom: 2.0),
                        child: Text(
                          finalString,
                          overflow: TextOverflow.ellipsis,
                          style: TextStyle(
                            fontSize: 12.0,
                            color: Colors.black54,
                          ),
                          maxLines: 1,
                        ),
                      ),
                      Text(
                        "Min. Order: \${object["minOrder"]}",
                        style: TextStyle(
                          fontSize: 12.0,
                          color: Colors.black54,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  });

  return items;
}
```



### showDialog

`showDialog` 是 Flutter 中用于显示对话框（Dialog）的函数。对话框通常用于展示一些临时的信息、警告、提示，或者提供用户交互的选项，比如确认、选择、输入等。



## Body

### 1. **`Center`**

让子组件居中显示。适合简单居中的内容，比如文本、按钮等。

```dart
body: Center(
  child: Text('Hello, Flutter!'),
),
```

------

### 2. **`Column`**

垂直排列子组件，常用于多个元素的垂直布局。

```dart
body: Column(
  mainAxisAlignment: MainAxisAlignment.center, // 垂直方向居中
  crossAxisAlignment: CrossAxisAlignment.center, // 水平方向居中
  children: [
    Text('这是第一个文本'),
    SizedBox(height: 20), // 添加空隙
    Text('这是第二个文本'),
  ],
),
```

------

### 3. **`Row`**

水平排列子组件，适合构建横向布局。

```dart
body: Row(
  mainAxisAlignment: MainAxisAlignment.spaceAround, // 子组件在水平方向均匀分布
  children: [
    Icon(Icons.home, size: 40),
    Icon(Icons.search, size: 40),
    Icon(Icons.settings, size: 40),
  ],
),
```

------

### 4. **`Stack`**

实现层叠布局，可以把多个组件叠加在一起。

```dart
body: Stack(
  children: [
    Container(
      color: Colors.blue,
      width: double.infinity,
      height: double.infinity,
    ),
    Positioned(
      top: 100,
      left: 100,
      child: Text('叠加在蓝色背景上'),
    ),
  ],
),
```

------

### 5. **`ListView`**

适合展示列表数据，并且支持滚动。

```dart
body: ListView(
  padding: EdgeInsets.all(20),
  children: [
    ListTile(
      leading: Icon(Icons.person),
      title: Text('User 1'),
    ),
    ListTile(
      leading: Icon(Icons.person),
      title: Text('User 2'),
    ),
    ListTile(
      leading: Icon(Icons.person),
      title: Text('User 3'),
    ),
  ],
),
```

------

### 6. **`GridView`**

用于网格布局，适合展示图片集等。

```dart
body: GridView.count(
  crossAxisCount: 2, // 每行2列
  children: [
    Container(color: Colors.red, child: Center(child: Text('1'))),
    Container(color: Colors.green, child: Center(child: Text('2'))),
    Container(color: Colors.blue, child: Center(child: Text('3'))),
    Container(color: Colors.yellow, child: Center(child: Text('4'))),
  ],
),
```

------

### 7. **`CustomScrollView` 和 `Slivers`**

创建复杂的滚动效果，比如应用栏随滚动隐藏或扩展。

```dart
body: CustomScrollView(
  slivers: [
    SliverAppBar(
      floating: true,
      expandedHeight: 200,
      flexibleSpace: FlexibleSpaceBar(
        title: Text('滚动标题'),
      ),
    ),
    SliverList(
      delegate: SliverChildBuilderDelegate(
        (context, index) => ListTile(title: Text('Item #$index')),
        childCount: 20,
      ),
    ),
  ],
),
```

------

### 8. **`SafeArea`**

确保内容不被状态栏、导航栏等系统 UI 遮挡。

```dart
body: SafeArea(
  child: Text('这是一段安全区域内的文字'),
),
```

------

### 9. **`SingleChildScrollView`**

当内容可能溢出屏幕时，用它包裹内容实现滚动。

```dart
body: SingleChildScrollView(
  child: Column(
    children: List.generate(
      20,
      (index) => Text('Item $index', style: TextStyle(fontSize: 20)),
    ),
  ),
),
```

------

### 10. **直接使用 Widget**

你也可以直接在 `body` 里放置任意 Widget，而不是 `Container`。

```dart
body: Text(
  '直接显示文字内容',
  style: TextStyle(fontSize: 24),
),
```


### 11. **`Container` **

`Container` 是一个多功能的布局控件，用于创建一个矩形区域，可以设置：

- **布局（`alignment`）**：设置子组件的对齐方式。
- **尺寸（`width`, `height`）**：指定宽高。
- **装饰（`decoration`）**：添加背景颜色、边框、阴影、圆角等。
- **内外边距（`padding`, `margin`）**：设置内容与边界的距离。

#### 示例：

```dart
Container(
  width: 200,
  height: 100,
  alignment: Alignment.center,
  padding: EdgeInsets.all(10),
  margin: EdgeInsets.all(20),
  decoration: BoxDecoration(
    color: Colors.blue,
    borderRadius: BorderRadius.circular(10),
    boxShadow: [BoxShadow(blurRadius: 5, color: Colors.grey)],
  ),
  child: Text('这是 Container'),
)
```

------

### 总结

- **`body`** 可以放任何符合需求的 Widget，而不局限于 `Container`。
- 选择合适的 Widget 取决于布局需求：
  - 居中内容用 `Center`
  - 垂直/水平布局用 `Column` 或 `Row`
  - 滚动内容用 `ListView` 或 `SingleChildScrollView`
  - 更复杂的布局用 `Stack` 或 `CustomScrollView`





### 图片

```dart
ClipRRect(
  borderRadius: BorderRadius.only(
    topLeft: Radius.circular(10.0),
    bottomLeft: Radius.circular(10.0),
  ),
  child: Image.asset(
    object["placeImage"],
    width: 80,
    height: 80,
    fit: BoxFit.cover,
  ),
),
```





### **`EdgeInsets.all` 是什么？**

`EdgeInsets.all` 是 Flutter 中用来定义 **统一内边距或外边距** 的工具。

- 它是 `EdgeInsets` 类的一个构造函数，允许为所有方向（上、下、左、右）设置相同的值。
- 常用来控制 `padding` 或 `margin`。

#### 示例

```
// 设置一个统一的内边距为 10
padding: EdgeInsets.all(10),
```

等效于：

```
padding: EdgeInsets.only(top: 10, bottom: 10, left: 10, right: 10),
```

#### 其他 `EdgeInsets` 构造方法：

- `EdgeInsets.only`

  : 为指定方向单独设置边距。

  ```
  padding: EdgeInsets.only(top: 10, left: 20),
  ```

- `EdgeInsets.symmetric` : 为水平（horizontal）和垂直（vertical）方向分别设置边距。

  ```
  padding: EdgeInsets.symmetric(horizontal: 20, vertical: 10),
  ```



### **`BoxDecoration` 是什么？**

`BoxDecoration` 是 Flutter 中用来定义 **容器的外观样式** 的类。你可以通过它自定义 `Container` 等部件的颜色、形状、阴影等。

------

#### 常见属性

1. **`color`**: 设置背景颜色。

   ```
   decoration: BoxDecoration(
     color: Colors.blue,
   ),
   ```

2. **`border`**: 设置边框样式。

   ```
   decoration: BoxDecoration(
     border: Border.all(
       color: Colors.black,
       width: 2,
     ),
   ),
   ```

3. **`borderRadius`**: 设置圆角。

   ```
   decoration: BoxDecoration(
     borderRadius: BorderRadius.circular(10), // 四角圆角
   ),
   ```

4. **`boxShadow`**: 设置阴影效果。

   ```
   decoration: BoxDecoration(
     boxShadow: [
       BoxShadow(
         color: Colors.black26,
         blurRadius: 5,
         offset: Offset(2, 2),
       ),
     ],
   ),
   ```

5. **`gradient`**: 设置渐变效果。

   ```
   decoration: BoxDecoration(
     gradient: LinearGradient(
       colors: [Colors.blue, Colors.green],
       begin: Alignment.topLeft,
       end: Alignment.bottomRight,
     ),
   ),
   ```

6. **`shape`**: 定义容器形状（默认为矩形）。

   - 矩形（默认）：使用 `borderRadius` 设置圆角。
   - 圆形：使用 `BoxShape.circle`。

   ```
   decoration: BoxDecoration(
     shape: BoxShape.circle, // 设置为圆形
     color: Colors.red,
   ),
   ```

------

#### 示例：综合使用

```dart
Container(
  width: 100,
  height: 100,
  decoration: BoxDecoration(
    color: Colors.blue,
    borderRadius: BorderRadius.circular(10),
    border: Border.all(color: Colors.white, width: 2),
    boxShadow: [
      BoxShadow(
        color: Colors.black26,
        blurRadius: 5,
        offset: Offset(2, 2),
      ),
    ],
  ),
),
```

这个容器将：

- 背景为蓝色；
- 四个角的圆角半径为 10；
- 外边框为白色，宽度为 2；
- 添加阴影效果。



### `Text`

```dart
Text("Min. Order: ${object["minOrder"]}",style: TextStyle(fontSize: 12.0,color: Colors.black54),)
```



### `SizeBox`

`SizedBox` 是 Flutter 中非常常用的布局组件，它主要用于控制元素的大小、间距或作为一个占位符。下面是 `SizedBox` 的常见用法和属性：

#### 1. **设置尺寸**

`SizedBox` 最常见的用法是指定一个固定的宽度和高度。可以通过 `width` 和 `height` 属性来设置：

```dart
SizedBox(width: 100, height: 50)
```

这个 `SizedBox` 会创建一个宽 100、高 50 的空白区域。

#### 2. **水平和垂直间距**

`SizedBox` 也常常用于布局中作为间距。它可以通过只设置一个属性来指定宽度或高度，从而创建水平或垂直间距。

- **水平间距（宽度）**：

  ```dart
  SizedBox(width: 20)  // 创建宽度为 20 的水平间距
  ```

- **垂直间距（高度）**：

  ```dart
  SizedBox(height: 20)  // 创建高度为 20 的垂直间距
  ```

#### 3. **作为占位符**

`SizedBox` 也可以作为占位符使用，比如在某些布局中我们需要一个固定尺寸但不显示内容的控件。可以通过 `width` 和 `height` 来控制占位符的大小。

```dart
SizedBox(width: 50, height: 50, child: Container(color: Colors.red))
```

这个 `SizedBox` 会显示一个红色的矩形，大小为 50x50。

#### 4. **约束内容**

`SizedBox` 可以包裹任何控件，给它们施加尺寸约束。比如，你可以将 `SizedBox` 包裹一个子控件，强制其大小。

```dart
SizedBox(
  width: 100,
  height: 100,
  child: Image.asset('path_to_image.jpg'),
)
```

这会将图片限制在宽度 100、高度 100 的大小内。

#### 5. **`child` 属性**

`SizedBox` 允许包含一个子控件。使用 `child` 属性可以将任何 Widget 放入其中。它的大小由 `SizedBox` 的 `width` 和 `height` 控制。

```dart
SizedBox(
  width: 200,
  height: 50,
  child: ElevatedButton(
    onPressed: () {},
    child: Text('Click me'),
  ),
)
```



### Padding 问题

**为什么 `padding: const EdgeInsets.all(8.0)` 要用 `const`？**

在 Flutter 中，`const` 关键字用于创建常量值，它会在编译时就确定值，而不是在运行时计算。这里使用 `const` 的目的是为了提升性能，因为常量可以被 Flutter 的编译器优化，避免了重复创建相同的对象。

你**可以**去掉 `const`，但是如果你去掉 `const`，Flutter 会在运行时重新创建一个新的 `EdgeInsets` 对象，而这可能会稍微影响性能，尤其是如果你在多个地方使用了相同的 padding。

**总结**：使用 `const` 可以提升性能，并且使得代码更加简洁和可维护。如果 `EdgeInsets.all(8.0)` 是一个固定值，建议使用 `const`。

```dart
Padding(
  padding: const EdgeInsets.all(8.0),
  child: Column(
    crossAxisAlignment: CrossAxisAlignment.start,
    children: [
      Text(object["placeName"]),
      
      Padding(
        padding: const EdgeInsets.only(top: 2.0, bottom: 2.0),
        child: Text(
          finalString,
          overflow: TextOverflow.ellipsis,
          style: TextStyle(
            fontSize: 12.0,
            color: Colors.black54,
          ),
          maxLines: 1,
        ),
      ),

      Text(
        "Min. Order: ${object["minOrder"]}",
        style: TextStyle(
          fontSize: 12.0,
          color: Colors.black54,
        ),
      ),
    ],
  ),
)
```





### **`SafeArea`**

`SafeArea` 是一个 Flutter 控件，用于确保其子控件不会被设备的显示区域（如状态栏、虚拟按键等）遮挡。它会自动为子控件添加足够的内边距，使它们避免被设备屏幕的安全区域（例如刘海屏、圆角屏等）遮挡。

#### 示例用法：

```dart
SafeArea(
  child: Column(
    children: [
      Text('This text will not be obstructed by the status bar or home indicator.'),
    ],
  ),
)
```

`SafeArea` 的作用是自动计算并加上合适的 padding，确保子控件不会被显示设备的一些区域（如顶部状态栏、底部虚拟按键等）覆盖。常用于处理屏幕底部或顶部的内容，以确保显示效果良好。

### 2. **`SingleChildScrollView`**

`SingleChildScrollView` 是一个滚动视图组件，允许你在屏幕上显示内容，并且当内容超过屏幕的大小时，用户可以通过滚动来查看全部内容。它通常用于当内容量未知或可能超过屏幕空间时，确保用户可以滚动浏览内容。

#### 示例用法：

```dart
SingleChildScrollView(
  child: Column(
    children: List.generate(100, (index) {
      return ListTile(
        title: Text('Item $index'),
      );
    }),
  ),
)
```

`SingleChildScrollView` 包裹一个单一的子控件，并允许这个子控件超出视图大小时可以滚动。它通常与 `Column`、`Row` 等控件一起使用，来处理动态内容和较长的列表。

#### 关键属性：

- **`scrollDirection`**: 设置滚动方向，默认为垂直滚动。可以设置为 `Axis.horizontal` 来启用水平滚动。
- **`padding`**: 允许为滚动区域添加额外的内边距。
- **`controller`**: 用于控制滚动位置，通常与 `ScrollController` 一起使用。

#### 总结

- **`SafeArea`** 用来防止内容被设备的边界（如状态栏、虚拟按键等）遮挡。
- **`SingleChildScrollView`** 用来在内容超出屏幕尺寸时提供滚动功能，确保用户能够查看全部内容。



### 头

```dart
Padding(
  padding: const EdgeInsets.fromLTRB(10, 5, 10, 5),
  child: Row(
    mainAxisAlignment: MainAxisAlignment.spaceBetween,
    children: [
      IconButton(
        icon: Icon(Icons.menu),
        onPressed: () {},
      ),
      Text(
        "Foodies",
        style: TextStyle(
          fontSize: 50,
          fontFamily: "Samantha",
        ),
      ),
      IconButton(
        icon: Icon(Icons.person),
        onPressed: () {},
      ),
    ],
  ),
)
```



### Print Async API Data

```dart
Container(
  child: FutureBuilder(
    initialData: <Widget>[Text("")],
    future: createList(),
    builder: (context, result) {
      if (result.hasData) {
        return Padding(
          padding: EdgeInsets.all(8.0),
          child: ListView(
            primary: false,
            shrinkWrap: true,
            children: result.data!,
          ),
        );
      } else {
        return CircularProgressIndicator();
      }
    },
  ),
)
```



### 头 View Page

```dart
import 'package:flutter/material.dart';
import 'some_data_source.dart';  // 引入数据源文件

class BannerWidgetArea extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    var screenWidth = MediaQuery.of(context).size.width;

    PageController controller = PageController(viewportFraction: 0.8, initialPage: 1);

    List<Widget> banners = <Widget>[];

    for (int x = 0; x < bannerItems.length; x++) {
      var bannerView = Padding(
        padding: EdgeInsets.all(10.0),
        child: Container(
          child: Stack(
            fit: StackFit.expand,
            children: [
              // border
              Container(
                decoration: BoxDecoration(
                  borderRadius: BorderRadius.all(Radius.circular(20.0)),
                  boxShadow: [
                    BoxShadow(
                      color: Colors.black38,
                      offset: Offset(2.0, 2.0),
                      blurRadius: 5.0,
                      spreadRadius: 1.0,
                    ),
                  ],
                ),
              ),

              // 图片
              ClipRRect(
                borderRadius: BorderRadius.all(Radius.circular(20.0)),
                child: Image.asset(
                  bannerImage[x],
                  fit: BoxFit.cover,
                ),
              ),

              // 阴影
              Container(
                decoration: BoxDecoration(
                  borderRadius: BorderRadius.all(Radius.circular(20.0)),
                  gradient: LinearGradient(
                    begin: Alignment.topCenter,
                    end: Alignment.bottomCenter,
                    colors: [Colors.transparent, Colors.black],
                  ),
                ),
              ),

              // Banner 内容
              Padding(
                padding: EdgeInsets.all(10.0),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.end,
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      bannerItems[x],
                      style: TextStyle(fontSize: 25.0, color: Colors.white),
                    ),
                    Text(
                      "More than 40% Off",
                      style: TextStyle(fontSize: 12.0, color: Colors.white),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      );

      // 保存每一个 item
      banners.add(bannerView);
    }

    return Container(
      width: screenWidth,
      child: PageView(
        controller: controller,
        scrollDirection: Axis.horizontal, // 滑动方向
        children: banners,
      ),
    );
  }
}
```



### 自定义 数据

```dart
import 'dart:convert';
import 'package:flutter/material.dart';

var bannerItems = [
  "Burger",
  "Cheese Chilly",
  "Noodles",
  "Pizza"
];

var bannerImage = [
  "images/burger.jpg",
  "images/cheesechilly.jpg",
  "images/noodles.jpg",
  "images/pizza.jpg"
];

Future<List<dynamic>> fetchData(BuildContext context) async {
  // 读取 JSON 文件
  String dataString = await DefaultAssetBundle.of(context).loadString("assets/data.json");
  
  // 解码 JSON 数据
  List<dynamic> dataJSON = jsonDecode(dataString);
  
  return dataJSON;
}
```





## API

`lib/models/Item.dart` 例子

```dart
class Item {
  final String id;
  final String name;
  final String description;

  Item({required this.id, required this.name, required this.description});

  // 从 JSON 转换为 Item 对象
  factory Item.fromJson(Map<String, dynamic> json) {
    return Item(
      id: json['_id'] ?? '',
      name: json['name'] ?? '',
      description: json['description'] ?? '',
    );
  }

  // 将 Item 对象转换为 JSON
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'description': description,
    };
  }
}
```



`lib/services/  crud api 文件` 例子

```dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/item.dart';

class ApiService {
  static const String baseUrl = 'http://192.168.1.105:5000/items';

  static Future<List<Item>> fetchItems() async {
    final response = await http.get(Uri.parse(baseUrl));
    if (response.statusCode == 200) {
      final List<dynamic> json = jsonDecode(response.body);
      return json.map((e) => Item.fromJson(e)).toList();
    } else {
      throw Exception('Failed to fetch items');
    }
  }

  static Future<void> createItem(String name, String description) async {
    final response = await http.post(
      Uri.parse(baseUrl),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({'name': name, 'description': description}),
    );
    if (response.statusCode != 201) {
      throw Exception('Failed to create item');
    }
  }

  static Future<void> deleteItem(String id) async {
    final response = await http.delete(Uri.parse('$baseUrl/$id'));
    if (response.statusCode != 200) {
      throw Exception('Failed to delete item');
    }
  }

  static Future<void> updateItem(String id, String name, String description) async {
    final response = await http.put(
      Uri.parse('$baseUrl/$id'),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({'name': name, 'description': description}),
    );
    if (response.statusCode != 200) {
      throw Exception('Failed to update item');
    }
  }
}
```



### Contain

```dart
List<Item> items = [];

  @override
  void initState() {
    super.initState();
    fetchItems();
  }

  // 获取数据
  Future<void> fetchItems() async {
    try {
      final fetchedItems = await ApiService.fetchItems();
      setState(() {
        items = fetchedItems;
      });
    } catch (e) {
      print('Error fetching items: $e');
    }
  }

  // 创建新数据
  Future<void> createItem(String name, String description) async {
    try {
      await ApiService.createItem(name, description);
      fetchItems();
    } catch (e) {
      print('Error creating item: $e');
    }
  }

// 删除数据
  Future<void> deleteItem(String id) async {
    try {
      await ApiService.deleteItem(id);
      fetchItems();
    } catch (e) {
      print('Error deleting item: $e');
    }
  }

  // 打开编辑页面
  void editItem(Item item) async {
    final updatedItem = await Navigator.push(
      context,
      MaterialPageRoute(builder: (context) => EditPage(item: item)),
    );
    if (updatedItem != null) {
      fetchItems();
    }
  }
```

