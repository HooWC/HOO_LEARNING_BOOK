# React Native Expo 基础

[官网]: https://expo.nodejs.cn/get-started/create-a-project/

React Native是一个用于构建跨平台移动应用的开源框架。它由Facebook开发并维护，允许开发人员使用JavaScript和React构建原生移动应用。与传统的移动开发方式相比，React Native具有许多优势，其中最主要的是可以同时在iOS和Android平台上进行开发，减少了开发人员需要编写的代码量，并且提供了更快的开发周期。React Native通过将JavaScript代码解释为原生组件，使得应用的性能接近于原生应用，同时还能够利用React的强大的组件化和声明式UI的特性。



## Android Studio 安装 （如有需要）（——基本不需要安装——）

[塔建安卓环境 软件安装视频教程]: https://www.bilibili.com/video/BV1Pt4y1n7bD?p=3



## Expo Go 安装  📱

```
手机安装 `Expo Go` 软件
```



## 🔔 安装

```
npx create-expo-app <project-name>
```

## 🔔 快速构建 `Navigation` 项目

```
npx create-expo-app --template

选择 Navigation (TypeScript)
```





## 🔔 启动 expo-cli

`expo-cli` 无需通过 USB 连接。这是 Expo 提供的一种方便快捷的开发方式，适用于跨平台移动应用程序的开发和测试。

[问题 Git 讨论]: https://github.com/expo/expo/issues/22747

#### 第一次启动项目，请输入以下

```
npx expo-cli upgrade
```
#### 启动

```
npx expo start
```





# 基础使用 🎥

组件文件 `Welcome.jsx` 和 `welcome.style.js`

`style` 文件

```react
import { StyleSheet } from "react-native";

import { COLORS, FONT, SIZES } from "../../../constants";

const styles = StyleSheet.create({
  container: {
    marginTop: SIZES.xLarge,
  },
  header: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    marginTop: SIZES.small,
  },
  headerTitle: {
    fontSize: SIZES.large,
    fontFamily: FONT.medium,
    color: COLORS.primary,
  },
  headerBtn: {
    fontSize: SIZES.medium,
    fontFamily: FONT.medium,
    color: COLORS.gray,
  },
  cardsContainer: {
    marginTop: SIZES.medium,
    gap: SIZES.small,
  },
});

export default styles;
```

`html` 文件

```html
style={styles.container}

style={[styles.container]}
```



### 🎐 函数使用

```react
import React from 'react';
import { View, Button, Alert } from 'react-native';

const MyButton = () => {
  const handlePress = () => {
    Alert.alert('Button Pressed');
  };

  return (
    <View>
      <Button title="Press Me" onPress={handlePress} />
    </View>
  );
};

export default MyButton;
```



### 🎐 React Native 标签

#### 🌍 View

```react
import { View } from "react-native";

export default function App() {
  return (
    <View style={styles.container}>
    
    </View>
  );
}
```



#### 🌍 Text

```react
import { Text } from "react-native";

export default function App() {
  return (
    <View style={styles.container}>
      <Text>Open up App.js to start working on your app!</Text>
    </View>
  );
}
```



#### 🌍 SafeAreaView

`SafeAreaView` 会根据设备的屏幕边缘自动调整子组件的布局，以确保内容不会被遮挡或延伸到屏幕的安全区域外。在 iPhone X 及以上设备上，`SafeAreaView` 会自动考虑到刘海区域、底部安全区域以及可能的 Home Indicator 区域，从而使内容在显示时不会受到这些区域的干扰。

```react
import { SafeAreaView, ScrollView, StyleSheet, Text, View, Platform, StatusBar } from 'react-native';

const Home = () => {
  return (
    <SafeAreaView style={styles.container}>
      <ScrollView showsVerticalScrollIndicator={false}>
        <View>
          <Text>Content goes here</Text>
        </View>
      </ScrollView>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingTop: Platform.OS === 'android' ? StatusBar.currentHeight : 0, // 适配 Android 状态栏
  },
});

export default Home;
```

Android可以使用 `getStatusBarHeight` 库



#### 🌍 ScrollView

```react
import { ScrollView } from 'react-native'

const Home = () => {

  return (
    <ScrollView showsVerticalScrollIndicator={false}>
        <View
          style={{
            flex: 1,
            padding: SIZES.medium,
          }}
        >
          <Welcome
            searchTerm={searchTerm}
            setSearchTerm={setSearchTerm}
            handleClick={() => {
              if (searchTerm) {
                router.push(`/search/${searchTerm}`)
              }
            }}
          />
        </View>
      </ScrollView>
  );
};

export default Home;
```

`showsVerticalScrollIndicator={false}` 是 ScrollView 组件的一个属性，用于控制是否显示垂直滚动条。

`contentContainerStyle={{padding:30}}` 是 ScrollView 和 FlatList 等滚动组件的一个属性，用于定义滚动内容的容器样式。这个样式会被应用到包含滚动内容的容器上，而不是滚动条本身。

`horizontal={true}` // 设置为水平滚动



#### 🌍 Dismensions

`Dimensions` 是 React Native 中的一个 API，用于获取设备的尺寸信息。它提供了一种简单的方法来获取设备的宽度和高度，以及其他相关的尺寸信息。

```react
import { Dimensions, ScrollView, StyleSheet, Text, View } from 'react-native'

const Home = () => {

  return (
    <ScrollView showsVerticalScrollIndicator={false}>
        <View style={[styles.container]}>
        	<View style={[styles.itemBase]}>
        	   <Text> 1 </Text>
        	</View>
        	 <View style={[styles.itemBase]}>
        	   <Text> 2 </Text>
        	</View>
        	<View style={[styles.itemBase]}>
        	   <Text> 3 </Text>
        	</View>
        	 <View style={[styles.itemBase]}>
        	   <Text> 4 </Text>
        	</View> 
        </View>
      </ScrollView>
  );
};

const styles = StyleSheet.create({
    container: {
      flexDirection: "row",
      flexWrap: 'wrap'
    },
    itemBase: {
        width: Dimensions.get('window').width/4,
        height: 90,
        borderWidth: 1,
        borderColor: 'yellow'
    }
})

export default Home;
```



#### 🌍 StatusBar

`StatusBar` 是 React Native 中用于控制设备状态栏的组件。它允许你控制状态栏的颜色、样式、是否显示等。你可以使用 `StatusBar` 来设置状态栏的背景色、文字颜色、是否隐藏状态栏等。

```react
<StatusBar hidden={true} backgroundColor="red" barStyle={"dark-content"} />
```

`StatusBar` 组件的 `barStyle` 属性用于指定状态栏的文字颜色主题，有两个可选值：

1. `"dark-content"`：将状态栏文字颜色设置为深色（通常为黑色），适用于浅色背景。
2. `"light-content"`：将状态栏文字颜色设置为浅色（通常为白色），适用于深色背景

```react
barStyle={"dark-content"}
```

```react
barStyle={"light-content"}
```



#### 🌍 Switch

`Switch` 是一个用于切换开关状态的组件。它提供了一个可视化的开关按钮，用户可以通过点击来切换开关的状态。你可以通过设置 `value` 属性来控制开关的状态，通过监听 `onValueChange` 事件来处理开关状态的改变。

```react
import React, { useState } from 'react';
import { View, Switch, Text, StyleSheet } from 'react-native';

const App = () => {
  const [isEnabled, setIsEnabled] = useState(false);

  const toggleSwitch = () => {
    setIsEnabled(previousState => !previousState);
  };

  return (
    <View style={styles.container}>
      <Text style={styles.label}>Toggle Switch:</Text>
      <Switch
        trackColor={{ false: "#767577", true: "#81b0ff" }}
        thumbColor={isEnabled ? "#f5dd4b" : "#f4f3f4"}
        ios_backgroundColor="#3e3e3e"
        onValueChange={toggleSwitch}
        value={isEnabled}
      />
      <Text style={styles.status}>{isEnabled ? "Switch is ON" : "Switch is OFF"}</Text>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
  },
  label: {
    fontSize: 20,
    marginBottom: 20,
  },
  status: {
    fontSize: 18,
    marginTop: 20,
  },
});

export default App;
```

1. **trackColor**:
   - `trackColor` 属性用于设置开关轨道（track）的颜色，即开关的背景色。
   - 这个属性接受一个对象作为值，对象有两个键值对：`false` 和 `true`，分别表示开关关闭和开关打开时的颜色。
   - 例如，`trackColor={{ false: "#767577", true: "#81b0ff" }}` 表示当开关关闭时，轨道的颜色为 `#767577`，当开关打开时，轨道的颜色为 `#81b0ff`。
2. **thumbColor**:
   - `thumbColor` 属性用于设置开关的 thumb（指示开关状态的小圆形按钮）的颜色。
   - 这个属性接受一个颜色字符串作为值，用于指定 thumb 的颜色。
   - 通常，根据开关的状态不同，thumb 的颜色也会不同。您可以根据需要使用条件表达式来设置不同状态下的颜色。
   - 例如，`thumbColor={isEnabled ? "#f5dd4b" : "#f4f3f4"}` 表示如果开关处于打开状态，则 thumb 的颜色为 `#f5dd4b`，否则为 `#f4f3f4`。



#### 🌍 ActivityIndicator  (loding)

`ActivityIndicator` 是一个用于显示加载指示器的组件，通常用于在数据加载或处理过程中显示一个加载动画。它提供了不同的样式和颜色选项，可以根据需要进行定制。当应用程序在后台进行网络请求或其他耗时操作时，你可以使用 `ActivityIndicator` 来告诉用户正在进行加载操作。

```react
import React, { useState, useEffect } from 'react';
import { View, ActivityIndicator, StyleSheet } from 'react-native';

const App = () => {
  const [isLoading, setIsLoading] = useState(true);

  // 模拟加载数据或执行长时间任务
  useEffect(() => {
    const fetchData = async () => {
      // 模拟加载数据或执行长时间任务
      await new Promise(resolve => setTimeout(resolve, 3000));
      setIsLoading(false);
    };
    fetchData();
  }, []);

  return (
    <View style={styles.container}>
      {isLoading ? (
        <ActivityIndicator size="large" color="#0000ff" />
      ) : (
        <View>
          {/* 显示加载完成后的内容 */}
          <Text>Data loaded successfully!</Text>
        </View>
      )}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
});

export default App;
```

1. **small**：指示器的尺寸为小号。
2. **large**：指示器的尺寸为大号。

```
size={50} // 数字
```





#### 🌍 Animated

`Animated` 是 React Native 中用于创建动画效果的 API。它提供了一组可以用来创建、组合和定时动画的方法，包括平移、旋转、缩放、透明度等。使用 `Animated`，你可以轻松地为你的应用程序添加各种动画效果，提升用户体验。

[官网]: https://reactnative.cn/docs/animated

```react
import React, {useRef} from 'react';
import {
  Animated,
  Text,
  View,
  StyleSheet,
  Button,
  SafeAreaView,
} from 'react-native';

const App = () => {
  // fadeAnim 将用作不透明度的值。初始值：0
  const fadeAnim = useRef(new Animated.Value(0)).current;

  const fadeIn = () => {
    // 将在 5 秒内将 fadeAnim 值更改为 1
    Animated.timing(fadeAnim, {
      toValue: 1,
      duration: 5000,
      useNativeDriver: true,
    }).start();
  };

  const fadeOut = () => {
    // 将在 3 秒内将 fadeAnim 值更改为 0
    Animated.timing(fadeAnim, {
      toValue: 0,
      duration: 3000,
      useNativeDriver: true,
    }).start();
  };

  return (
    <SafeAreaView style={styles.container}>
      <Animated.View
        style={[
          styles.fadingContainer,
          {
            // 将不透明度绑定到动画值
            opacity: fadeAnim,
          },
        ]}>
        <Text style={styles.fadingText}>Fading View!</Text>
      </Animated.View>
      <View style={styles.buttonRow}>
        <Button title="Fade In View" onPress={fadeIn} />
        <Button title="Fade Out View" onPress={fadeOut} />
      </View>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
  },
  fadingContainer: {
    padding: 20,
    backgroundColor: 'powderblue',
  },
  fadingText: {
    fontSize: 28,
  },
  buttonRow: {
    flexBasis: 100,
    justifyContent: 'space-evenly',
    marginVertical: 16,
  },
});

export default App;
```

```react
Animated.timing(fadeAnim, {
      toValue: 1,
      duration: 5000,
      useNativeDriver: true,
    }).start(() => {
    	alert("我出来了")
	});
```





#### 🌍 TextInput

`TextInput` 是一个用于接受用户输入的文本输入框组件。它允许用户输入文本、数字、密码等，并提供了一些属性和事件用于控制输入内容的样式、行为和处理。

[官网]: https://reactnative.cn/docs/textinput

```react
import React, { useState } from 'react';
import { View, TextInput, Text, StyleSheet } from 'react-native';

const App = () => {
  const [text, setText] = useState('');

  const onChangeText = (inputText) => {
    setText(inputText);
  };

  return (
    <View style={styles.container}>
      <Text>Enter your name:</Text>
      <TextInput
        style={styles.input}
        onChangeText={onChangeText}
        value={text}
        secureTextEntry={true} // 设置为密码输入框
        keyboardType="email-address" // 设置键盘类型为 email-address
        placeholder="Type here..."
        multiline={true} // 支持多行输入
        numberOfLines={4} // 初始行数为 4 行
        textAlignVertical="top" // 设置文本从顶部开始对齐
      />
      <Text>Your name is: {text}</Text>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  input: {
    width: '80%',
    height: 40,
    borderWidth: 1,
    borderColor: 'gray',
    borderRadius: 5,
    paddingHorizontal: 10,
    marginTop: 10,
  },
});

export default App;
```

`keyboardType` 是 TextInput 组件的一个属性，用于指定在用户输入文本时要显示的键盘类型。

以下是一些常用的 `keyboardType` 值：

- `default`：默认的键盘类型，适用于通用文本输入。
- `numeric`：显示数字键盘，允许输入数字。
- `email-address`：显示带有 `@` 符号的键盘，适用于输入电子邮件地址。
- `phone-pad`：显示电话号码键盘，适用于输入电话号码。
- `number-pad`：显示数字键盘，允许输入数字，不显示小数点。
- `decimal-pad`：显示数字键盘，允许输入数字和小数点。

```
multiline 和 numberOfLines 和 textAlignVertical 一起使用
```

`textAlignVertical` 是 TextInput 组件的一个属性，用于指定垂直方向上文本的对齐方式。

在 React Native 中，`textAlignVertical` 属性仅适用于 Android 平台，用于控制文本在垂直方向上的对齐方式。它可以接受以下几个预定义的值：

- `auto`：默认值。根据文本内容自动调整垂直对齐方式。
- `top`：文本从顶部开始对齐。
- `bottom`：文本从底部开始对齐。
- `center`：文本在垂直方向上居中对齐。







#### 🌍 KeyboardAvoidingView

`KeyboardAvoidingView` 是一个用于在键盘弹出时自动调整界面布局的组件。它可以确保输入框不被键盘遮挡，从而提高用户体验。通常与 `TextInput` 一起使用，以确保输入框在键盘弹出时能够自动调整位置。

#### 

#### 🌍 Image

`Image` 是一个用于显示图片的组件。它可以显示本地图片、远程图片、网络图片等，并提供了一些属性和事件用于控制图片的加载、缩放、裁剪等。

```react
import React from 'react';
import { View, Image, StyleSheet, Dimensions } from 'react-native';

const { width } = Dimensions.get('window'); // 获取屏幕宽度

const App = () => {
  return (
    <View style={styles.container}>
      {/* 显示本地图片 */}
      <Image
        source={require('./path/to/local/image.png')}
        style={styles.image}
      />

      {/* 显示网络图片 */}
      <Image
        source={{ uri: 'https://example.com/path/to/image.jpg' }}
        style={styles.image}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  image: {
    width: width, // 设置图片宽度为屏幕宽度
    height: 200, // 固定高度
    resizeMode: 'cover', // 控制图片的缩放方式
    marginBottom: 20,
  },
});

export default App;
```





#### 🌍 ImageBackground

`ImageBackground` 是一个用于显示带有背景图片的组件。它允许你在背景上叠加其他组件，从而实现复杂的布局和样式。





#### 🌍 TouchableNativeFeedback

`TouchableNativeFeedback` 是一个用于实现原生触摸反馈效果的组件。它提供了一种类似于 Android 原生按钮点击效果的触摸反馈，可以使用户感觉到按钮被点击的反馈效果。

#### 🌍 TouchableOpacity

`TouchableOpacity` 是一个用于实现按钮点击效果的组件。它提供了一种在用户点击时降低按钮的不透明度的效果，从而使用户感觉到按钮被点击的反馈效果。

`触摸时透明度变化`

```react
import React from 'react';
import { View, Text, TouchableOpacity, StyleSheet } from 'react-native';

const App = () => {
  const onPressButton = () => {
    console.log('Button pressed!');
  };

  return (
    <View style={styles.container}>
      <TouchableOpacity
        style={styles.button}
        onPress={onPressButton}
      >
        <Text style={styles.text}>Press Me</Text>
      </TouchableOpacity>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  button: {
    backgroundColor: 'blue',
    paddingHorizontal: 20,
    paddingVertical: 10,
    borderRadius: 5,
  },
  text: {
    color: 'white',
    fontSize: 16,
  },
});

export default App;
```



#### 🌍 TouchableHighlight

`TouchableHighlight` 是一个用于实现触摸高亮效果的组件。它会在用户触摸时高亮显示，提供了一种类似于点击按钮的反馈效果。通常用于实现按钮或其他可点击元素。

[官网]: https://reactnative.cn/docs/touchablehighlight

`触摸时高亮显示`

```react
import React from 'react';
import { View, Text, TouchableHighlight, StyleSheet } from 'react-native';

const App = () => {
  const onPressButton = () => {
    console.log('Button pressed!');
  };

  return (
    <View style={styles.container}>
      <TouchableHighlight
        style={styles.button}
        onPress={onPressButton}
        underlayColor="lightblue" // 触摸时显示的颜色
      >
        <Text style={styles.text}>Press Me</Text>
      </TouchableHighlight>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  button: {
    backgroundColor: 'blue',
    paddingHorizontal: 20,
    paddingVertical: 10,
    borderRadius: 5,
  },
  text: {
    color: 'white',
    fontSize: 16,
  },
});

export default App;
```





#### 🌍 TouchableWithoutFeedback

`TouchableWithoutFeedback` 是一个用于实现无反馈触摸效果的组件。它不会提供任何反馈效果，仅仅是在用户触摸时触发相应的事件。通常用于实现自定义的交互效果。

`TouchableWithoutFeedback` 不会提供任何点击反馈

```react
import React from 'react';
import { View, Text, TouchableWithoutFeedback, StyleSheet } from 'react-native';

const App = () => {
  const onPressButton = () => {
    console.log('Button pressed!');
  };

  return (
    <View style={styles.container}>
      <TouchableWithoutFeedback onPress={onPressButton}>
        <View style={styles.button}>
          <Text style={styles.text}>Press Me</Text>
        </View>
      </TouchableWithoutFeedback>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  button: {
    backgroundColor: 'blue',
    paddingHorizontal: 20,
    paddingVertical: 10,
    borderRadius: 5,
  },
  text: {
    color: 'white',
    fontSize: 16,
  },
});

export default App;
```





#### 🌍 Button

`Button` 是一个用于创建原生按钮的组件。它提供了一个简单的按钮界面，用于触发相应的操作或事件。`Button` 组件通常是跨平台的，在不同的平台上都有相似的外观和行为。

[官网]: https://reactnative.cn/docs/button

`onPress`

```react
<Button title="Press Me" onPress={handlePress} />
```



#### 🌍 Alert

`Alert` 是 React Native 中用于显示警告框的 API。它可以用来在应用程序中显示警告、确认或提示信息，通常用于提示用户某些重要的信息或操作。

```react
import { View, Button, Alert } from 'react-native';

Alert.alert('Button Pressed');
```

```react
import React from 'react';
import { View, Button, Alert } from 'react-native';

const MyAlert = () => {
  const showAlert = () => {
    Alert.alert(
      '标题',
      '确定要执行这个操作吗？',
      [
        {
          text: '取消',
          onPress: () => console.log('取消按钮被点击'),
          style: 'cancel',
        },
        {
          text: '确定',
          onPress: () => console.log('确定按钮被点击'),
        },
      ],
      { cancelable: false }
    );
  };

  return (
    <View>
      <Button title="显示提示框" onPress={showAlert} />
    </View>
  );
};

export default MyAlert;
```

`cancelable: false` 是一个配置选项，用于设置 Alert 组件是否允许通过点击屏幕空白区域或返回键来关闭提示框。

当 `cancelable` 设置为 `true` 时，用户可以通过点击屏幕空白区域或按下返回键来关闭提示框。这是默认行为，适用于大多数情况下用户可以通过手动关闭提示框的场景。

但是，当 `cancelable` 设置为 `false` 时，意味着用户无法通过点击屏幕空白区域或按下返回键来关闭提示框。这通常用于一些重要的提示或确认框，确保用户不能轻易地关闭提示框而必须做出明确的选择。



- ```
  style
  ```

  ：按钮的样式，用于定义按钮的外观。可选值包括：

  - `default`：默认样式，通常用于普通按钮。
  - `cancel`：取消样式，通常用于取消操作的按钮。
  - `destructive`：破坏性样式，通常用于执行危险或不可恢复操作的按钮。



例子

```react
import React from 'react';
import { View, Button, Alert } from 'react-native';

const MyAlert = () => {
  const showAlert = () => {
    Alert.alert(
      '标题',
      '确定要执行这个操作吗？',
      [
        {
          text: '稍后再试',
          onPress: () => console.log('稍后提醒我'),
        },
        {
          text: '取消',
          onPress: () => console.log('取消按钮被点击'),
          style: 'cancel',
        },
        {
          text: '确定',
          onPress: () => console.log('确定按钮被点击'),
        },
      ],
      { cancelable: false }
    );
  };

  return (
    <View>
      <Button title="显示提示框" onPress={showAlert} />
    </View>
  );
};

export default MyAlert;
```



#### 🌍 Platform

`Platform` 是 React Native 提供的一个 API，用于获取当前运行平台的信息。通过 `Platform`，你可以判断当前应用程序运行在哪个平台（例如 iOS、Android 或 Web），以便根据不同的平台进行相应的处理或适配。

```
paddingTop: platform === "ios" ? (variables.isIphoneX ? 39 : 15) : 0
height: platform === "ios" ? (isIphoneX ? 88 : 64) : 56
```



#### 🌍 FlatList

`FlatList` 是一个用于显示列表数据的高性能列表组件。它可以滚动显示大量数据，并提供了一些优化手段来提高列表的性能和流畅度，例如数据的懒加载、滚动优化等。

[官网]: https://reactnative.cn/docs/flatlist

```react
import React from 'react';
import { View, Text, FlatList, StyleSheet } from 'react-native';

const App = () => {
  // 示例数据
  const DATA = [
    { id: '1', title: 'Item 1' },
    { id: '2', title: 'Item 2' },
    { id: '3', title: 'Item 3' },
    { id: '4', title: 'Item 4' },
    { id: '5', title: 'Item 5' },
    { id: '6', title: 'Item 6' },
    { id: '7', title: 'Item 7' },
    { id: '8', title: 'Item 8' },
    { id: '9', title: 'Item 9' },
    { id: '10', title: 'Item 10' },
  ];

  // 渲染每个列表项
  const renderItem = ({ item }) => (
    <View style={styles.item}>
      <Text>{item.title}</Text>
    </View>
  );

  return (
    <View style={styles.container}>
      <FlatList
        data={DATA} // 设置列表数据
        renderItem={renderItem} // 渲染每个列表项
        keyExtractor={item => item.id} // 提取每个项的唯一键
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingTop: 22,
  },
  item: {
    padding: 10,
    borderBottomWidth: 1,
    borderBottomColor: '#cccccc',
  },
});

export default App;
```



#### 🌍 SectionList

`SectionList` 是一个带有分组标题的列表组件。它类似于 `FlatList`，但可以将列表数据分组显示，并在每个分组之间显示分组标题。

[官网]: https://reactnative.cn/docs/sectionlist

```react
import React, { useState } from 'react';
import { View, Text, SectionList, StyleSheet, refreshControl } from 'react-native';

const App = () => {
  // 示例数据
  const DATA = [
    {
      title: 'Group 1',
      data: ['Item 1', 'Item 2', 'Item 3'],
    },
    {
      title: 'Group 2',
      data: ['Item 4', 'Item 5'],
    },
    {
      title: 'Group 3',
      data: [],
    },
  ];
    
  const [refreshing, setRefreshing] = useState(false);

  const onRefresh = () => {
    setRefreshing(true);

    // 模拟刷新操作，实际应用中通常会发起网络请求或执行其他异步操作
    setTimeout(() => {
      setRefreshing(false);
    }, 2000);
  };

  // 渲染每个分组的标题
  const renderSectionHeader = ({ section }) => (
    <View style={styles.sectionHeader}>
      <Text style={styles.sectionHeaderText}>{section.title}</Text>
    </View>
  );

  // 渲染每个分组中的每个项目
  const renderItem = ({ item }) => (
    <View style={styles.item}>
      <Text>{item}</Text>
    </View>
  );

  // 列表为空时显示的组件
  const renderEmptyComponent = () => (
    <View style={styles.emptyContainer}>
      <Text>No data available</Text>
    </View>
  );

  return (
    <View style={styles.container}>
      <SectionList
        sections={DATA} // 设置分组数据
        keyExtractor={(item, index) => item + index} // 设置每个项的唯一键
        renderItem={renderItem} // 渲染每个项
        renderSectionHeader={renderSectionHeader} // 渲染每个分组的标题
        ItemSeparatorComponent={() => <View style={styles.separator} />} // 设置分隔符组件
        ListEmptyComponent={renderEmptyComponent} // 设置空列表时显示的组件
        refreshing={refreshing} // 设置下拉刷新的状态
        onRefresh={onRefresh} // 设置下拉刷新的回调函数
          
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} />} // 刷新控件
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingTop: 22,
  },
  sectionHeader: {
    backgroundColor: '#f0f0f0',
    padding: 10,
  },
  sectionHeaderText: {
    fontSize: 16,
    fontWeight: 'bold',
  },
  item: {
    padding: 10,
    borderBottomWidth: 1,
    borderBottomColor: '#cccccc',
  },
  separator: {
    height: 1,
    backgroundColor: '#cccccc',
  },
  emptyContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
});

export default App;
```



#### 🌍 Modal

`Modal` 是一个用于显示模态框的组件。它可以在当前界面上显示一个覆盖层，并在其上显示一个自定义的内容。通常用于实现对话框、提示框或其他需要用户交互的临时界面。















## 插件

```
npm i expo-font axios react-native-dotenv
```





































