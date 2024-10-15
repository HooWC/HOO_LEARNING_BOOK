# React Native Expo Navigation

[官网]: https://docs.expo.dev/router/installation/



## 快速构建 `Navigation` 项目

```
npx create-expo-app --template

选择 Navigation (TypeScript)

// 无需再安装以下
```



## 安装

```
npx expo install expo-router react-native-safe-area-context react-native-screens expo-linking expo-constants expo-status-bar
```

`package.json`


```
{
  "main": "expo-router/entry"
}
```

`app.json`

```
{
  "scheme": "your-app-scheme"
}
```





## 主 Layout

在 React Native 中，"Stack" 通常指的是堆栈导航（Stack Navigation），它是一种导航模式，允许用户在不同的屏幕之间进行堆叠式的导航。

`app/_layout.jsx`

```react
import { Stack } from "expo-router";

const RootLayout = () => (
  <Stack>
    <Stack.Screen 
        name="index" 
        options={{
            headerTitle: "Home Page",
            headerStyle: {
                backgroundColor: "red",
            },
        }} />
    <Stack.Screen 
        name="users/[id]" 
        options={{
            headerTitle: "User Page",
        }} />
  </Stack>
);

export default RootLayout;
```

有 `Tabs` 的

```react
import { Stack } from "expo-router";

const RootLayout = () => (
  <Stack>
    <Stack.Screen name="(tabs)" />
  </Stack>
);

export default RootLayout;
```



`Redirect`

```react
import { Redirect } from 'expo-router'

<Redirect href="/home" />
```



`两种方式`

```react
import { Link } from "expo-router";

<Link href="/user/1">Go to user 1</Link>
```

```react
import { router } from "expo-router";
import { Pressable } from "react-native";

<Pressable onPress={() => router.push("/user/2")}>
	<Text>Go to user 2</Text>
</Pressable>
```



`传`

```react
import { router } from "expo-router";
import { Pressable } from "react-native";

<Pressable onPress={() => router.push({
        pathname: "/user/[id]",
        params: { id: 2 }
    })}>
	<Text>Go to user 2</Text>
</Pressable>
```

`用`

```react
import { useLocalSearchParams } from "expo-router";

const { id } = useLocalSearchParams();
```

```react
import { useLocalSearchParams } from "expo-router";

const { id } = useLocalSearchParams<{
	id: string
}>();
```



## Tabs (副 Layout)

在 React Native 中，"Tabs" 通常指的是选项卡导航（Tab Navigation），它是一种常见的用户界面设计模式，用于在应用程序中切换不同的视图或功能。

**选项卡通常位于屏幕底部**

```react
import { Tabs } from "expo-router";

const TabsLayout = () => {
    return (
        <Tabs>
            <Tabs.Screen name="index" options={{
                headerTitle: "Home",
                title: "Home"
            }}/>
            <Tabs.Screen name="users/[id]" options={{
                headerTitle: "User Page",
                title: "User"
            }}/>
        </Tabs>
    )
}

export default TabsLayout;
```





## 项目例子 （登入）

`app/(app)`

- `app/(app)/(tabs)/...`

- `app/(app)/_layout.tsx`

  ```react
  import { Stack } from "expo-router";
  
  export default function AppEntry() {
      return (
        <Stack>
          <Stack.Screen name="(tabs)" options={{ headerShown: false }} />
          <Stack.Screen name="modal" options={{ presentation: 'modal' }} />
        </Stack>
      )
  }
  ```

  

`app/(auth)`

- `app/(auth)/login.tsx`

  ```react
  export default function LoginScreen() {
  
    const { signIn } = useAuth();
  
    return (
      <View style={styles.container}>
        <Text style={styles.title}>Login</Text>
        <View style={styles.separator} lightColor="#eee" darkColor="rgba(255,255,255,0.1)" />
        <Button title="Sign In" color={"orange"} onPress={signIn} />
      </View>
    );
  }
  ```

  

`app/_layout.tsx`

```react
function RootLayoutNav() {
  const colorScheme = useColorScheme();

  return (
    <AuthProvider>
      <ThemeProvider value={colorScheme === 'dark' ? DarkTheme : DefaultTheme}>
        <Slot />
      </ThemeProvider>
    </AuthProvider>
  );
}
```



`context/auth.tsx`

```react
import * as React from 'react';
import { useSegments, useRouter } from "expo-router";

const AuthContext = React.createContext<any>(null);

export function useAuth(){
    return React.useContext(AuthContext);
}

export function AuthProvider({ children }:React.PropsWithChildren) {

    const rootSegment = useSegments()[0];
    const router = useRouter();
    const [user, setUser] = React.useState<string | undefined>("");

    React.useEffect(() => {
        if(user === undefined) return;

        if(!user && rootSegment !== "(auth)") {
            // 如果用户不存在 ， 界面却来到 auth ， 就返回登入界面
            router.replace("/(auth)/login");
        }else if(user && rootSegment !== "(app)"){
            // 如果用户存在
            router.replace("/");
        }
    }, [user, rootSegment]);

    const signIn = () => {
        setUser("Beto")
    };

    const signOut = () => {
        setUser("")
    };

    return (
        <AuthContext.Provider value={{ user, signIn, signOut }}>
            {children}
        </AuthContext.Provider>
    );
}
```





























