## Xamarin 基础



#### Syncfusion

[登入网站](syncfusion
https://www.syncfusion.com/products/communitylicense)

账号：1 - 6

[syncfusion document](https://help.syncfusion.com/xamarin/autocomplete/overview)

**获取 License** 

License & Downloads -> get License  -> 输入信息 -> 等待





#### 文件目录

```
ProjectName
	API
	Fonts
	Models
	PopUpPage
	View
	ViewModels
	App.xaml.cs
		App.xaml.cs
	MainPage.xaml
ProjectName.Android
	Resources
		drawable // 引入图片
	MainActivity.cs
ProjectName.iOS
```



#### 安装包

```
CardsView
Newtonsoft.Json
Rg.Plugins.Popup
Xam.Plugins.Forms.ImageCircle
Xamarin.Essentials
Xamarin.FFImageLoading.Forms
Xamarin.FOrms.PancakeView

OneSignalSDK.Xamarin

Syncfusion.Xamarin.Buttons
Syncfusion.Xamarin.Core
Syncfusion.Xamarin.SfAutoComplete
Syncfusion.Xamarin.SfMaskedEdit
Syncfusion.Xamarin.SfRotator
Syncfusion.Xamarin.SfTabView
```



#### Main 配置

App.xaml.cs

```c#
using System;
using Cinema.View;
using OneSignalSDK.Xamarin;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

// 引入 字体
[assembly: ExportFont("ZCOOLKuaiLe-Regular.ttf", Alias = "AC")]
[assembly: ExportFont("Kalam-Regular.ttf", Alias = "BC")]
[assembly: ExportFont("Playball-Regular.ttf", Alias = "CC")]
[assembly: ExportFont("Merienda-Bold.ttf", Alias = "DC")]
[assembly: ExportFont("BerkshireSwash-Regular.ttf", Alias = "EC")]
[assembly: ExportFont("ConcertOne-Regular.ttf", Alias = "FC")]
[assembly: ExportFont("Viga-Regular.ttf", Alias = "GC")]
[assembly: ExportFont("LibreBaskerville-Italic.ttf", Alias = "HC")]

// 引入 字体
[assembly: ExportFont("Exo2-VariableFont_wght.ttf", Alias = "AA")]
[assembly: ExportFont("BebasNeue-Regular.ttf", Alias = "BA")]
[assembly: ExportFont("NotoSerifSC-Bold.ttf", Alias = "CA")]
[assembly: ExportFont("Signika-VariableFont_wght.ttf", Alias = "DA")]
[assembly: ExportFont("AbrilFatface-Regular.ttf", Alias = "EA")]
[assembly: ExportFont("Kalam-Bold.ttf", Alias = "FA")]

namespace Cinema
{
	public partial class App : Application
	{
		public App()
		{
			InitializeComponent();

			MainPage = new MainPage();

			// 注册 Syncfusion
                                               				  Syncfusion.Licensing.SyncfusionLicenseProvider.RegisterLicense("MjY5NTMxMUAzMjMxMmUzMDJlMzBTYVYrUXlLZzk4V1hFZ2FXc3k3ODU1NWJ6M2pKeE9TR2pvaGV6Q1ZEZkJjPQ==");

			// 默认 启动 首页
			MainPage = new NavigationPage(new Start());

			// 配置 发送 信息
			OneSignal.Default.Initialize("aa0150b5-ea7a-4d62-812e-3f7aaabaae5b");
			OneSignal.Default.PromptForPushNotificationsWithUserResponse();
		}

		protected override void OnStart()
		{
		}

		protected override void OnSleep()
		{
		}

		protected override void OnResume()
		{
		}
	}
}
```





#### Android

**MainActivity.cs 配置**

```c#
using System;

using Android.App;
using Android.Content.PM;
using Android.Runtime;
using Android.OS;
using ImageCircle.Forms.Plugin.Droid;
using Xamarin.Forms.PlatformConfiguration.AndroidSpecific;
using OneSignalSDK.Xamarin;

namespace Cinema.Droid
{
	[Activity(Label = "Sakura Cinema", Icon = "@drawable/logonone", Theme = "@style/MainTheme", MainLauncher = true, ConfigurationChanges = ConfigChanges.ScreenSize | ConfigChanges.Orientation | ConfigChanges.UiMode | ConfigChanges.ScreenLayout | ConfigChanges.SmallestScreenSize)]
	public class MainActivity : global::Xamarin.Forms.Platform.Android.FormsAppCompatActivity
	{
		protected override void OnCreate(Bundle savedInstanceState)
		{
			base.OnCreate(savedInstanceState);

			// 手机 信息 通知
			OneSignal.Default.Initialize("aa0150b5-ea7a-4d62-812e-3f7aaabaae5b");
			OneSignal.Default.PromptForPushNotificationsWithUserResponse();
			Rg.Plugins.Popup.Popup.Init(this);

			Xamarin.Essentials.Platform.Init(this, savedInstanceState);
			global::Xamarin.Forms.Forms.Init(this, savedInstanceState);
			ImageCircleRenderer.Init();
			Window.SetStatusBarColor(Android.Graphics.Color.Rgb(45, 45, 46));
			//Window.SetStatusBarColor(Android.Graphics.Color.Rgb(45, 45, 46));
			FFImageLoading.Forms.Platform.CachedImageRenderer.Init(true);
			LoadApplication(new App());
			Xamarin.Forms.Application.Current.On<Xamarin.Forms.PlatformConfiguration.Android>().UseWindowSoftInputModeAdjust(WindowSoftInputModeAdjust.Resize);
		}
		public override void OnRequestPermissionsResult(int requestCode, string[] permissions, [GeneratedEnum] Android.Content.PM.Permission[] grantResults)
		{
			Xamarin.Essentials.Platform.OnRequestPermissionsResult(requestCode, permissions, grantResults);

			base.OnRequestPermissionsResult(requestCode, permissions, grantResults);
		}
	}
}
```





#### 字体 引入

右键 -> 属性 -> 选择生成操作 -> 嵌入的资源

然后在 App.xaml.cs 配置

```c#
[assembly: ExportFont("ZCOOLKuaiLe-Regular.ttf", Alias = "AC")]
[assembly: ExportFont("Kalam-Regular.ttf", Alias = "BC")]
[assembly: ExportFont("Playball-Regular.ttf", Alias = "CC")]
```



## 开始



#### API

UserApi 例子

```c#
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Text;
using Cinema.Models;
using System.Threading.Tasks;
using Xamarin.Essentials;
using Newtonsoft.Json;
using Cinema.ViewModel;
using System.Linq;

namespace Cinema.API
{
	public class UserDB
	{
        // 默认 API URL
		const string baseUrl = "http://10.0.2.2:5041/api/";
		HttpClient client = new HttpClient();
		public static string JWBToken = null;
		public static int userID = 0;

        // Admin Token
		public void Token_Admin()
		{
			Admin ad = new Admin()
			{
				Username = "hoo",
				Password = "hoo"
			};

			using (var client = new HttpClient())
			{
				client.BaseAddress = new Uri(baseUrl);
				StringContent content = new StringContent(JsonConvert.SerializeObject(ad), Encoding.UTF8, "application/json");

				var respose = client.PostAsync("AdminToken", content).Result;

				if (respose.IsSuccessStatusCode)
				{
					string token = respose.Content.ReadAsStringAsync().Result;
					if (token != "Invalid credentials")
					{
						JWBToken = token;
					}
				}
			}
		}

        // 用户 Token
		public void Token_User()
		{
			string Username = Preferences.Get("Username", string.Empty);
			string Password = Preferences.Get("Password", string.Empty);

			User user = new User()
			{
				Username = Username,
				Password = Password
			};

			using (var client = new HttpClient())
			{
				client.BaseAddress = new Uri(baseUrl);
				StringContent content = new StringContent(JsonConvert.SerializeObject(user), Encoding.UTF8, "application/json");
				var respose = client.PostAsync("UserToken", content).Result;

				if (respose.IsSuccessStatusCode)
				{
					string token = respose.Content.ReadAsStringAsync().Result;
					if (token != "Invalid credentials")
						JWBToken = token;
				}
			}
		}

        // 获取 所有 用户 Token——Admin
		public async Task<ObservableCollection<User>> GetAllUser_Api()
		{
			client.DefaultRequestHeaders.Authorization = new AuthenticationHeaderValue("Bearer", JWBToken);
			client.BaseAddress = new Uri(baseUrl);
			var respose = client.GetAsync("User").Result;

			if (respose.IsSuccessStatusCode)
			{
				string jsonString = respose.Content.ReadAsStringAsync().Result;
				return JsonConvert.DeserializeObject<ObservableCollection<User>>(jsonString);
			}

			return null;
		}

        // 获取 所有 用户 Token——Admin 主
		public ObservableCollection<User> GetAllUser()
		{
			Token_Admin();
			return GetAllUser_Api().Result;
		}

        // 获取 所有 用户 Token——User
		public User GetAllUser_One()
		{
			string Username = Preferences.Get("Username", string.Empty);
			string Password = Preferences.Get("Password", string.Empty);
			var userData = GetAllUser();
			var data = userData.Where(x => x.Username == Username & x.Password == Password).FirstOrDefault();
			if (data != null)
			{
				return data;
			}
			return null;
		}
		
        // 获取 所有 用户 Token——User 主
		public ObservableCollection<User> GetAllUser_User()
		{
			Token_User();
			return GetAllUser_Api().Result;
		}

         // 创建
		public async Task CreateUser_Api(User user)
		{
			client.DefaultRequestHeaders.Authorization = new AuthenticationHeaderValue("Bearer", JWBToken);
			client.BaseAddress = new Uri(baseUrl);
			var respose = client.GetAsync("User").Result;

			if (respose.IsSuccessStatusCode)
			{
				var jsonStr = new StringContent(JsonConvert.SerializeObject(user), Encoding.UTF8, "application/json");
				await client.PostAsync(baseUrl + "User", jsonStr);
			}
		}

        // 创建 主
		public async Task CreateUser(User user)
		{
			Token_Admin();
			await CreateUser_Api(user);
		}

        // 修改
		public async Task EditUser_Api(User user)
		{
			var client2 = new HttpClient();

			// 设置 HttpClient 实例的属性
			client2.DefaultRequestHeaders.Authorization = new AuthenticationHeaderValue("Bearer", JWBToken);
			client2.BaseAddress = new Uri(baseUrl);

			var response = await client2.GetAsync("User");

			if (response.IsSuccessStatusCode)
			{
				var jsonStr = new StringContent(JsonConvert.SerializeObject(user), Encoding.UTF8, "application/json");
				await client.PutAsync(baseUrl + "User/" + user.UserID, jsonStr);
			}

		}

        // 修改 主
		public async Task EditUser(User user)
		{
			Token_User();
			EditUser_Api(user);
		}

	}
}
```

其他 例子

```c#
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Net.Http.Headers;
using System.Net.Http;
using System.Text;
using Cinema.Models;
using Newtonsoft.Json;
using System.Threading.Tasks;
using Xamarin.Essentials;
using System.Linq;

namespace Cinema.API
{
	public class ActorDB
	{
		const string baseUrl = "http://10.0.2.2:5041/api/";
		HttpClient client = new HttpClient();
		public static string JWBToken = null;
		public static int userID = 0;

		public void Token_Admin()
		{
			Admin ad = new Admin()
			{
				Username = "hoo",
				Password = "hoo"
			};

			using (var client = new HttpClient())
			{
				client.BaseAddress = new Uri(baseUrl);
				StringContent content = new StringContent(JsonConvert.SerializeObject(ad), Encoding.UTF8, "application/json");

				var respose = client.PostAsync("AdminToken", content).Result;

				if (respose.IsSuccessStatusCode)
				{
					string token = respose.Content.ReadAsStringAsync().Result;
					if (token != "Invalid credentials")
					{
						JWBToken = token;
					}
				}
			}
		}

		public void Token_User()
		{
			string Username = Preferences.Get("Username", string.Empty);
			string Password = Preferences.Get("Password", string.Empty);

			User user = new User()
			{
				Username = Username,
				Password = Password
			};

			using (var client = new HttpClient())
			{
				client.BaseAddress = new Uri(baseUrl);
				StringContent content = new StringContent(JsonConvert.SerializeObject(user), Encoding.UTF8, "application/json");
				var respose = client.PostAsync("UserToken", content).Result;

				if (respose.IsSuccessStatusCode)
				{
					string token = respose.Content.ReadAsStringAsync().Result;
					if (token != "Invalid credentials")
						JWBToken = token;
				}
			}
		}

		public async Task<ObservableCollection<Actor>> GetAllActor_Api()
		{
			client.DefaultRequestHeaders.Authorization = new AuthenticationHeaderValue("Bearer", JWBToken);
			client.BaseAddress = new Uri(baseUrl);
			var respose = client.GetAsync("Actor").Result;

			if (respose.IsSuccessStatusCode)
			{
				string jsonString = respose.Content.ReadAsStringAsync().Result;
				return JsonConvert.DeserializeObject<ObservableCollection<Actor>>(jsonString);
			}

			return null;
		}

		public ObservableCollection<Actor> GetAllActor()
		{
			Token_Admin();
			return GetAllActor_Api().Result;
		}

		public ObservableCollection<Actor> GetAllActor_User()
		{
			Token_User();
			return GetAllActor_Api().Result;
		}

	}
}
```

```c#
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Net.Http.Headers;
using System.Net.Http;
using System.Text;
using Cinema.Models;
using Newtonsoft.Json;
using System.Threading.Tasks;
using Xamarin.Essentials;

namespace Cinema.API
{
	public class HallDB
	{
		const string baseUrl = "http://10.0.2.2:5041/api/";
		HttpClient client = new HttpClient();
		public static string JWBToken = null;
		public static int userID = 0;

		public void Token_Admin()
		{
			Admin ad = new Admin()
			{
				Username = "hoo",
				Password = "hoo"
			};

			using (var client = new HttpClient())
			{
				client.BaseAddress = new Uri(baseUrl);
				StringContent content = new StringContent(JsonConvert.SerializeObject(ad), Encoding.UTF8, "application/json");

				var respose = client.PostAsync("AdminToken", content).Result;

				if (respose.IsSuccessStatusCode)
				{
					string token = respose.Content.ReadAsStringAsync().Result;
					if (token != "Invalid credentials")
					{
						JWBToken = token;
					}
				}
			}
		}

		public void Token_User()
		{
			string Username = Preferences.Get("Username", string.Empty);
			string Password = Preferences.Get("Password", string.Empty);

			User user = new User()
			{
				Username = Username,
				Password = Password
			};

			using (var client = new HttpClient())
			{
				client.BaseAddress = new Uri(baseUrl);
				StringContent content = new StringContent(JsonConvert.SerializeObject(user), Encoding.UTF8, "application/json");
				var respose = client.PostAsync("UserToken", content).Result;

				if (respose.IsSuccessStatusCode)
				{
					string token = respose.Content.ReadAsStringAsync().Result;
					if (token != "Invalid credentials")
						JWBToken = token;
				}
			}
		}

		public async Task<ObservableCollection<Hall>> GetAllHall_Api()
		{
			client.DefaultRequestHeaders.Authorization = new AuthenticationHeaderValue("Bearer", JWBToken);
			client.BaseAddress = new Uri(baseUrl);
			var respose = client.GetAsync("Hall").Result;

			if (respose.IsSuccessStatusCode)
			{
				string jsonString = respose.Content.ReadAsStringAsync().Result;
				return JsonConvert.DeserializeObject<ObservableCollection<Hall>>(jsonString);
			}

			return null;
		}

		public ObservableCollection<Hall> GetAllHall()
		{
			Token_Admin();
			return GetAllHall_Api().Result;
		}

		public ObservableCollection<Hall> GetAllHall_User()
		{
			Token_User();
			return GetAllHall_Api().Result;
		}

	}
}
```



#### Session（Preferences）

```c#
using Xamarin.Essentials;
```

```c#
// 存储字符串值
Preferences.Set("username", "Alice");

// 存储整数值
Preferences.Set("age", 25);

// 存储布尔值
Preferences.Set("isLoggedIn", true);
```

```c#
// 获取字符串值
string username = Preferences.Get("username", "defaultUser");

// 获取整数值
int age = Preferences.Get("age", 0);

// 获取布尔值
bool isLoggedIn = Preferences.Get("isLoggedIn", false);
```

```c#
Preferences.Remove("username");
```

```c#
Preferences.Clear();
```

```c#
// 从 Preferences 中获取用户信息，如果没有找到则返回空字符串
string Username = Preferences.Get("Username", string.Empty);
string Password = Preferences.Get("Password", string.Empty);
```



#### List / Split

```c#
List<string> list_inter = new List<string>();
string[] str = movie_data.Genre.Split(new char[] { '|' }, StringSplitOptions.RemoveEmptyEntries);
list_inter.AddRange(str);
```



#### Back End

```c#
public CalendarPopup(Show db)
		{
			InitializeComponent();
			showdb = db;

			var movie_db = Moviedb_Detail.GetAllMovie();
			var movie_data = movie_db.Where(x => x.MovieID == db.MovieID).FirstOrDefault();
			MovieName.Text = movie_data.Title;
			DateText.Text = db.Date.ToString().Substring(0, 10);
			Time.Text = $"{db.StartTime} - {db.EndTime}";
		}
```







#### XAML View

`cinema home page` 例子

**Font End**

```xml
<?xml version="1.0" encoding="utf-8" ?>
<ContentPage xmlns="http://xamarin.com/schemas/2014/forms"
             xmlns:x="http://schemas.microsoft.com/winfx/2009/xaml" 
             xmlns:abstractions="clr-namespace:ImageCircle.Forms.Plugin.Abstractions;assembly=ImageCircle.Forms.Plugin" 
             xmlns:inputLayout="clr-namespace:Syncfusion.XForms.TextInputLayout;assembly=Syncfusion.Core.XForms" 
             xmlns:tabView="clr-namespace:Syncfusion.XForms.TabView;assembly=Syncfusion.SfTabView.XForms"
             xmlns:autocomplete="clr-namespace:Syncfusion.SfAutoComplete.XForms;assembly=Syncfusion.SfAutoComplete.XForms" 
             xmlns:pancakeview="clr-namespace:Xamarin.Forms.PancakeView;assembly=Xamarin.Forms.PancakeView" 
             x:Class="Cinema.View.HomePage"
             NavigationPage.HasNavigationBar="False"
             xmlns:vm="clr-namespace:Cinema.ViewModel">

    <ContentPage.Resources>
        <ResourceDictionary>
            <vm:UserVM x:Key="UserVM"/>
            <vm:FunctionVM x:Key="FunctionVM"/>
        </ResourceDictionary>
    </ContentPage.Resources>

    <ContentPage.Content>

        <tabView:SfTabView BackgroundColor="#f2f2f2"  EnableSwiping="False"
                           TabHeaderPosition="Bottom" DisplayMode="Image"
                           VisibleHeaderCount="4">

            <tabView:SfTabView.SelectionIndicatorSettings>
                <tabView:SelectionIndicatorSettings Color="Transparent" Position="Fill" StrokeThickness="0"
                                                    AnimationDuration="10"/>
            </tabView:SfTabView.SelectionIndicatorSettings>

            <tabView:SfTabItem Title="Home"  ImageSource="homeIcon" SelectionColor="#000000" TitleFontColor="#666666">
                <tabView:SfTabItem.Content>

                    <ScrollView BackgroundColor="#ECECEC">
                        <StackLayout Padding="0,20,0,0"
                         HorizontalOptions="FillAndExpand" VerticalOptions="FillAndExpand" BindingContext="{StaticResource UserVM}">

                            <Grid Padding="0,0,10,0">
                                <Grid.RowDefinitions>
                                    <RowDefinition Height="*"/>
                                    <RowDefinition Height="*"/>
                                </Grid.RowDefinitions>
                                <Grid.ColumnDefinitions>
                                    <ColumnDefinition Width="*"/>
                                    <ColumnDefinition Width="3*"/>
                                    <ColumnDefinition Width="0.6*"/>
                                </Grid.ColumnDefinitions>

                                <abstractions:CircleImage Aspect="AspectFit"
                                              WidthRequest="50"
                                              HeightRequest="50"
                                              HorizontalOptions="EndAndExpand"
                                              Source="{Binding UserAvatar}"
                                              Grid.Row="0"
                                              Grid.Column="0" Grid.RowSpan="2"
                                              Margin="0,0,10,0">
                                </abstractions:CircleImage>

                                <Label Text="{Binding UserFullname}" FontAttributes="Bold"
                           Grid.Row="0" Grid.Column="1" TextColor="Black" FontSize="15"/>
                                <Label Text="I cann't Write Something...."
                           Grid.Row="1" Grid.Column="1" FontSize="12"/>

                                <Frame CornerRadius="100" HasShadow="True" HeightRequest="30" WidthRequest="30"
                           BackgroundColor="white" Padding="5" Grid.Row="0" Grid.Column="2" 
                           Grid.RowSpan="2" Margin="3">
                                    <Image x:Name="notificationimg"  HeightRequest="5" WidthRequest="5"/>
                                    <Frame.GestureRecognizers>
                                        <TapGestureRecognizer Tapped="NotificationOpen"/>
                                    </Frame.GestureRecognizers>
                                </Frame>

                            </Grid>

                            <StackLayout Orientation="Horizontal" Padding="20,0,10,0" Margin="0,10,0,0">

                                <inputLayout:SfTextInputLayout Hint="Search Movie" ContainerType="Outlined"
                                                   LeadingViewPosition="Inside" WidthRequest="315"
                                                   OutlineCornerRadius="100" HeightRequest="0"
                                                   Margin="0" x:Name="SearchName"
                                                               >
                                    <inputLayout:SfTextInputLayout.LeadingView>
                                        <Image Source="searchIcon" HeightRequest="20" WidthRequest="50">
                                            <Image.GestureRecognizers>
                                                <TapGestureRecognizer Tapped="MoveSearch"/>
                                            </Image.GestureRecognizers>
                                        </Image>
                                    </inputLayout:SfTextInputLayout.LeadingView>
                                    <autocomplete:SfAutoComplete DataSource="{Binding SearName}" 
                                                                 x:Name="Search" HeightRequest="45"  
                                                                 AutoCompleteMode="SuggestAppend"
                                                                 TextHighlightMode="FirstOccurrence"
                                                                 HighlightedTextColor="Red" 
                                                                 SelectedItem="{Binding SelectionObject}"
                                                                 SelectionChanged="OnAutoCompleteItemSelected"
                                                                 Completed="Handle_Completed"
                                     HighlightedTextFontAttributes="Bold"
                                     SuggestionMode="StartsWith">
                                    </autocomplete:SfAutoComplete>
                                </inputLayout:SfTextInputLayout>

                                <Frame CornerRadius="100" HasShadow="True" HeightRequest="32" WidthRequest="32"
                                       BackgroundColor="Black" Padding="5" Margin="12,11,0,0">
                                    <Image Source="tuneIcon" HeightRequest="10" WidthRequest="10"/>
                                    <Frame.GestureRecognizers>
                                        <TapGestureRecognizer Tapped="OpenTenu"/>
                                    </Frame.GestureRecognizers>
                                </Frame>

                            </StackLayout>

                            <StackLayout Padding="20,0,10,0" Margin="0,18,0,5">
                                <Label Text="Hot Movie" FontAttributes="Bold" TextColor="black" FontSize="18"/>
                            </StackLayout>

                            <StackLayout>

                                <Grid x:Name="TopThreeGrid" HeightRequest="220" Padding="13,0,13,0">
                                    <Grid.RowDefinitions>
                                        <RowDefinition Height="*"/>
                                        <RowDefinition Height="*"/>
                                    </Grid.RowDefinitions>
                                    <Grid.ColumnDefinitions>
                                        <ColumnDefinition Width="*"/>
                                        <ColumnDefinition Width="*"/>
                                    </Grid.ColumnDefinitions>


                                    <Frame Padding="0" Grid.Row="0" Grid.RowSpan="2" Grid.Column="0"
                                           CornerRadius="20">
                                        <AbsoluteLayout>
                                            <Image Source="{Binding HotMovie[0].MoviePoster}" Aspect="AspectFill"
                                       AbsoluteLayout.LayoutFlags="All"
                                       AbsoluteLayout.LayoutBounds="0,0,1,1"></Image>

                                        </AbsoluteLayout>
                                        <Frame.GestureRecognizers>
                                            <TapGestureRecognizer Tapped="MovieHot" CommandParameter="{Binding HotMovie[0].MovieID}"/>
                                        </Frame.GestureRecognizers>
                                    </Frame>



                                    <Frame Padding="0" Grid.Row="0" Grid.Column="1"
                           CornerRadius="20">
                                        <AbsoluteLayout>
                                            <Image Source="{Binding HotMovie[1].MoviePoster}" Aspect="AspectFill"
                                       AbsoluteLayout.LayoutFlags="All"
                                       AbsoluteLayout.LayoutBounds="0,0,1,1"></Image>

                                            <StackLayout  AbsoluteLayout.LayoutFlags="All"
                                       AbsoluteLayout.LayoutBounds="0,0,1,1" Padding="20">


                                            </StackLayout>
                                        </AbsoluteLayout>
                                        <Frame.GestureRecognizers>
                                            <TapGestureRecognizer Tapped="MovieHot" CommandParameter="{Binding HotMovie[1].MovieID}"/>
                                        </Frame.GestureRecognizers>
                                    </Frame>



                                    <Frame Padding="0" Grid.Row="1" Grid.Column="1"
                           CornerRadius="20">
                                        <AbsoluteLayout>
                                            <Image Source="{Binding HotMovie[2].MoviePoster}" Aspect="AspectFill"
                                       AbsoluteLayout.LayoutFlags="All"
                                       AbsoluteLayout.LayoutBounds="0,0,1,1"></Image>

                                            <StackLayout  AbsoluteLayout.LayoutFlags="All"
                                       AbsoluteLayout.LayoutBounds="0,0,1,1" Padding="20">


                                            </StackLayout>
                                        </AbsoluteLayout>
                                        <Frame.GestureRecognizers>
                                            <TapGestureRecognizer Tapped="MovieHot" CommandParameter="{Binding HotMovie[2].MovieID}"/>
                                        </Frame.GestureRecognizers>
                                    </Frame>

                                </Grid>


                            </StackLayout>

                            <StackLayout HorizontalOptions="FillAndExpand"
                                 HeightRequest="60"
                                 Padding="0,0,0,0" Margin="0,10,0,5">

                                <CollectionView ItemsLayout="HorizontalList"
                                        x:Name="PromotionList"
                                        HeightRequest="250"
                                        HorizontalScrollBarVisibility="Never"
                                        VerticalOptions="Start">
                                    <CollectionView.ItemTemplate>
                                        <DataTemplate>

                                            <StackLayout Padding="10">
                                                <Frame HasShadow="True"
                                                       BackgroundColor="{Binding Genre}"
                                                       Padding="25,10"
                                                       CornerRadius="100"
                                                       BorderColor="LightGray">
                                                    <Label Text="{Binding Title}" FontAttributes="Bold"
                                                           TextColor="{Binding Duration}"/>
                                                </Frame>

                                                <StackLayout.GestureRecognizers>
                                                    <TapGestureRecognizer CommandParameter="{Binding Title}" Tapped="Follow"/>
                                                </StackLayout.GestureRecognizers>
                                            </StackLayout>


                                        </DataTemplate>
                                    </CollectionView.ItemTemplate>

                                </CollectionView>


                            </StackLayout>

                            <StackLayout>
                                <!--HeightRequest="710"-->
                                <CollectionView x:Name="MediaList"  Margin="10,0,20,0">
                                    <CollectionView.ItemsLayout>
                                        <GridItemsLayout Orientation="Vertical"
                                                         Span="2"
                                                         HorizontalItemSpacing="6"
                                                         VerticalItemSpacing="22"/>
                                    </CollectionView.ItemsLayout>
                                    <CollectionView.ItemTemplate>
                                        <DataTemplate>

                                            <Frame Padding="0" CornerRadius="10" HeightRequest="220">
                                                <AbsoluteLayout>
                                                    <Image Source="{Binding MoviePoster}" Aspect="AspectFill"
                                                           AbsoluteLayout.LayoutFlags="All"
                                                           AbsoluteLayout.LayoutBounds="0,0,1,1"></Image>

                                                    <StackLayout  AbsoluteLayout.LayoutFlags="All"
                                                                  AbsoluteLayout.LayoutBounds="0,0,1,1" Padding="10">

                                                        <Frame CornerRadius="50" HasShadow="True" HeightRequest="15" WidthRequest="15"
                                                               BackgroundColor="white" Padding="10" Margin="0" HorizontalOptions="EndAndExpand">
                                                            <Label Text="{Binding RatingStar,StringFormat='{0:F2}'}" 
                                                                   TextColor="black" FontSize="10" FontAttributes="Bold"/>
                                                        </Frame>

                                                        <Frame BackgroundColor="White" CornerRadius="20" Opacity="0.6" 
                                                               VerticalOptions="EndAndExpand" Padding="5">
                                                            <Label Text="{Binding Director}" HorizontalTextAlignment="Center"
                                                                   TextColor="#000000" FontSize="14" FontAttributes="Bold"/>
                                                        </Frame>

                                                    </StackLayout>
                                                </AbsoluteLayout>

                                                <Frame.GestureRecognizers>
                                                    <TapGestureRecognizer Tapped="MovieHot" CommandParameter="{Binding MovieID}"/>
                                                </Frame.GestureRecognizers>

                                            </Frame>

                                        </DataTemplate>
                                    </CollectionView.ItemTemplate>
                                </CollectionView>

                            </StackLayout>


                        </StackLayout>
                    </ScrollView>

                </tabView:SfTabItem.Content>
            </tabView:SfTabItem>

            <tabView:SfTabItem Title="Movie" ImageSource="movieIcon" SelectionColor="#000000" TitleFontColor="#a3a0a0">
                <tabView:SfTabItem.Content>
                    <StackLayout BackgroundColor="#ECECEC">

                        <StackLayout HorizontalOptions="FillAndExpand"
                                 HeightRequest="60"
                                 Padding="0,0,0,0" Margin="0,10,0,5">

                            <CollectionView ItemsLayout="HorizontalList"
                                        x:Name="PromotionList2"
                                        HeightRequest="250"
                                        HorizontalScrollBarVisibility="Never"
                                        VerticalOptions="Start">
                                <CollectionView.ItemTemplate>
                                    <DataTemplate>

                                        <StackLayout Padding="10">
                                            <Frame HasShadow="True"
                                                       BackgroundColor="{Binding Genre}"
                                                       Padding="25,10"
                                                       CornerRadius="100"
                                                       BorderColor="LightGray">
                                                <Label Text="{Binding Title}" FontAttributes="Bold"
                                                           TextColor="{Binding Duration}"/>
                                            </Frame>

                                            <StackLayout.GestureRecognizers>
                                                <TapGestureRecognizer CommandParameter="{Binding Title}" Tapped="Follow2"/>
                                            </StackLayout.GestureRecognizers>
                                        </StackLayout>


                                    </DataTemplate>
                                </CollectionView.ItemTemplate>

                            </CollectionView>


                        </StackLayout>


                        <ScrollView BackgroundColor="#ECECEC">
                            <StackLayout Padding="0,20,0,0"
                                         HorizontalOptions="FillAndExpand" VerticalOptions="FillAndExpand">

                                <StackLayout Margin="0">

                                    <CollectionView x:Name="MediaList2" Margin="10,0,10,0">
                                        <CollectionView.ItemsLayout>
                                            <GridItemsLayout Orientation="Vertical"
                                                         Span="1"
                                                         HorizontalItemSpacing="0"
                                                         VerticalItemSpacing="10"/>
                                        </CollectionView.ItemsLayout>
                                        <CollectionView.ItemTemplate>
                                            <DataTemplate>

                                                <StackLayout>
                                                    <StackLayout Orientation="Horizontal" Padding="0,10,0,10">
                                                        <AbsoluteLayout>
                                                            <Frame AbsoluteLayout.LayoutFlags="All" AbsoluteLayout.LayoutBounds="0,0,0.3,1" 
                                                               Padding="0" CornerRadius="0" HeightRequest="160" 
                                                               HorizontalOptions="StartAndExpand">
                                                                <AbsoluteLayout>
                                                                    <Image Source="{Binding MoviePoster}" Aspect="AspectFill"
                                                                       AbsoluteLayout.LayoutFlags="All"
                                                                       AbsoluteLayout.LayoutBounds="0,0,1,1"></Image>
                                                                </AbsoluteLayout>
                                                            </Frame>

                                                            <StackLayout AbsoluteLayout.LayoutFlags="All"
                                                           AbsoluteLayout.LayoutBounds="1,0,0.7,1" Padding="10,2">

                                                                <StackLayout Orientation="Horizontal" Margin="0">

                                                                    <Label Text="{Binding Title}" TextColor="black" 
                                                                   FontSize="17" FontAttributes="Bold" VerticalTextAlignment="Center"/>

                                                                    <Frame CornerRadius="50" HasShadow="True" HeightRequest="12" WidthRequest="12"
                                                               BackgroundColor="white" Padding="8" Margin="0" HorizontalOptions="EndAndExpand">
                                                                        <Label Text="{Binding RatingStar,StringFormat='{0:F2}'}" 
                                                                   TextColor="black" FontSize="8" FontAttributes="Bold"/>
                                                                    </Frame>

                                                                </StackLayout>

                                                                <Label Text="{Binding Duration}" FontSize="14" TranslationY="-5"/>

                                                                <CollectionView ItemsSource="{Binding Genre}" HeightRequest="30">
                                                                    <CollectionView.ItemsLayout>
                                                                        <GridItemsLayout Orientation="Horizontal" Span="1" HorizontalItemSpacing="5"/>
                                                                    </CollectionView.ItemsLayout>
                                                                    <CollectionView.ItemTemplate>
                                                                        <DataTemplate>
                                                                            <StackLayout>
                                                                                <Frame BackgroundColor="White" CornerRadius="10" Padding="10,5">
                                                                                    <Label Text="{Binding}" FontSize="12"/>
                                                                                </Frame>
                                                                            </StackLayout>
                                                                        </DataTemplate>
                                                                    </CollectionView.ItemTemplate>
                                                                </CollectionView>



                                                                <Label Text="{Binding Director}"
                                                                   TextColor="Black" 
                                                                   FontSize="14" FontAttributes="Bold"/>

                                                                <Label Text="{Binding Description}" LineBreakMode="TailTruncation" MaxLines="2"/>

                                                            </StackLayout>
                                                        </AbsoluteLayout>

                                                        <StackLayout.GestureRecognizers>
                                                            <TapGestureRecognizer Tapped="MovieHot2" CommandParameter="{Binding MovieID}"/>
                                                        </StackLayout.GestureRecognizers>

                                                    </StackLayout>

                                                    <BoxView BackgroundColor="LightGray" HeightRequest="1" HorizontalOptions="FillAndExpand"/>

                                                </StackLayout>

                                            </DataTemplate>
                                        </CollectionView.ItemTemplate>
                                    </CollectionView>

                                </StackLayout>


                            </StackLayout>
                        </ScrollView>

                    </StackLayout>
                </tabView:SfTabItem.Content>
            </tabView:SfTabItem>

            <tabView:SfTabItem Title="Actor" ImageSource="actorIcon" SelectionColor="#000000" TitleFontColor="#a3a0a0">
                <tabView:SfTabItem.Content>
                    <ScrollView BackgroundColor="#ECECEC">
                        <StackLayout Padding="0,20,0,0"
                                         HorizontalOptions="FillAndExpand" VerticalOptions="FillAndExpand">

                            <StackLayout Margin="0" BindingContext="{StaticResource UserVM}">

                                <CollectionView ItemsSource="{Binding ActorAvatar}" Margin="10,0,10,0">
                                    <CollectionView.ItemsLayout>
                                        <GridItemsLayout Orientation="Vertical"
                                                         Span="4"
                                                         HorizontalItemSpacing="10"
                                                         VerticalItemSpacing="10"/>
                                    </CollectionView.ItemsLayout>
                                    <CollectionView.ItemTemplate>
                                        <DataTemplate>

                                            <StackLayout>
                                                <StackLayout Padding="0,10,0,10">

                                                    <Frame AbsoluteLayout.LayoutFlags="All" AbsoluteLayout.LayoutBounds="0,0,1,1" 
                                                               Padding="0" CornerRadius="100" HeightRequest="80"  WidthRequest="80"
                                                               HorizontalOptions="StartAndExpand">
                                                        <AbsoluteLayout>
                                                            <Image Source="{Binding ActorImage}" Aspect="AspectFill"
                                                                       AbsoluteLayout.LayoutFlags="All"
                                                                       AbsoluteLayout.LayoutBounds="0,0,1,1"></Image>
                                                        </AbsoluteLayout>
                                                    </Frame>

                                                    <Label Text="{Binding ActorName}" HorizontalTextAlignment="Center" FontAttributes="Bold"/>



                                                </StackLayout>


                                                <StackLayout.GestureRecognizers>
                                                    <TapGestureRecognizer CommandParameter="{Binding ActorID}" Tapped="MoveActorMovie"/>
                                                </StackLayout.GestureRecognizers>

                                            </StackLayout>

                                        </DataTemplate>
                                    </CollectionView.ItemTemplate>
                                </CollectionView>

                            </StackLayout>


                        </StackLayout>
                    </ScrollView>

                </tabView:SfTabItem.Content>
            </tabView:SfTabItem>

            <tabView:SfTabItem Title="User" ImageSource="userIcon" SelectionColor="#000000" TitleFontColor="#a3a0a0">
                <tabView:SfTabItem.Content>
                    <StackLayout BackgroundColor="#ECECEC" BindingContext="{StaticResource UserVM}">

                        <Frame Padding="0" CornerRadius="0" HeightRequest="220">
                            <AbsoluteLayout>
                                <Image Source="background" Aspect="AspectFill"
                                                           AbsoluteLayout.LayoutFlags="All"
                                                           AbsoluteLayout.LayoutBounds="0,0,1,1"></Image>

                                <StackLayout  AbsoluteLayout.LayoutFlags="All"
                                              AbsoluteLayout.LayoutBounds="0,0,1,1" Padding="10">

                                    <StackLayout VerticalOptions="CenterAndExpand" HorizontalOptions="CenterAndExpand">
                                        <abstractions:CircleImage Aspect="AspectFill"
                                                  WidthRequest="80"
                                                  HeightRequest="80"
                                                  HorizontalOptions="CenterAndExpand"
                                                  Source="{Binding UserAvatar}">

                                        </abstractions:CircleImage>

                                        <StackLayout HorizontalOptions="CenterAndExpand" Margin="0,10,0,0">
                                            <Label Text="{Binding UserFullname}" FontAttributes="Bold" TextColor="Black"
                                                   HorizontalTextAlignment="Center" FontSize="18"/>
                                            <Label Text="{Binding UserEmail}"
                                                   TextColor="Black" HorizontalTextAlignment="Center"/>
                                        </StackLayout>
                                    </StackLayout>

                                </StackLayout>
                            </AbsoluteLayout>

                        </Frame>

                        <StackLayout>

                            <Grid Margin="20,15,20,15" >
                                <Grid.RowDefinitions>
                                    <RowDefinition Height="*"/>
                                </Grid.RowDefinitions>
                                <Grid.ColumnDefinitions>
                                    <ColumnDefinition Width="*"/>
                                    <ColumnDefinition Width="*"/>
                                </Grid.ColumnDefinitions>


                                <StackLayout Grid.Row="0" Grid.Column="0"
                                                         VerticalOptions="CenterAndExpand">
                                    <Label Text="Issue Tickets" FontSize="14"
                                                       VerticalTextAlignment="Center"
                                                       TextColor="#404040">

                                    </Label>
                                </StackLayout>

                                <StackLayout Grid.Row="0" Grid.Column="1" HorizontalOptions="EndAndExpand">
                                    <Image Source="iconsarrowright"
                                                       Aspect="AspectFill"
                                                       HorizontalOptions="CenterAndExpand"
                                                       VerticalOptions="CenterAndExpand"
                                                       WidthRequest="20"></Image>
                                </StackLayout>

                                <Grid.GestureRecognizers>
                                    <TapGestureRecognizer Tapped="Ticket"/>
                                </Grid.GestureRecognizers>

                            </Grid>

                            <BoxView Margin="10,0,10,0" BackgroundColor="LightGray" HeightRequest="1" HorizontalOptions="FillAndExpand"/>

                            <Grid Margin="20,15,20,15">
                                <Grid.RowDefinitions>
                                    <RowDefinition Height="*"/>
                                </Grid.RowDefinitions>
                                <Grid.ColumnDefinitions>
                                    <ColumnDefinition Width="*"/>
                                    <ColumnDefinition Width="*"/>
                                </Grid.ColumnDefinitions>


                                <StackLayout Grid.Row="0" Grid.Column="0"
                                                         VerticalOptions="CenterAndExpand">
                                    <Label Text="Sign Out" FontSize="14"
                                                       VerticalTextAlignment="Center"
                                                       TextColor="#404040"></Label>
                                </StackLayout>

                                <StackLayout Grid.Row="0" Grid.Column="1" HorizontalOptions="EndAndExpand">
                                    <Image Source="iconsarrowright"
                                                       Aspect="AspectFill"
                                                       HorizontalOptions="CenterAndExpand"
                                                       VerticalOptions="CenterAndExpand"
                                                       WidthRequest="20"></Image>
                                </StackLayout>

                                <Grid.GestureRecognizers>
                                    <TapGestureRecognizer Tapped="Signout"/>
                                </Grid.GestureRecognizers>

                            </Grid>

                        </StackLayout>

                    </StackLayout>
                </tabView:SfTabItem.Content>
            </tabView:SfTabItem>

        </tabView:SfTabView>

    </ContentPage.Content>
</ContentPage>
```

**Back End**

```c#
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;
using Cinema.API;
using Cinema.Models;
using Cinema.PopupPage;
using Cinema.ViewModel;
using OneSignalSDK.Xamarin;
using Rg.Plugins.Popup.Services;
using Xamarin.Essentials;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace Cinema.View
{
	[XamlCompilation(XamlCompilationOptions.Compile)]
	public partial class HomePage : ContentPage
	{
        // 引入 VM
		public static UserVM us = new UserVM();

		public HomePage()
		{
			InitializeComponent();
		}

        // 通常用于初始化数据或更新 UI
        // OnAppearing 方法在页面即将显示时被调用
		protected override void OnAppearing()
		{
			base.OnAppearing();

			UserDB userdbdata = new UserDB();
            
            // Api
			var one_user = userdbdata.GetAllUser_One();
            
			if (one_user.OneSignalOpen == true)
			{
                // 更换 Icon
				notificationimg.Source = "NotificationIcon";
			}
			else
			{
                // 更换 Icon
				notificationimg.Source = "NoNotificationIcon";
			}

            // 固定 List
			List<Movie> MovieListData = new List<Movie>()
			{
				new Movie(){Title = "Action",Genre = "#cf1d46",Duration="#ffffff"},
				new Movie(){Title = "Horror",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Love",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Thriller",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Comedy",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Sci-Fi",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "War",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Crime",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Adventure",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Disaster",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Drama",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Classic",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Homosexual",Genre = "#f0eded",Duration="#9e9e9e"},
			};
			
            // 调用 List
			PromotionList.ItemsSource = MovieListData;

            // 调用 VM public static 方法 获取 数据
			MediaList.ItemsSource = UserVM.MovieList.Where(x => x.Genre.Contains("Action")).Take(6).ToList();
			int count = UserVM.MovieList.Where(x => x.Genre.Contains("Action")).Take(6).ToList().Count;
			MediaList_SizeChanged(count);

            // 调用 VM public static 方法 获取 数据
			var allMovie = UserVM.MovieList.Where(x => x.Genre.Contains("Action")).ToList();

            // 创建 空 List
			List<string[]> list_inter = new List<string[]>();

            // 将 数据 保存 在 List
			foreach (var i in allMovie)
			{
				string[] str = i.Genre.Split(new char[] { '|' }, StringSplitOptions.RemoveEmptyEntries);
				list_inter.Add(str);
			}

			int num_inter = 0;

            // 使用 LINQ 方法
			var db = (from c in allMovie
					  select new
					  {
						  MovieID = c.MovieID,
						  list_inter = list_inter,
						  Genre = list_inter[num_inter++],
						  Title = c.Title,
						  Duration = c.Duration,
						  MovieTrailerLink = c.MovieTrailerLink,
						  MoviePoster = c.MoviePoster,
						  RatingStar = c.RatingStar,
						  Description = c.Description,
						  Director = c.Director,
					  }).ToList();

            // 赋予 前端 数据
			PromotionList2.ItemsSource = MovieListData;
            // 赋予 前端 数据
			MediaList2.ItemsSource = db;
		}

		private void MediaList_SizeChanged(int numberOfItems)
		{
			double collectionViewWidth = MediaList.Width;

			double itemWidth = (collectionViewWidth - (2 * 6)) / 2;

			double rows = Math.Ceiling((double)numberOfItems / 2);
			double collectionViewHeight = (itemWidth * rows) + (rows - 1) * 22;

			double additionalHeight = 50;
			collectionViewHeight += additionalHeight;

			MediaList.HeightRequest = collectionViewHeight;
		}

		private async void Follow(object sender, EventArgs e)
		{
			await ((StackLayout)sender).ScaleTo(0.9, 10, Easing.Linear);
			await Task.Delay(10);
			await ((StackLayout)sender).ScaleTo(1, 10, Easing.Linear);

			var Element = sender as StackLayout;
			var value = Element.GestureRecognizers[0] as TapGestureRecognizer;

			var data = value.CommandParameter.ToString();

			List<Movie> moviedataGrene = new List<Movie>()
			{
				new Movie(){Title = "Action",Genre = "#cf1d46",Duration="#ffffff"},
				new Movie(){Title = "Horror",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Love",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Thriller",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Comedy",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Sci-Fi",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "War",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Crime",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Adventure",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Disaster",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Drama",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Classic",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Homosexual",Genre = "#f0eded",Duration="#9e9e9e"},
			};

			List<Movie> NewmoviedataGrene = new List<Movie>();

			foreach (var i in moviedataGrene)
			{
				if (data == i.Title)
				{
					i.Duration = "#ffffff";
					i.Genre = "#cf1d46";
				}
				else
				{
					i.Duration = "#9e9e9e";
					i.Genre = "#f0eded";
				}
				NewmoviedataGrene.Add(i);
			}

			PromotionList.ItemsSource = NewmoviedataGrene;

			MediaList.ItemsSource = UserVM.MovieList.Where(x => x.Genre.Contains(data)).Take(6).ToList();
			int count = UserVM.MovieList.Where(x => x.Genre.Contains(data)).Take(6).ToList().Count;
			MediaList_SizeChanged(count);
		}

		private async void OpenTenu(object sender, EventArgs e)
		{
			await ((Frame)sender).ScaleTo(0.9, 10, Easing.Linear);
			await Task.Delay(10);
			await ((Frame)sender).ScaleTo(1, 10, Easing.Linear);

			PopupNavigation.PushAsync(new OpenTenuPopup());
		}

		private async void NotificationOpen(object sender, EventArgs e)
		{
			await ((Frame)sender).ScaleTo(0.9, 10, Easing.Linear);
			await Task.Delay(10);
			await ((Frame)sender).ScaleTo(1, 10, Easing.Linear);

			UserDB userdata_check = new UserDB();
			var usernotification = userdata_check.GetAllUser_One();
			if (usernotification.OneSignalOpen == true)
			{
				usernotification.OneSignalOpen = false;
			}
			else
			{
				usernotification.OneSignalOpen = true;
			}
			await userdata_check.EditUser(usernotification);

			if (usernotification.OneSignalOpen == true)
			{
				notificationimg.Source = "NotificationIcon";
			}
			else
			{
				notificationimg.Source = "NoNotificationIcon";
			}
		}

		private async void Follow2(object sender, EventArgs e)
		{
			await ((StackLayout)sender).ScaleTo(0.9, 10, Easing.Linear);
			await Task.Delay(10);
			await ((StackLayout)sender).ScaleTo(1, 10, Easing.Linear);

			var Element = sender as StackLayout;
			var value = Element.GestureRecognizers[0] as TapGestureRecognizer;

			var data = value.CommandParameter.ToString();

			List<Movie> moviedataGrene = new List<Movie>()
			{
				new Movie(){Title = "Action",Genre = "#cf1d46",Duration="#ffffff"},
				new Movie(){Title = "Horror",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Love",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Thriller",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Comedy",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Sci-Fi",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "War",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Crime",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Adventure",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Disaster",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Drama",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Classic",Genre = "#f0eded",Duration="#9e9e9e"},
				new Movie(){Title = "Homosexual",Genre = "#f0eded",Duration="#9e9e9e"},
			};

			List<Movie> NewmoviedataGrene = new List<Movie>();

			foreach (var i in moviedataGrene)
			{
				if (data == i.Title)
				{
					i.Duration = "#ffffff";
					i.Genre = "#cf1d46";
				}
				else
				{
					i.Duration = "#9e9e9e";
					i.Genre = "#f0eded";
				}
				NewmoviedataGrene.Add(i);
			}

			var allMovie = UserVM.MovieList.Where(x => x.Genre.Contains(data)).ToList();

			List<string[]> list_inter = new List<string[]>();

			foreach (var i in allMovie)
			{
				string[] str = i.Genre.Split(new char[] { '|' }, StringSplitOptions.RemoveEmptyEntries);
				list_inter.Add(str);
			}

			int num_inter = 0;

			var db = (from c in allMovie
					  where c.Genre.Contains(data)
					  select new
					  {
						  MovieID = c.MovieID,
						  list_inter = list_inter,
						  Genre = list_inter[num_inter++],
						  Title = c.Title,
						  Duration = c.Duration,
						  MovieTrailerLink = c.MovieTrailerLink,
						  MoviePoster = c.MoviePoster,
						  RatingStar = c.RatingStar,
						  Description = c.Description,
						  Director = c.Director,
					  }).ToList();

			PromotionList2.ItemsSource = NewmoviedataGrene;
			MediaList2.ItemsSource = db;
		}

		private async void MovieHot(object sender, EventArgs e)
		{
			await ((Frame)sender).ScaleTo(0.9, 10, Easing.Linear);
			await Task.Delay(10);
			await ((Frame)sender).ScaleTo(1, 10, Easing.Linear);

			var Element = sender as Frame;
			var value = Element.GestureRecognizers[0] as TapGestureRecognizer;

			var data = value.CommandParameter.ToString();

			Navigation.PushAsync(new MovieDetailPage(Convert.ToInt32(data)));
		}

		private async void MovieHot2(object sender, EventArgs e)
		{
			await ((StackLayout)sender).ScaleTo(0.9, 10, Easing.Linear);
			await Task.Delay(10);
			await ((StackLayout)sender).ScaleTo(1, 10, Easing.Linear);

			var Element = sender as StackLayout;
			var value = Element.GestureRecognizers[0] as TapGestureRecognizer;

			var data = value.CommandParameter.ToString();

			Navigation.PushAsync(new MovieDetailPage(Convert.ToInt32(data)));
		}

		private async void Ticket(object sender, EventArgs e)
		{
			await ((Grid)sender).ScaleTo(0.9, 10, Easing.Linear);
			await Task.Delay(10);
			await ((Grid)sender).ScaleTo(1, 10, Easing.Linear);

			Navigation.PushAsync(new TransferPage());
		}

		private async void Signout(object sender, EventArgs e)
		{
			await ((Grid)sender).ScaleTo(0.9, 10, Easing.Linear);
			await Task.Delay(10);
			await ((Grid)sender).ScaleTo(1, 10, Easing.Linear);

			Preferences.Set("Username", "");
			Preferences.Set("Password", "");
			UserDB.userID = 0;

			Navigation.PopToRootAsync();
		}

		private async void MoveActorMovie(object sender, EventArgs e)
		{
			await ((StackLayout)sender).ScaleTo(0.9, 10, Easing.Linear);
			await Task.Delay(10);
			await ((StackLayout)sender).ScaleTo(1, 10, Easing.Linear);

			var Element = sender as StackLayout;
			var value = Element.GestureRecognizers[0] as TapGestureRecognizer;

			var data = value.CommandParameter.ToString();

			ActorDB ac = new ActorDB();
			var dataall = ac.GetAllActor_User();
			var dataFirst = dataall.Where(x => x.ActorID == Convert.ToInt32(data)).FirstOrDefault();
			Navigation.PushAsync(new ActorMoviePage(dataFirst));
		}

		private async void MoveSearch(object sender, EventArgs e)
		{
			await ((Image)sender).ScaleTo(0.9, 30, Easing.Linear);
			await Task.Delay(10);
			await ((Image)sender).ScaleTo(1, 30, Easing.Linear);

			if (Search.Text == "")
			{
				SearchName.ErrorColor = Color.Red;
				SearchName.ErrorText = "This Movie has not been found";
				SearchName.HasError = true;
			}
			else
			{
				MovieDB moviedb = new MovieDB();
				var movie = moviedb.GetAllMovie();
				var datafind = movie.Where(x => x.Title.Contains(Search.Text)).FirstOrDefault();
				if (datafind != null)
				{
					Navigation.PushAsync(new MovieDetailPage(datafind.MovieID));
				}
				else
				{
					SearchName.ErrorColor = Color.Red;
					SearchName.ErrorText = "This song has not been found";
					SearchName.HasError = true;
				}
			}
		}

		private void Handle_Completed(object sender, EventArgs e)
		{
			if (Search.Text == "")
			{
				SearchName.ErrorColor = Color.Red;
				SearchName.ErrorText = "This Movie has not been found";
				SearchName.HasError = true;
			}
			else
			{
				MovieDB moviedb = new MovieDB();
				var movie = moviedb.GetAllMovie();
				var datafind = movie.Where(x => x.Title.Contains(Search.Text)).FirstOrDefault();
				if (datafind != null)
				{
					Navigation.PushAsync(new MovieDetailPage(datafind.MovieID));
				}
				else
				{
					SearchName.ErrorColor = Color.Red;
					SearchName.ErrorText = "This song has not been found";
					SearchName.HasError = true;
				}
			}
		}

		private void OnAutoCompleteItemSelected(object sender, Syncfusion.SfAutoComplete.XForms.SelectionChangedEventArgs e)
		{
			if (Search.Text != "")
			{
				MovieDB moviedb = new MovieDB();
				var movie = moviedb.GetAllMovie();
				var datafind = movie.Where(x => x.Title.Contains(Search.Text)).FirstOrDefault();
				if (datafind != null)
				{
					SearchName.ErrorText = "";
					SearchName.HasError = false;
					Navigation.PushAsync(new MovieDetailPage(datafind.MovieID));
				}
				else
				{
					SearchName.ErrorColor = Color.Red;
					SearchName.ErrorText = "This song has not been found";
					SearchName.HasError = true;
				}
			}
		}
	}
}
```



##### 学习

**配置 Navigation**

```xml
NavigationPage.HasNavigationBar="False"
```



###### TabView

如果是 Home Page，下面有 tabview 设计

```
xmlns:tabView="clr-namespace:Syncfusion.XForms.TabView;assembly=Syncfusion.SfTabView.XForms"
```

```xml
<ContentPage.Content>

        <tabView:SfTabView BackgroundColor="#f2f2f2"  EnableSwiping="False"
                           TabHeaderPosition="Bottom" DisplayMode="Image"
                           VisibleHeaderCount="4">

            <tabView:SfTabView.SelectionIndicatorSettings>
                <tabView:SelectionIndicatorSettings Color="Transparent" Position="Fill" StrokeThickness="0"
                                                    AnimationDuration="10"/>
            </tabView:SfTabView.SelectionIndicatorSettings>

            <!-- 第 1 -->
            <tabView:SfTabItem Title="Home"  ImageSource="homeIcon" SelectionColor="#000000" TitleFontColor="#666666">
                <tabView:SfTabItem.Content>
                    <ScrollView BackgroundColor="#ECECEC">
                        <StackLayout Padding="0,20,0,0"
                         HorizontalOptions="FillAndExpand" VerticalOptions="FillAndExpand" BindingContext="{StaticResource UserVM}">

                        </StackLayout>
                    </ScrollView>
                </tabView:SfTabItem.Content>
            </tabView:SfTabItem>

            <!-- 第 2 -->
            <tabView:SfTabItem Title="Movie" ImageSource="movieIcon" SelectionColor="#000000" TitleFontColor="#a3a0a0">
                <tabView:SfTabItem.Content>
                    <StackLayout BackgroundColor="#ECECEC">
                        <StackLayout HorizontalOptions="FillAndExpand"
                                     
                        </StackLayout>
                    </ScrollView>
                </tabView:SfTabItem.Content>
            </tabView:SfTabItem>
            
            <!-- 第 3 -->
            <tabView:SfTabItem Title="Actor" ImageSource="userIcon" SelectionColor="#000000" TitleFontColor="#a3a0a0">
                <tabView:SfTabItem.Content>
                    <StackLayout BackgroundColor="#ECECEC" BindingContext="{StaticResource UserVM}">

                    </StackLayout>
                </tabView:SfTabItem.Content>
            </tabView:SfTabItem>

            <!-- 第 4 -->
            <tabView:SfTabItem Title="User" ImageSource="userIcon" SelectionColor="#000000" TitleFontColor="#a3a0a0">
                <tabView:SfTabItem.Content>
                    <StackLayout BackgroundColor="#ECECEC" BindingContext="{StaticResource UserVM}">

                    </StackLayout>
                </tabView:SfTabItem.Content>
            </tabView:SfTabItem>

        </tabView:SfTabView>
    </ContentPage.Content>
```



###### Frame

**边框**: `Frame` 可以定义边框的颜色和厚度，帮助视觉上区分内容。

**阴影**: 可以添加阴影效果，使 `Frame` 看起来浮动在其他内容之上，增强立体感。

**圆角**: 可以设置边角为圆角，使界面更加柔和。

```xml
<Frame Padding="10"
       BackgroundColor="White"
       BorderColor="Gray"
       CornerRadius="5"
       HasShadow="True">
    <StackLayout>
        <Label Text="Hello, World!"
               FontSize="20"
               HorizontalOptions="Center" />
        <Button Text="Click Me"
                HorizontalOptions="Center" />
    </StackLayout>
</Frame>
```

```xml
<Frame CornerRadius="100" HasShadow="True" HeightRequest="32" WidthRequest="32"
       BackgroundColor="Black" Padding="5" Margin="12,11,0,0">
    <Image Source="tuneIcon" HeightRequest="10" WidthRequest="10"/>
    <Frame.GestureRecognizers>
        <TapGestureRecognizer Tapped="OpenTenu"/>
    </Frame.GestureRecognizers>
</Frame>
```

```c#
private void OpenTenu(object sender, EventArgs e)
{
    // 处理点击事件的逻辑，例如打开菜单
}
```



###### CollectionView

显示一个垂直列表

**Orientation="Vertical"**:

- 该属性设置项目的排列方向为垂直。即所有项目将从上到下排列。

**Span="4"**:

- 此属性指定每行显示的项目数量。在这个例子中，每行将展示 4 个项目。当项目的总数超过 4 时，它们将自动换行到下一行。

**HorizontalItemSpacing="10"**:

- 该属性定义项目之间的水平间距。在此示例中，项目之间的水平间距设置为 10 个单位（通常是像素或设备独立单位）。这意味着每个项目之间将留有 10 单位的空隙。

**VerticalItemSpacing="10"**:

- 该属性定义项目之间的垂直间距。与 `HorizontalItemSpacing` 类似，此属性设置了项目之间的垂直间距，同样为 10 单位。这使得每行之间的项目也会有 10 单位的空隙。

`MVVM 版本`

```xml
<CollectionView ItemsSource="{Binding ActorAvatar}" Margin="10,0,10,0">
    
                                    <CollectionView.ItemsLayout>
                                        <!-- 一行 4个 -->
                                        <GridItemsLayout Orientation="Vertical"
                                                         Span="4"
                                                         HorizontalItemSpacing="10"
                                                         VerticalItemSpacing="10"/>
                                    </CollectionView.ItemsLayout>
    
                                    <CollectionView.ItemTemplate>
                                        <DataTemplate>

                                            <StackLayout>
                                                <StackLayout Padding="0,10,0,10">

                                                    <Frame AbsoluteLayout.LayoutFlags="All" AbsoluteLayout.LayoutBounds="0,0,1,1" 
                                                               Padding="0" CornerRadius="100" HeightRequest="80"  WidthRequest="80"
                                                               HorizontalOptions="StartAndExpand">
                                                        <AbsoluteLayout>
                                                            <Image Source="{Binding ActorImage}" Aspect="AspectFill"
                                                                       AbsoluteLayout.LayoutFlags="All"
                                                                       AbsoluteLayout.LayoutBounds="0,0,1,1"></Image>
                                                        </AbsoluteLayout>
                                                    </Frame>

                                                    <Label Text="{Binding ActorName}" HorizontalTextAlignment="Center" FontAttributes="Bold"/>



                                                </StackLayout>


                                                <StackLayout.GestureRecognizers>
                                                    <TapGestureRecognizer CommandParameter="{Binding ActorID}" Tapped="MoveActorMovie"/>
                                                </StackLayout.GestureRecognizers>

                                            </StackLayout>

                                        </DataTemplate>
                                    </CollectionView.ItemTemplate>
                                </CollectionView>
```

`普通 版本`

```xml
<CollectionView ItemsLayout="HorizontalList"
                                        x:Name="PromotionList"
                                        HeightRequest="250"
                                        HorizontalScrollBarVisibility="Never"
                                        VerticalOptions="Start">
                                    <CollectionView.ItemTemplate>
                                        <DataTemplate>

                                            <StackLayout Padding="10">
                                                <Frame HasShadow="True"
                                                       BackgroundColor="{Binding Genre}"
                                                       Padding="25,10"
                                                       CornerRadius="100"
                                                       BorderColor="LightGray">
                                                    <Label Text="{Binding Title}" FontAttributes="Bold"
                                                           TextColor="{Binding Duration}"/>
                                                </Frame>

                                                <StackLayout.GestureRecognizers>
                                                    <TapGestureRecognizer CommandParameter="{Binding Title}" Tapped="Follow"/>
                                                </StackLayout.GestureRecognizers>
                                            </StackLayout>


                                        </DataTemplate>
                                    </CollectionView.ItemTemplate>

                                </CollectionView>
```



###### Grid

```xml
<Grid Padding="0,0,10,0">
                                <Grid.RowDefinitions>
                                    <RowDefinition Height="*"/>
                                    <RowDefinition Height="*"/>
                                </Grid.RowDefinitions>
                                <Grid.ColumnDefinitions>
                                    <ColumnDefinition Width="*"/>
                                    <ColumnDefinition Width="3*"/>
                                    <ColumnDefinition Width="0.6*"/>
                                </Grid.ColumnDefinitions>
    
    
</Grid>
```

```xml
Grid.Row="1" Grid.Column="1" Grid.RowSpan="2"
```



###### StackLayout

```xml
<StackLayout Orientation="Horizontal" Padding="20,0,10,0" Margin="0,10,0,0">
```



###### Image

```xml
<Image Source="{Binding HotMovie[1].MoviePoster}" Aspect="AspectFill"
                                       AbsoluteLayout.LayoutFlags="All"
                                       AbsoluteLayout.LayoutBounds="0,0,1,1"></Image>
```



###### AbsoluteLayout

```xml
<AbsoluteLayout>
      <Image Source="{Binding HotMovie[0].MoviePoster}" Aspect="AspectFill"
             AbsoluteLayout.LayoutFlags="All"
             AbsoluteLayout.LayoutBounds="0,0,1,1"></Image>

</AbsoluteLayout>
```



###### Label

```xml
 <Label Text="{Binding Title}" TextColor="black" 
        FontSize="17" FontAttributes="Bold" VerticalTextAlignment="Center"/>
```



###### BoxView

```xml
<BoxView BackgroundColor="LightGray" HeightRequest="1" HorizontalOptions="FillAndExpand"/>
```

```xml
<BoxView BackgroundColor="Black"
                     AbsoluteLayout.LayoutFlags="All"
                     AbsoluteLayout.LayoutBounds="0,0,1,1"
                     Opacity="0.5"
                     x:Name="Boxblack"
                     IsVisible="false"
></BoxView>
```



###### ScrollView

```xml
 <ScrollView BackgroundColor="#ECECEC">
     <StackLayout Padding="0,20,0,0"
                  HorizontalOptions="FillAndExpand" VerticalOptions="FillAndExpand" 
                  BindingContext="{StaticResource UserVM}">

      </StackLayout>
</ScrollView>
```



###### abstractions:CircleImage

```xml
<abstractions:CircleImage Aspect="AspectFill"
                          WidthRequest="80"
                          HeightRequest="80"
                          HorizontalOptions="CenterAndExpand"
                          Source="{Binding UserAvatar}"/>
```



###### Entry

```
<Entry TextColor="Black" Text="{Binding Email}"/>
```



#### PopUpPage

使用 例子

**Front End**

```xml
<?xml version="1.0" encoding="utf-8" ?>
<pages:PopupPage  xmlns:pages="http://rotorgames.com" xmlns="http://xamarin.com/schemas/2014/forms"
             xmlns:x="http://schemas.microsoft.com/winfx/2009/xaml"
                  xmlns:pancakeview="clr-namespace:Xamarin.Forms.PancakeView;assembly=Xamarin.Forms.PancakeView" xmlns:inputLayout="clr-namespace:Syncfusion.XForms.TextInputLayout;assembly=Syncfusion.Core.XForms" xmlns:button="clr-namespace:Syncfusion.XForms.Buttons;assembly=Syncfusion.Buttons.XForms"
                  x:Class="Cinema.PopupPage.SignupPopup"
                  xmlns:vm="clr-namespace:Cinema.ViewModel">

    <pages:PopupPage.Animation>
        <pages:MoveAnimation DurationIn="500"
                              DurationOut="500"
                              EasingIn="SpringIn"
                              EasingOut="SpringOut"
                              HasBackgroundAnimation="True"
                              PositionIn="Bottom"
                              PositionOut="Bottom">

        </pages:MoveAnimation>
    </pages:PopupPage.Animation>

    <ScrollView>
        <AbsoluteLayout x:Name="ds">

            <StackLayout AbsoluteLayout.LayoutFlags="All"
                     AbsoluteLayout.LayoutBounds="0,1,1,0.83">

                <pancakeview:PancakeView BackgroundColor="white"
               CornerRadius="10,10,0,0" VerticalOptions="FillAndExpand"
               WidthRequest="300" Padding="20"
               HorizontalOptions="FillAndExpand">

                    <StackLayout>

                        <Label Text="SIGN UP" FontAttributes="Bold"
                           HorizontalOptions="CenterAndExpand" FontSize="20"
                           Margin="0,0,0,10"/>

                        <inputLayout:SfTextInputLayout
                                    Hint="FUll Name"
                                    ContainerType="Outlined"
                                    LeadingViewPosition="Inside"
                                    OutlineCornerRadius="10"
                                >
                            <Entry TextColor="Black" Text="{Binding FullName}"/>
                            <inputLayout:SfTextInputLayout.LeadingView>
                                <Image Source="iconsuser"   HeightRequest="23" WidthRequest="37" />
                            </inputLayout:SfTextInputLayout.LeadingView>
                        </inputLayout:SfTextInputLayout>

                        <inputLayout:SfTextInputLayout
                                    Hint="User ID"
                                    ContainerType="Outlined"
                                    LeadingViewPosition="Inside"
                                    OutlineCornerRadius="10"
                                >
                            <Entry TextColor="Black" Text="{Binding UserName}"/>
                            <inputLayout:SfTextInputLayout.LeadingView>
                                <Image Source="iconsuser"   HeightRequest="23" WidthRequest="37" />
                            </inputLayout:SfTextInputLayout.LeadingView>
                        </inputLayout:SfTextInputLayout>

                        <inputLayout:SfTextInputLayout
                                    Hint="Password"
                                    ContainerType="Outlined"
                                    LeadingViewPosition="Inside"
                                    OutlineCornerRadius="10"
                                    EnablePasswordVisibilityToggle="true"
                                Margin="0" Padding="0"
                                >
                            <Entry TextColor="Black" Margin="0" Text="{Binding Password}"/>
                            <inputLayout:SfTextInputLayout.LeadingView>
                                <Image Source="iconspassword" HeightRequest="35" WidthRequest="35"/>
                            </inputLayout:SfTextInputLayout.LeadingView>
                        </inputLayout:SfTextInputLayout>

                        <inputLayout:SfTextInputLayout
                                    Hint="Phone Number"
                                    ContainerType="Outlined"
                                    LeadingViewPosition="Inside"
                                    OutlineCornerRadius="10"
                                >
                            <Entry TextColor="Black" Text="{Binding Phone}"/>
                            <inputLayout:SfTextInputLayout.LeadingView>
                                <Image Source="phoneIcon"   HeightRequest="23" WidthRequest="37" />
                            </inputLayout:SfTextInputLayout.LeadingView>
                        </inputLayout:SfTextInputLayout>

                        <inputLayout:SfTextInputLayout
                                    Hint="Email"
                                    ContainerType="Outlined"
                                    LeadingViewPosition="Inside"
                                    OutlineCornerRadius="10"
                                >
                            <Entry TextColor="Black" Text="{Binding Email}"/>
                            <inputLayout:SfTextInputLayout.LeadingView>
                                <Image Source="emailIcon"   HeightRequest="23" WidthRequest="37" />
                            </inputLayout:SfTextInputLayout.LeadingView>
                        </inputLayout:SfTextInputLayout>
                        <button:SfButton Text="Sign Up" CornerRadius="10" HeightRequest="50" 
                                             BackgroundColor="#E14545" FontAttributes="Bold"
                                                 Margin="0,15,0,0"
                                            Clicked="SfButton_Clicked">
                        </button:SfButton>

                        <button:SfButton Text="Cancel" CornerRadius="10" HeightRequest="50" 
                                             BackgroundColor="LightGray" FontAttributes="Bold"
                                                 Margin="0,5,0,0" TextColor="Black"
                                     Clicked="Button_Clicked">
                        </button:SfButton>
                    </StackLayout>

                </pancakeview:PancakeView>

            </StackLayout>

            <BoxView BackgroundColor="Black"
                     AbsoluteLayout.LayoutFlags="All"
                     AbsoluteLayout.LayoutBounds="0,0,1,1"
                     Opacity="0.5"
                     x:Name="Boxblack"
                         IsVisible="false"
                     ></BoxView>

            <Image Source="Loading"
                   AbsoluteLayout.LayoutFlags="PositionProportional"
                   AbsoluteLayout.LayoutBounds="0.5,0.5,50,50"
                   Aspect="Fill"
                   IsAnimationPlaying="True"
                   x:Name="loadingpic"
                       IsVisible="false"
                   ></Image>

        </AbsoluteLayout>

    </ScrollView>

</pages:PopupPage>
```

**Back End**

```c#
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Cinema.View;
using Cinema.ViewModel;
using Rg.Plugins.Popup.Services;
using Syncfusion.XForms.Buttons;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace Cinema.PopupPage
{
	[XamlCompilation(XamlCompilationOptions.Compile)]
	public partial class SignupPopup
	{
        // 引入
		public static SignUpVM vm = new SignUpVM();
        
        // 赋予 前端
		public SignupPopup()
		{
			InitializeComponent();
			BindingContext = vm;
		}

		private async void Button_Clicked(object sender, EventArgs e)
		{
			await ((SfButton)sender).ScaleTo(0.9, 10, Easing.Linear);
			await Task.Delay(10);
			await ((SfButton)sender).ScaleTo(1, 10, Easing.Linear);

			PopupNavigation.PopAsync();
		}

		public static void PopupClose()
		{
			PopupNavigation.PopAsync();
		}

		private async void SfButton_Clicked(object sender, EventArgs e)
		{
			await ((SfButton)sender).ScaleTo(0.9, 10, Easing.Linear);
			await Task.Delay(10);
			await ((SfButton)sender).ScaleTo(1, 10, Easing.Linear);

			if (vm.UserName != null && vm.Password != null && vm.Email != null && vm.FullName != null && vm.Phone != null)
			{
				loadingpic.IsVisible = true;
				Boxblack.IsVisible = true;
				await Task.Delay(TimeSpan.FromSeconds(8));

				vm.CheckSignUp_New(vm.UserName, vm.Password, vm.Email, vm.FullName, vm.Phone);

				loadingpic.IsVisible = false;
				Boxblack.IsVisible = false;

				PopupNavigation.PopAsync();
			}
			else
			{
				await PopupNavigation.PushAsync(new SignupFailedPopup());
			}

		}
	}
}
```

**SignUpVM**

```c#
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Runtime.CompilerServices;
using System.Text;
using Cinema.API;
using Cinema.Models;
using System.Threading.Tasks;
using Xamarin.Forms;
using Cinema.PopupPage;
using Rg.Plugins.Popup.Services;
using Cinema.View;
using System.Linq;
using Xamarin.Essentials;

namespace Cinema.ViewModel
{
	public class SignUpVM : INotifyPropertyChanged
	{
		protected virtual void NotifyPropertyChanged([CallerMemberName] string propertyName = "")
		{
			PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(propertyName));
		}

		public event PropertyChangedEventHandler PropertyChanged;

		public UserDB userDB = new UserDB();


		public string username { get; set; }
		public string UserName
		{
			get { return username; }
			set
			{
				if (username != value)
				{
					username = value;
					NotifyPropertyChanged();
				}
			}
		}

		public string password { get; set; }
		public string Password
		{
			get { return password; }
			set
			{
				if (password != value)
				{
					password = value;
					NotifyPropertyChanged();
				}
			}
		}

		public string fullName { get; set; }
		public string FullName
		{
			get { return fullName; }
			set
			{
				if (fullName != value)
				{
					fullName = value;
					NotifyPropertyChanged();
				}
			}
		}

		public string email { get; set; }
		public string Email
		{
			get { return email; }
			set
			{
				if (email != value)
				{
					email = value;
					NotifyPropertyChanged();
				}
			}
		}

		public string phone { get; set; }
		public string Phone
		{
			get { return phone; }
			set
			{
				if (phone != value)
				{
					phone = value;
					NotifyPropertyChanged();
				}
			}
		}

		public Command CreateFunction { get; set; }

		public SignUpVM()
		{
			CreateFunction = new Command(async async => await GetCreate());
		}

		async Task GetCreate()
		{
			User user = new User()
			{
				Avatar = "avatar",
				Email = this.Email,
				FullName = this.FullName,
				Username = this.UserName,
				Password = this.Password,
				OneSignalOpen = true,
				Phone = this.Phone

			};

			//API Create
			await userDB.CreateUser(user);
			SignupPopup.PopupClose();
		}

		public async void CheckSignUp_New(string us, string pass, string email, string fullname, string phone)
		{
			User user = new User()
			{
				Avatar = "avatar",
				Email = email,
				FullName = fullname,
				Username = us,
				Password = pass,
				OneSignalOpen = true,
				Phone = phone

			};

			//API Create
			await userDB.CreateUser(user);
		}

	}
}
```



##### **学习**



###### PopAsync

```c#
private async void Button_Clicked(object sender, EventArgs e)
{
    await ((SfButton)sender).ScaleTo(0.9, 10, Easing.Linear); // 按钮缩小
    await Task.Delay(10); // 等待一段时间
    await ((SfButton)sender).ScaleTo(1, 10, Easing.Linear); // 按钮恢复原大小

    PopupNavigation.PopAsync(); // 关闭当前 Popup
}
```

```xml
<button:SfButton Text="Cancel" CornerRadius="10" HeightRequest="50" 
                 BackgroundColor="LightGray" FontAttributes="Bold"
                 Margin="0,5,0,0" TextColor="Black"
                 Clicked="Button_Clicked">
</button:SfButton>
```



###### **PushAsync**

```c#
// 当用户注册失败时，显示弹出窗口
await PopupNavigation.PushAsync(new SignupFailedPopup());
```



###### **格式**

```xml
<pages:PopupPage.Animation>
        <pages:MoveAnimation DurationIn="500"
                              DurationOut="500"
                              EasingIn="SpringIn"
                              EasingOut="SpringOut"
                              HasBackgroundAnimation="True"
                              PositionIn="Bottom"
                              PositionOut="Bottom">

        </pages:MoveAnimation>
    </pages:PopupPage.Animation>
```



**其他**

```c#
await PopupNavigation.PushAsync(new ForgetPasswordFailedPopup());
```





#### 按钮 效果

**跳动**

```c#
await ((SfButton)sender).ScaleTo(0.9, 10, Easing.Linear);
await Task.Delay(10);
await ((SfButton)sender).ScaleTo(1, 10, Easing.Linear);
```



#### 重定向

```c#
Navigation.PushAsync(new MovieDetailPage(datafind.MovieID));
```

```c#
public MovieDetailPage(int MovieID)
```

**Back**

```xml
<StackLayout Margin="10,5,10,10" VerticalOptions="EndAndExpand">
                        <button:SfButton Text="Back" CornerRadius="10" HeightRequest="50" 
                             BackgroundColor="LightGray" FontAttributes="Bold"  
                                 TextColor="Black" Clicked="Back">
                        </button:SfButton>
</StackLayout>
```

```c#
private async void Back(object sender, EventArgs e)
{
    await Navigation.PopAsync(); // 弹出当前页面，返回到上一个页面
}
```





#### MVVM 用法

##### 配置

当属性值发生变化时需要更新

```c#
public class UserVM : INotifyPropertyChanged
{
		protected virtual void NotifyPropertyChanged([CallerMemberName] string propertyName = "")
		{
			PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(propertyName));
		}

		public event PropertyChangedEventHandler PropertyChanged;
}
```



##### 例子

UserVM 例子

```c#
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Linq;
using System.Runtime.CompilerServices;
using System.Text;
using System.Threading.Tasks;
using Cinema.API;
using Cinema.Models;
using Cinema.View;
using Xamarin.Essentials;

namespace Cinema.ViewModel
{
	public class UserVM : INotifyPropertyChanged
	{
        // 配置
		protected virtual void NotifyPropertyChanged([CallerMemberName] string propertyName = "")
		{
			PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(propertyName));
		}

        // 配置
		public event PropertyChangedEventHandler PropertyChanged;

        // 连接 API
		public static MovieDB Moviedb = new MovieDB();
        // 获取 API 数据
		public static ObservableCollection<Movie> MovieList { get; set; } = Moviedb.GetAllMovie();

        // 获取 API 数据
		public List<Movie> HotMovie { get; set; } = MovieList.OrderByDescending(x => x.RatingStar).Take(3).ToList();
        // 获取 API 数据
		public List<string> SearName { get; set; } = MovieList.Select(x => x.Title).ToList();

        // 连接 API
		public static ActorDB Actordb = new ActorDB();
        // 获取 API 数据
		public static ObservableCollection<Actor> ActorList { get; set; } = Actordb.GetAllActor_User();
        // 获取 API 数据
		public List<Actor> ActorAvatar { get; set; } = ActorList.ToList();

        // 连接 API
		public static UserDB userDB = new UserDB();
        // 获取 API 数据
		public static User userDB_Data = userDB.GetAllUser_One();

        // 定义 MVVM 格式
		public string UserFullname { get; set; } = userDB_Data.FullName;
		public string UserAvatar { get; set; } = userDB_Data.Avatar;
		public string UserEmail { get; set; } = userDB_Data.Email;

		public static User getUserdata()
		{
			string Username = Preferences.Get("Username", string.Empty);
			string Password = Preferences.Get("Password", string.Empty);
			var userData = userDB.GetAllUser();
			var data = userData.Where(x => x.Username == Username & x.Password == Password).FirstOrDefault();
			if (data != null)
			{
				return data;
			}
			return null;
		}

	}
}
```



`LoginVM` 例子

```c#
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Runtime.CompilerServices;
using System.Text;
using System.Threading.Tasks;
using Cinema.API;
using Cinema.View;
using Xamarin.Essentials;
using Xamarin.Forms;

namespace Cinema.ViewModel
{
	public class LoginVM : INotifyPropertyChanged
	{
        // 配置
		protected virtual void NotifyPropertyChanged([CallerMemberName] string propertyName = "")
		{
			PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(propertyName));
		}

        // 配置
		public event PropertyChangedEventHandler PropertyChanged;

        // 连接 API
		public UserDB userDB = new UserDB();

        // 定义
		public string username { get; set; }
		public string Username
		{
			get { return username; }
			set
			{
				if (username != value)
				{
					username = value;
					NotifyPropertyChanged();
				}
			}
		}

        // 定义
		public string password { get; set; }
		public string Password
		{
			get { return password; }
			set
			{
				if (password != value)
				{
					password = value;
					NotifyPropertyChanged();
				}
			}
		}

        // 定义 MVVM function
		public Command LoginFunction { get; set; }

        // 配置 MVVM function
		public LoginVM()
		{
			LoginFunction = new Command(async async => await CheckLogin());
		}

        // 异步实现 MVVM function
		async Task CheckLogin()
		{
			UserDB userDB2 = new UserDB();
			var userData = userDB2.GetAllUser();
			var data = userData.Where(x => x.Username == this.Username & x.Password == this.Password).FirstOrDefault();
			if (data != null)
			{
				Preferences.Set("Username", this.Username);
				Preferences.Set("Password", this.Password);
				UserDB.userID = data.UserID;

                // 返回 首页 、登入成功
				await Application.Current.MainPage.Navigation.PushAsync(new HomePage());
			}
		}

		public bool CheckLogin_New(string us, string pass)
		{
			UserDB userDB2 = new UserDB();
			var userData = userDB2.GetAllUser();
			var data = userData.Where(x => x.Username == us & x.Password == pass).FirstOrDefault();
			if (data != null)
			{
				Preferences.Set("Username", us);
				Preferences.Set("Password", pass);
				UserDB.userID = data.UserID;
				return true;
			}
			return false;
		}

	}

}
```



##### 学习

**配置 前端 使用**

```
xmlns:vm="clr-namespace:Cinema.ViewModel"
```

```xml
<ContentPage.Resources>
        <ResourceDictionary>
            <vm:UserVM x:Key="UserVM"/>
            <vm:FunctionVM x:Key="FunctionVM"/>
        </ResourceDictionary>
</ContentPage.Resources>
```

**定义**

```xml
<ScrollView BackgroundColor="#ECECEC">
                        <StackLayout Padding="0,20,0,0"
                         HorizontalOptions="FillAndExpand" VerticalOptions="FillAndExpand" 
                         BindingContext="{StaticResource UserVM}">
    
    				   </StackLayout>      
<</ScrollView>      
```

**使用**

**头像**

```xml
<abstractions:CircleImage Aspect="AspectFit"
                                              WidthRequest="50"
                                              HeightRequest="50"
                                              HorizontalOptions="EndAndExpand"
                                              Source="{Binding UserAvatar}"
                                              Grid.Row="0"
                                              Grid.Column="0" Grid.RowSpan="2"
                                              Margin="0,0,10,0">
                                </abstractions:CircleImage>
```

**文本**

```xml
<Label Text="{Binding UserFullname}" FontAttributes="Bold"
                           Grid.Row="0" Grid.Column="1" TextColor="Black" FontSize="15"/>
```

**多数据 [0]**

```xml
<Image Source="{Binding HotMovie[0].MoviePoster}" Aspect="AspectFill"
                                       AbsoluteLayout.LayoutFlags="All"
                                       AbsoluteLayout.LayoutBounds="0,0,1,1"></Image>
```

**B 方式**

```c#
public ForgetPasswordPopup()
{
	InitializeComponent();
    // 全局 赋予
    // 只能用一个 VM
	BindingContext = vm;
}
```

```xml
<Entry TextColor="Black" Text="{Binding Email}"/>
```















