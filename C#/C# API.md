C# API

```c#
public class UserApi
	{
		//const string baseUrl = "http://localhost:5155/api/";
		//const string baseUrl = "https://hoowengchin-001-site1.itempurl.com/api/";
		const string baseUrl = "http://hoochin-001-site1.itempurl.com/api/";
		HttpClient client = new HttpClient();

		public async Task<List<User>> GetAllUser()
		{
			string jsonStr = await client.GetStringAsync(baseUrl + "User");
			return JsonConvert.DeserializeObject<List<User>>(jsonStr);
		}

		public async Task<User> FindUser(int id)
		{
			var jsonStr = await client.GetStringAsync(baseUrl + "User/" + id);
			return JsonConvert.DeserializeObject<User>(jsonStr);
		}

		public async Task EditUser(User user)
		{
			var jsonStr = new StringContent(JsonConvert.SerializeObject(user), Encoding.UTF8, "application/json");
			await client.PutAsync(baseUrl + "User/" + user.Id, jsonStr);
		}

		public async Task DeleteUser_Admin(int id)
		{
			await client.DeleteAsync(baseUrl + "User/" + id);
		}

		public async Task UserCreateDat(User user)
		{
			var jsonStr = new StringContent(JsonConvert.SerializeObject(user), Encoding.UTF8, "application/json");
			await client.PostAsync(baseUrl + "User", jsonStr);
		}
	}
```

```
var data = postwordapi.GetAllPostWord().Result;
var postword = data.Where(x => x.Id == id).FirstOrDefault();
```

