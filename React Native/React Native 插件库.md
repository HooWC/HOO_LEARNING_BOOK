# React Native 插件库



## ⚡ WebView

- **功能**: WebView 是一个嵌入式浏览器组件，允许你在应用程序中显示 web 内容，例如网页或 HTML 内容。
- **用途**: 可以用来加载和显示网页内容、渲染 HTML 内容、与 web 页面进行交互等。

安装

```
npm install react-native-webview
```

```react
import React from 'react';
import {
  Animated,
  Text,
  View,
  StyleSheet,
  Button,
  SafeAreaView,
} from 'react-native';
import { WebView } from 'react-native-webview';

const App = () => {
  return (
  	<WebView source={{ uri: 'https://m.baidu.com' }} style={{ marginTop: 20 }} />
  )
};

export default App;
```



## ⚡ Picker

- **功能**: Picker 是一个下拉选择器组件，允许用户从预定义的选项列表中选择一个值。
- **用途**: 通常用于实现用户界面中的下拉菜单、日期选择器、时间选择器等。

[官网]: https://github.com/react-native-picker/picker
[官网]: https://www.npmjs.com/package/react-native-picker-select

安装

```
npm install @react-native-picker/picker --save
```

```react
import React, { useState } from 'react';
import { View, Text, StyleSheet } from 'react-native';
import { Picker as PickerCode } from '@react-native-picker/picker';

const App = () => {
  const [selectedValue, setSelectedValue] = useState("java");

  return (
    <View style={styles.container}>
      <PickerCode
        selectedValue={selectedValue}
        onValueChange={(itemValue, itemIndex) => setSelectedValue(itemValue)}
        style={styles.picker}
      >
        <PickerCode.Item label="Java" value="java" />
        <PickerCode.Item label="JavaScript" value="js" />
        <PickerCode.Item label="Python" value="python" />
        <PickerCode.Item label="Ruby" value="ruby" />
        <PickerCode.Item label="C++" value="cpp" />
      </PickerCode>
      <Text style={styles.text}>Selected language: {selectedValue}</Text>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
  },
  picker: {
    width: 200,
    height: 50,
  },
  text: {
    fontSize: 20,
    marginTop: 20,
  },
});

export default App;
```



## ⚡ Swiper

- **功能**: Swiper 是一个轮播组件，允许你在应用程序中创建轮播图或图片滑动效果。
- **用途**: 用于创建漂亮的图片轮播效果，通常用于应用程序中的广告轮播、产品展示等。

[官网]: https://github.com/leecade/react-native-swiper

安装

```
npm i react-native-swiper --save

npm i --save react-native-swiper@next
```

```react
import React, { Component } from 'react'
import { StyleSheet, Text, View } from 'react-native'
import Swiper from 'react-native-swiper'

export default class SwiperComponent extends Component {
  render() {
    return (
      <Swiper style={styles.wrapper} showsButtons={true}>
        <View style={styles.slide1}>
          <Text style={styles.text}>Hello Swiper</Text>
        </View>
        <View style={styles.slide2}>
          <Text style={styles.text}>Beautiful</Text>
        </View>
        <View style={styles.slide3}>
          <Text style={styles.text}>And simple</Text>
        </View>
      </Swiper>
    )
  }
}

const styles = StyleSheet.create({
  wrapper: {},
  slide1: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#9DD6EB'
  },
  slide2: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#97CAE5'
  },
  slide3: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#92BBD9'
  },
  text: {
    color: '#fff',
    fontSize: 30,
    fontWeight: 'bold'
  }
})
```

```react
import React from 'react';
import { View, StyleSheet, Image, Dimensions, Platform, StatusBar } from 'react-native';
import Swiper from 'react-native-swiper';

const { height } = Dimensions.get('window');

const SwiperExample = () => {
  const swiperHeight = height * 0.25; // 计算 Swiper 的高度为屏幕高度的25%

  return (
    <View style={styles.container}>
      <Swiper style={[styles.wrapper, { height: swiperHeight }]} autoplay={true} autoplayTimeout={2}>
        <View style={styles.slide}>
          <Image
            source={{ uri: 'https://via.placeholder.com/400x200' }}
            style={styles.image}
          />
        </View>
        <View style={styles.slide}>
          <Image
            source={{ uri: 'https://via.placeholder.com/400x200' }}
            style={styles.image}
          />
        </View>
        <View style={styles.slide}>
          <Image
            source={{ uri: 'https://via.placeholder.com/400x200' }}
            style={styles.image}
          />
        </View>
      </Swiper>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    position: 'absolute',
    paddingTop: Platform.OS === 'android' ? StatusBar.currentHeight : 0, // 适配 Android 状态栏
    top: 0,
    left: 0,
    right: 0,
    zIndex: 1,
  },
  wrapper: {},
  slide: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  image: {
    width: '100%',
    height: '100%',
    resizeMode: 'cover',
  },
});

export default SwiperExample;
```



## ⚡ AsyncStorage

- **功能**: AsyncStorage 是 React Native 中用于本地持久化存储数据的 API，类似于 Web 开发中的 localStorage。
- **用途**: 用于存储应用程序的持久化数据，如用户配置、应用程序状态、用户登录信息等。

[官网]: https://reactnative.dev/docs/asyncstorage
[官网]: https://npmjs.com/package/@react-native-async-storage/async-storage
[官网]: https://react-native-async-storage.github.io/async-storage/docs/usage

安装

```
npm i @react-native-async-storage/async-storage
```

```react
import React, { useState, useEffect } from 'react';
import { View, Text, Button } from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';

const App = () => {
  const [count, setCount] = useState(0);

  // 从 AsyncStorage 中加载初始值
  useEffect(() => {
    const loadData = async () => {
      try {
        const value = await AsyncStorage.getItem('count');
        if (value !== null) {
          setCount(parseInt(value));
        }
      } catch (error) {
        console.error('Error loading data:', error);
      }
    };
    loadData();
  }, []);

  // 将 count 值保存到 AsyncStorage 中
  const saveData = async () => {
    try {
      await AsyncStorage.setItem('count', count.toString());
      console.log('Data saved successfully!');
    } catch (error) {
      console.error('Error saving data:', error);
    }
  };

  return (
    <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
      <Text>Count: {count}</Text>
      <Button title="增量" onPress={() => setCount(prevCount => prevCount + 1)} />
      <Button title="递减" onPress={() => setCount(prevCount => prevCount - 1)} />
      <Button title="Save Data" onPress={saveData} />
    </View>
  );
};

export default App;
```



## ⚡ Expo Location

- 通过 Expo Location，开发者可以轻松地在 Expo 应用程序中获取和利用用户的位置信息，以实现位置相关的功能和服务，例如地图应用、定位服务、位置提醒等。

[官网]: https://docs.expo.dev/versions/latest/sdk/location/

安装

```
npx expo install expo-location
```

```react
import React, { useState, useEffect } from 'react';
import { View, Text, Button } from 'react-native';
import * as Location from 'expo-location';

const App = () => {
  const [location, setLocation] = useState(null);
  const [error, setError] = useState(null);

  useEffect(() => {
    // 请求前台位置权限
    (async () => {
      let { status } = await Location.requestForegroundPermissionsAsync();
      if (status !== 'granted') {
        setError('Permission to access location was denied');
        return;
      }

      // 获取当前位置信息
      let location = await Location.getCurrentPositionAsync({});
      setLocation(location);
    })();
  }, []);

  return (
    <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
      {location ? (
        <View>
          <Text>Latitude: {location.coords.latitude}</Text>
          <Text>Longitude: {location.coords.longitude}</Text>
        </View>
      ) : (
        <Text>Loading...</Text>
      )}
      {error && <Text>Error: {error}</Text>}
    </View>
  );
};

export default App;
```



## ⚡ Expo Camera

- Expo Camera 是 Expo SDK 中的一个模块，它使得在 Expo 应用中集成相机功能变得非常简单。Expo Camera 提供了一系列易于使用的组件和 API，让开发者能够轻松地在应用中实现拍照、录像等功能。

  主要功能和特点包括：

  1. **相机预览：** 可以在应用中显示实时的相机预览，用户可以通过界面进行拍照和录像操作。
  2. **拍照功能：** 支持在应用中拍摄照片，可以设置照片质量、格式等参数。
  3. **录像功能：** 支持在应用中录制视频，可以设置视频质量、分辨率等参数。
  4. **权限管理：** Expo Camera 自动处理权限请求和系统相机访问的问题，开发者无需担心权限问题。
  5. **闪光灯控制：** 可以控制设备的闪光灯功能，用于拍摄照片和录制视频时的光线辅助。
  6. **前后摄像头切换：** 支持前后摄像头的切换，用户可以选择使用哪个摄像头进行拍摄。
  7. **自定义界面：** 可以通过自定义样式和布局来定制相机界面，以适应应用的设计风格。

[官网]: https://docs.expo.dev/versions/latest/sdk/camera/
[素材]: https://codewithbeto.dev/projects/camera-expo

安装

```
npx expo install expo-camera
```

```react
import React, { useState, useEffect } from 'react';
import { StyleSheet, Text, View, TouchableOpacity } from 'react-native';
import { Camera } from 'expo-camera';

const CameraExample = () => {
  const [hasPermission, setHasPermission] = useState(null);
  const [cameraRef, setCameraRef] = useState(null);

  useEffect(() => {
    (async () => {
      const { status } = await Camera.requestCameraPermissionsAsync();
      setHasPermission(status === 'granted');
    })();
  }, []);

  const takePicture = async () => {
    if (cameraRef) {
      const photo = await cameraRef.takePictureAsync({
        quality: 1, // 设置照片质量为原始质量的一半
        pictureSize: '140x480', // 设置照片分辨率为640x480
      });
      console.log(photo);
    }
  };

  if (hasPermission === null) {
    return <View />;
  }
  if (hasPermission === false) {
    return <Text>No access to camera</Text>;
  }

  return (
    <View style={styles.container}>
      <Camera
        style={styles.camera}
        type={Camera.Constants.Type.back}
        ref={ref => setCameraRef(ref)}
      >
        <View style={styles.buttonContainer}>
          <TouchableOpacity style={styles.button} onPress={takePicture}>
            <Text style={styles.text}>Take Picture</Text>
          </TouchableOpacity>
        </View>
      </Camera>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  camera: {
    flex: 1,
    justifyContent: 'flex-end',
    alignItems: 'center',
  },
  buttonContainer: {
    flexDirection: 'row',
    justifyContent: 'center',
    marginBottom: 20,
  },
  button: {
    backgroundColor: '#fff',
    borderRadius: 5,
    padding: 15,
    paddingHorizontal: 20,
    alignSelf: 'center',
  },
  text: {
    fontSize: 20,
  },
});

export default CameraExample;
```



## ⚡ Expo MediaLibrary

Expo MediaLibrary 是 Expo 提供的一个库，用于在 Expo 应用程序中管理设备上的照片和视频。它提供了一组方法，让你可以从设备的相册中获取媒体文件、保存新的照片和视频，以及删除媒体文件等操作。

**主要的功能包括：**

1. 获取设备上的照片和视频文件。
2. 保存新的照片和视频到设备。
3. 删除设备上的照片和视频文件。
4. 获取照片和视频的详细信息，如尺寸、类型等。

[官网]: https://docs.expo.dev/versions/latest/sdk/media-library/
[素材]: https://codewithbeto.dev/projects/camera-expo

安装

```
npx expo install expo-media-library
```

App.jsx

```react
import React, { useState, useEffect, useRef } from 'react';
import { Text, View, StyleSheet, TouchableOpacity, Image } from 'react-native';
import Constants from 'expo-constants';
import { Camera, CameraType } from 'expo-camera';
import * as MediaLibrary from 'expo-media-library';
import { MaterialIcons } from '@expo/vector-icons';
import Button from './src/components/Button';

export default function App() {
  const [hasCameraPermission, setHasCameraPermission] = useState(null);
  const [image, setImage] = useState(null);
  const [type, setType] = useState(Camera.Constants.Type.back);
  const [flash, setFlash] = useState(Camera.Constants.FlashMode.off);
  const cameraRef = useRef(null);

  useEffect(() => {
    (async () => {
      MediaLibrary.requestPermissionsAsync();
      const cameraStatus = await Camera.requestCameraPermissionsAsync();
      setHasCameraPermission(cameraStatus.status === 'granted');
    })();
  }, []);

  const takePicture = async () => {
    if (cameraRef) {
      try {
        const data = await cameraRef.current.takePictureAsync();
        console.log(data);
        setImage(data.uri);
      } catch (error) {
        console.log(error);
      }
    }
  };

  const savePicture = async () => {
    if (image) {
      try {
        const asset = await MediaLibrary.createAssetAsync(image);
        alert('Picture saved! 🎉');
        setImage(null);
        console.log('saved successfully');
      } catch (error) {
        console.log(error);
      }
    }
  };

  if (hasCameraPermission === false) {
    return <Text>No access to camera</Text>;
  }

  return (
    <View style={styles.container}>
      {!image ? (
        <Camera
          style={styles.camera}
          type={type}
          ref={cameraRef}
          flashMode={flash}
        >
          <View
            style={{
              flexDirection: 'row',
              justifyContent: 'space-between',
              paddingHorizontal: 30,
            }}
          >
            <Button
              title=""
              icon="retweet"
              onPress={() => {
                setType(
                  type === CameraType.back ? CameraType.front : CameraType.back
                );
              }}
            />
            <Button
              onPress={() =>
                setFlash(
                  flash === Camera.Constants.FlashMode.off
                    ? Camera.Constants.FlashMode.on
                    : Camera.Constants.FlashMode.off
                )
              }
              icon="flash"
              color={flash === Camera.Constants.FlashMode.off ? 'gray' : '#fff'}
            />
          </View>
        </Camera>
      ) : (
        <Image source={{ uri: image }} style={styles.camera} />
      )}

      <View style={styles.controls}>
        {image ? (
          <View
            style={{
              flexDirection: 'row',
              justifyContent: 'space-between',
              paddingHorizontal: 50,
            }}
          >
            <Button
              title="Re-take"
              onPress={() => setImage(null)}
              icon="retweet"
            />
            <Button title="Save" onPress={savePicture} icon="check" />
          </View>
        ) : (
          <Button title="Take a picture" onPress={takePicture} icon="camera" />
        )}
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    paddingTop: Constants.statusBarHeight,
    backgroundColor: '#000',
    padding: 8,
  },
  controls: {
    flex: 0.5,
  },
  button: {
    height: 40,
    borderRadius: 6,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
  },
  text: {
    fontWeight: 'bold',
    fontSize: 16,
    color: '#E9730F',
    marginLeft: 10,
  },
  camera: {
    flex: 5,
    borderRadius: 20,
  },
  topControls: {
    flex: 1,
  },
});
```

Button.jsx

```react
import * as React from 'react';
import { Text, TouchableOpacity, StyleSheet } from 'react-native';
import { Entypo } from '@expo/vector-icons';
import { MaterialIcons } from '@expo/vector-icons';

export default function Button({ title, onPress, icon, color }) {
  return (
    <TouchableOpacity onPress={onPress} style={styles.button}>
      <Entypo name={icon} size={28} color={color ? color : '#f1f1f1'} />
      <Text style={styles.text}>{title}</Text>
    </TouchableOpacity>
  );
}

const styles = StyleSheet.create({
  button: {
    height: 40,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
  },
  text: {
    fontWeight: 'bold',
    fontSize: 16,
    color: '#f1f1f1',
    marginLeft: 10,
  },
});
```





## ⚡ Expo ImagePicker

React Native Image Picker 是一个用于从相册或相机中选择图片的库。它允许你的应用程序与用户的设备相册和相机进行交互，并获取所选图片的信息。

**主要特性包括：**

1. 从相册中选择图片：用户可以从设备的相册中选择图片。
2. 使用相机拍摄图片：用户可以使用设备的相机拍摄新的图片。
3. 自定义选项：可以配置图片选择器的行为和外观，例如设置图片质量、允许裁剪、选择多个图片等。

[官网]: https://docs.expo.dev/versions/latest/sdk/imagepicker/

安装

```
npx expo install expo-image-picker
```

```react
import { useState } from 'react';
import { Button, Image, View, StyleSheet } from 'react-native';
import * as ImagePicker from 'expo-image-picker';

export default function ImagePickerExample() {
  const [image, setImage] = useState(null);

  const pickImage = async () => {
    // 启动图像库无需请求权限
    let result = await ImagePicker.launchImageLibraryAsync({
      mediaTypes: ImagePicker.MediaTypeOptions.All,
      allowsEditing: true,
      aspect: [4, 3],
      quality: 1,
    });

    console.log(result);

    if (!result.canceled) {
      setImage(result.assets[0].uri);
    }
  };

  return (
    <View style={styles.container}>
      <Button title="Pick an image from camera roll" onPress={pickImage} />
      {image && <Image source={{ uri: image }} style={styles.image} />}
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: "center",
    justifyContent: "center",
  },
  image: {
    width: 200,
    height: 200,
  },
});
```



## 其他 Expo 第三方插件

[官网]: https://docs.expo.dev/versions/latest/sdk/accelerometer/











