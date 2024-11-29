## Flutter Tags

### 1. **基本组件 (Basic Widgets)**

- `Container`
- `Row`
- `Column`
- `Stack`
- `Text`
- `Image`
- `Icon`
- `Placeholder`
- `Scaffold`
- `AppBar`
- `Center`

------

### **2. 布局组件 (Layout Widgets)**

- `Padding`
- `Align`
- `Expanded`
- `Flexible`
- `Spacer`
- `Wrap`
- `ListView`
- `GridView`
- `CustomScrollView`
- `SingleChildScrollView`
- `ConstrainedBox`
- `SizedBox`
- `FittedBox`
- `AspectRatio`
- `FractionallySizedBox`

------

### **3. 输入和按钮 (Input and Buttons)**

- `TextField`
- `Form`
- `Checkbox`
- `Radio`
- `Switch`
- `Slider`
- `DropdownButton`
- `ElevatedButton`
- `TextButton`
- `OutlinedButton`
- `IconButton`
- `FloatingActionButton`

------

### **4. 导航和路由 (Navigation and Routing)**

- `Navigator`
- `MaterialPageRoute`
- `CupertinoPageRoute`
- `Drawer`
- `BottomNavigationBar`
- `TabBar`
- `TabBarView`
- `PageView`
- `Stepper`

------

### **5. 动画和交互 (Animation and Interaction)**

- `AnimatedContainer`
- `AnimatedOpacity`
- `Hero`
- `Transform`
- `FadeTransition`
- `ScaleTransition`
- `SlideTransition`
- `AnimationController`
- `GestureDetector`
- `Draggable`
- `DragTarget`

------

### **6. 高级功能组件 (Advanced Widgets)**

- `CustomPaint`
- `CustomScrollView`
- `SliverAppBar`
- `SliverList`
- `SliverGrid`
- `ReorderableListView`
- `DataTable`
- `PaginatedDataTable`

------

### **7. 数据和状态管理 (State Management)**

- `StatefulWidget`
- `InheritedWidget`
- `Provider`
- `ChangeNotifier`
- `Riverpod`
- `Bloc`
- `GetX`
- `ValueNotifier`
- `StreamBuilder`
- `FutureBuilder`

------

### **8. 绘制和图形 (Painting and Effects)**

- `Canvas`
- `CustomPainter`
- `ClipOval`
- `ClipRRect`
- `BackdropFilter`
- `ShaderMask`

------

### **9. 多媒体 (Multimedia)**

- `Image.asset`
- `Image.network`
- `VideoPlayer`
- `AudioPlayer`
- `Camera`

------

### **10. 平台特定功能 (Platform-Specific Features)**

- `PlatformView`
- `AndroidView`
- `UiKitView`
- `MethodChannel`
- `EventChannel`
- `PlatformChannel`

------

### **11. 辅助功能 (Accessibility)**

- `Semantics`
- `ExcludeSemantics`
- `MergeSemantics`

------

### **12. 网络和 HTTP**

- `http` (包)
- `dio` (包)
- `Future`
- `Stream`

------

### **13. 本地存储**

- `SharedPreferences`
- `sqflite`
- `Hive`

------

### **14. 错误和调试 (Debugging and Error Handling)**

- `DebugPrint`
- `ErrorWidget`
- `assert`

------

### **15. 国际化 (Internationalization)**

- `Localizations`
- `Intl` (包)
- `MaterialLocalizations`
- `CupertinoLocalizations`

------

### **16. 图标和字体**

- `Icon`
- `IconButton`
- `CustomFont`
- `GoogleFonts` (包)

------

### **17. 工具类 (Utilities)**

- `Future`
- `Stream`
- `Timer`
- `DateTime`
- `Duration`





## Button

在 Flutter 中，`TextButton` 和 `ElevatedButton` 是两种不同类型的按钮组件，它们的主要区别在于外观和用途。以下是它们的详细比较：

------

### **1. TextButton**

- **简介**：
  - `TextButton` 是一种扁平按钮（Flat Button），看起来像一个带文字的链接。
  - 没有明显的边框或背景，适用于不需要突出的按钮。
- **特点**：
  - 默认样式没有背景，只有文本。
  - 当用户按下时，会显示一个墨水波纹效果（ripple）。
  - 常用于次要操作，例如“取消”或“跳过”。
- **代码示例**：

```
TextButton(
  onPressed: () {
    print('TextButton clicked');
  },
  child: Text('Text Button'),
),
```

- **自定义样式**： 可以通过 `style` 属性设置颜色、大小等：

```
TextButton(
  onPressed: () {},
  style: TextButton.styleFrom(
    primary: Colors.blue, // 文字颜色
    padding: EdgeInsets.symmetric(horizontal: 16.0, vertical: 8.0),
  ),
  child: Text('Styled Text Button'),
),
```

------

### **2. ElevatedButton**

- **简介**：
  - `ElevatedButton` 是一种凸起按钮（Raised Button），具有明显的背景色和阴影。
  - 常用于需要用户注意的主要操作，比如“提交”或“下一步”。
- **特点**：
  - 默认样式有背景色（取决于主题），并且有轻微的阴影。
  - 鼠标悬停或按下时会有不同的视觉效果。
  - 更适合强调主要功能。
- **代码示例**：

```
ElevatedButton(
  onPressed: () {
    print('ElevatedButton clicked');
  },
  child: Text('Elevated Button'),
),
```

- **自定义样式**： 可以通过 `style` 属性自定义背景色、文字颜色等：

```
ElevatedButton(
  onPressed: () {},
  style: ElevatedButton.styleFrom(
    primary: Colors.green, // 背景颜色
    onPrimary: Colors.white, // 文字颜色
    padding: EdgeInsets.symmetric(horizontal: 16.0, vertical: 8.0),
  ),
  child: Text('Styled Elevated Button'),
),
```

------

### **3. 样式对比**

| **属性**       | **TextButton**         | **ElevatedButton**                 |
| -------------- | ---------------------- | ---------------------------------- |
| **背景**       | 无背景（透明）         | 有背景色（取决于主题或自定义）     |
| **边框和阴影** | 无边框和阴影           | 默认有轻微阴影                     |
| **用途**       | 用于次要或低优先级操作 | 用于主要或高优先级操作             |
| **视觉效果**   | 点击时仅有波纹效果     | 点击时背景色变化，并有更明显的效果 |

------

### **4. 选择哪种按钮？**

- **使用 `TextButton`**：
  - 用于不需要吸引注意的次要动作，例如“取消”或超链接。
  - 适合扁平的、轻量的设计。
- **使用 `ElevatedButton`**：
  - 用于需要突出的主要操作，例如“提交”或“确认”。
  - 适合需要强调用户交互的场景。



## **1. 什么是 `Future<void>`？**

- **`Future<void>`** 是表示 **异步操作** 的返回类型















