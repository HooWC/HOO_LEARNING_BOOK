## Dynamic Web Project



**番外篇！毒蛇吟来篇章！**



**Dynamic Web Project**:

- 是 Eclipse 中的一种项目类型，用于开发基于 Servlet、JSP 的简单 Java Web 应用。
- 提供了基础的 Web 结构，包括 WebContent 文件夹、`WEB-INF`、`web.xml` 等，适合开发基于 Java EE 规范的动态 Web 应用。

**Dynamic Web Project**:

- 架构简单，一般只涉及 Servlet、JSP、JavaBean。
- 适合小型或简单的 Web 应用，不需要复杂的架构或额外的库。



<u>使用 Dynamic Web Project + C# .NET API</u> 组合的项目



#### 创建 Eclipse 项目 

`File` -> `New` -> `Project` 

`Web` -> `Dynamic Web Project` -> `选择 apache-tomcat-9.0.65` -> `打勾 Generate web.xml deployment descriptor`



#### 文件目录

`java`

```
- AppDBContext
- Controller
- Models
```

`webapp`

```
- Assets
- Images
- Layout
- Other JSP File
	css
	js
	view
```

`resource`

```
放配件
```





## 开始



#### 创建 Servlet 文件

Java Resources  -> src/main/java -> controller 右键 new -> servlet



#### AppDBContext

以下是连接 `API NET` 的写法例子

`api_Admin` 例子

```java
package AppDBContext;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONObject;
import org.mindrot.jbcrypt.BCrypt;

import Models.Account;
import Models.Admin;
import Models.BankAccount;

public class api_Admin {

	public static String tokem_id = null;
	public static String token_Password = null;
	
    // 获取 Admin URL
	public static String URL()throws Exception {
		final URL url = new URL("http://localhost:5200/api/Admin/");
		return url.toString();
	}
	
    // 获取 Token
	public static void getKEY(String id , String Password) {
		tokem_id = id;
		token_Password = Password;
	}

    // 验证 Token
	public static String Token()throws Exception {
		
		URL _url = new URL("http://localhost:5200/api/AdminToken");
		
		HttpURLConnection connection = null;
		
		connection = (HttpURLConnection) _url.openConnection();
		connection.setRequestMethod("POST");
		connection.setRequestProperty("Content-Type", "application/json");
		connection.setDoOutput(true);
		JSONObject obj = new JSONObject();
		obj.put("Username", tokem_id);
		obj.put("Password", token_Password);
		
		String data = obj.toString();
		
        byte[] dataBytes = data.getBytes();
        OutputStream outputStream = connection.getOutputStream();
        outputStream.write(dataBytes);
        outputStream.close();
        
        if(connection.getResponseCode() != 400) {
        	InputStream inputStream = connection.getInputStream();
	        BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream));
	        StringBuilder result = new StringBuilder();
	        String line;
	        while ((line = reader.readLine()) != null) {
	            result.append(line);
	        }
	        
	        String Token = result.toString();
	        return Token;
		}
        
        return null;   
	}

    // 获取 所有 Admin 数据
	public static List<Admin> getAllAdmin()throws Exception{
		
		JSONObject obj = new JSONObject();
		String _url = URL();
		URL url = new URL(_url);
		HttpURLConnection connection = (HttpURLConnection)url.openConnection();
		connection.setRequestMethod("GET");
		String Token = Token();
		connection.setRequestProperty("Authorization", "Bearer " + Token);
		connection.connect();
		
		InputStream inputStream = connection.getInputStream();
		BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream));
		StringBuilder result = new StringBuilder();
		String line;
		while((line=reader.readLine()) != null) {
			result.append(line);
		}
		
		reader.close();
		JSONArray array = new JSONArray(result.toString());
		List<Admin> list = new ArrayList<>();
		for(int i = 0 ; i < array.length();i++) {
			obj = array.getJSONObject(i);
			int id = obj.getInt("adminID");
			String fullname = obj.getString("fullName");
			String img = obj.getString("img");
			String username = obj.getString("username");
			String password = obj.getString("password");

			list.add(new Admin(id,fullname,img,username,password));
		}
		
		return list;	
	}
	
    // 创建 Admin 数据
	public static void CreateAdmin(Admin admin)throws Exception {

		String _url = URL();
		URL url = new URL(_url);
		HttpURLConnection connection = (HttpURLConnection)url.openConnection();
		connection.setRequestMethod("POST");
		connection.setRequestProperty("Content-Type", "application/json");
		String Token = Token();
		connection.setRequestProperty("Authorization", "Bearer " + Token);
		connection.setDoOutput(true);
		
		JSONObject obj = new JSONObject();
		obj.put("AdminID", 0);
		obj.put("FullName", admin.getFullName());
		obj.put("IMG", admin.getIMG());
		obj.put("Username", admin.getUsername());
		obj.put("Password", admin.getPassword());
		
		String data = obj.toString();
		byte[] dataBytes = data.getBytes();
		
		OutputStream outputStream = connection.getOutputStream();
		outputStream.write(dataBytes);
		outputStream.close();
		
		if(connection.getResponseCode() == 201) {
			return;
		}else {
			return;
		}
	}
	
    // 更新 Admin 数据
	public static void UpdateAccount(Admin admin)throws Exception {
		
		String url = URL()+admin.getAdminID();
		URL _url = new URL(url);
		HttpURLConnection connection = (HttpURLConnection) _url.openConnection();
		connection.setRequestMethod("PUT");
		connection.setRequestProperty("Content-Type", "application/json");
		String Token = Token();
		connection.setRequestProperty("Authorization", "Bearer " + Token);
		connection.setDoOutput(true);
		
		JSONObject obj = new JSONObject();
		obj.put("AdminID", admin.getAdminID());
		obj.put("FullName", admin.getFullName());
		obj.put("IMG", admin.getIMG());
		obj.put("Username", admin.getUsername());
		obj.put("Password", admin.getPassword());
		
		String data = obj.toString();
		byte[] dataBytes = data.getBytes();
		
		OutputStream outputStream = connection.getOutputStream();
		outputStream.write(dataBytes);
		outputStream.close();
		
		System.out.println(connection.getResponseCode() == 204);
		
		if(connection.getResponseCode() == 204) {
			return;
		}else {
			return;
		}
	}
	
	// 获取 一个 Admin 数据
	public static Admin getAdmin(String username,String password)throws Exception {
		
		List<Admin> list_admin = getAllAdmin();
		Admin admin = null;
		
		for(var i : list_admin) {
			if(i.getUsername().equals(username) && BCrypt.checkpw(password, i.getPassword())) {
				admin = i;
				break;
			}
		}
			
		return admin;	
	}

    // 获取 所有 Admin 数据 List
	public static List<Admin> getAdmin_list(int id)throws Exception {
		
		List<Admin> list_admin = getAllAdmin();
		List<Admin> list_admin2 = new ArrayList<>();
		
		for(var i : list_admin) {
			if(i.getAdminID()!=id) {
				list_admin2.add(i);
			}
		}
			
		return list_admin2;
	}

	// 验证 Admin 名字
	public static boolean getAdmin_CheckFullname(String fullname)throws Exception {
		
		List<Admin> list_admin = getAllAdmin();
		boolean b = false;
		
		for(var i : list_admin) {
			if(i.getFullName().equals(fullname)) {
				b = true;
				break;
			}
		}
			
		return b;
	}

    // 验证 Admin id
	public static boolean getAdmin__Checkid(String username)throws Exception {
	
	List<Admin> list_admin = getAllAdmin();
	boolean b = false;
	
	for(var i : list_admin) {
		if(i.getUsername().equals(username)) {
			b = true;
			break;
		}
	}
		
	return b;
}

    // 验证 Admin 密码
	public static boolean getAdmin__Checkpassword(String password)throws Exception {
	
		List<Admin> list_admin = getAllAdmin();
		boolean b = false;
		
		for(var i : list_admin) {
			if(BCrypt.checkpw(password, i.getPassword())) {
				b = true;
				break;
			}		
		}
			
		return b;
	}

}
```

其他例子 包含 `CRUD`

```java
package AppDBContext;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONObject;

import Models.Account;
import Models.BankAccount;
import Models.Transaction;

public class api_Transaction {
	static api_Admin api_admin = new api_Admin();
	static api_Account api_account = new api_Account();
	
    // 获取 URL
	public static String URL()throws Exception {
		final URL url = new URL("http://localhost:5200/api/Transaction/");
		return url.toString();
	}
	
    // 获取 所有 数据
	public static List<Transaction> getAllTransaction()throws Exception{

		JSONObject obj = new JSONObject();
		String _url = URL();
		URL url = new URL(_url);
		HttpURLConnection connection = (HttpURLConnection)url.openConnection();
		connection.setRequestMethod("GET");
		String Token = api_account.Token();
		connection.setRequestProperty("Authorization", "Bearer " + Token);
		connection.connect();
		
		InputStream inputStream = connection.getInputStream();
		BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream));
		StringBuilder result = new StringBuilder();
		String line;
		while((line=reader.readLine()) != null) {
			result.append(line);
		}
		
		reader.close();
		JSONArray array = new JSONArray(result.toString());
		List<Transaction> list = new ArrayList<>();
		for(int i = 0 ; i < array.length();i++) {
			obj = array.getJSONObject(i);
			int id = obj.getInt("transactionID");
			int BankAccountID = obj.getInt("bankAccountID");
			String TransactionType = obj.getString("transactionType");
			String TransactionStatus = obj.getString("transactionStatus");
			String Date= obj.getString("date");
			String Description = obj.getString("description");
			String Credit = obj.getString("credit");
			String Debit = obj.getString("debit");
			double Amount = obj.getDouble("amount");
			boolean IsIBG = obj.getBoolean("isIBG");
			double SMSNotification = obj.getDouble("smsNotification");
			String PhoneNumber = obj.getString("phoneNumber");
			String Email = obj.getString("email");
			String OtherDescription = obj.getString("otherDescription");

			list.add(new Transaction(id,BankAccountID,TransactionType,TransactionStatus,Date,Description,Credit,Debit,Amount,
					IsIBG,SMSNotification,PhoneNumber,Email,OtherDescription));
		}
		
		return list;
		
	}
	
    // 获取 所有 数据 方式 2
	public static List<Transaction> getAllTransaction2()throws Exception{

		JSONObject obj = new JSONObject();
		String _url = URL();
		URL url = new URL(_url);
		HttpURLConnection connection = (HttpURLConnection)url.openConnection();
		connection.setRequestMethod("GET");
		String Token = api_admin.Token();
		connection.setRequestProperty("Authorization", "Bearer " + Token);
		connection.connect();
		
		InputStream inputStream = connection.getInputStream();
		BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream));
		StringBuilder result = new StringBuilder();
		String line;
		while((line=reader.readLine()) != null) {
			result.append(line);
		}
		
		reader.close();
		JSONArray array = new JSONArray(result.toString());
		List<Transaction> list = new ArrayList<>();
		for(int i = 0 ; i < array.length();i++) {
			obj = array.getJSONObject(i);
			int id = obj.getInt("transactionID");
			int BankAccountID = obj.getInt("bankAccountID");
			String TransactionType = obj.getString("transactionType");
			String TransactionStatus = obj.getString("transactionStatus");
			String Date= obj.getString("date");
			String Description = obj.getString("description");
			String Credit = obj.getString("credit");
			String Debit = obj.getString("debit");
			double Amount = obj.getDouble("amount");
			boolean IsIBG = obj.getBoolean("isIBG");
			double SMSNotification = obj.getDouble("smsNotification");
			String PhoneNumber = obj.getString("phoneNumber");
			String Email = obj.getString("email");
			String OtherDescription = obj.getString("otherDescription");

			list.add(new Transaction(id,BankAccountID,TransactionType,TransactionStatus,Date,Description,Credit,Debit,Amount,
					IsIBG,SMSNotification,PhoneNumber,Email,OtherDescription));
		}
		
		return list;
		
	}
	
	// 创建
	public static void CreateTransaction(Transaction tr)throws Exception {
		
		String _url = URL();
		URL url = new URL(_url);
		HttpURLConnection connection = (HttpURLConnection)url.openConnection();
		connection.setRequestMethod("POST");
		connection.setRequestProperty("Content-Type", "application/json");
		String Token = api_account.Token();
		connection.setRequestProperty("Authorization", "Bearer " + Token);
		connection.setDoOutput(true);
		
		JSONObject obj = new JSONObject();
		obj.put("TransactionID", 0);
		obj.put("BankAccountID", tr.getBankAccountID());
		obj.put("TransactionType", tr.getTransactionType());
		obj.put("TransactionStatus", tr.getTransactionStatus());
		obj.put("Date", tr.getDate());
		obj.put("Description", tr.getDescription());
		obj.put("Credit", tr.getCredit());
		obj.put("Debit", tr.getDebit());
		obj.put("Amount", tr.getAmount());
		obj.put("IsIBG", tr.isIsIBG());
		obj.put("SMSNotification", tr.getSMSNotification());
		obj.put("PhoneNumber", tr.getPhoneNumber());
		obj.put("Email", tr.getEmail());
		obj.put("OtherDescription", tr.getOtherDescription());
		
		String data = obj.toString();
		byte[] dataBytes = data.getBytes();
		
		OutputStream outputStream = connection.getOutputStream();
		outputStream.write(dataBytes);
		outputStream.close();
		
		if(connection.getResponseCode() == 201) {
			return;
		}else {
			return;
		}
		
	}

    // 更新
	public static void UpdateTransaction(Transaction tr)throws Exception {
		
		String url = URL()+tr.getTransactionID();
		URL _url = new URL(url);
		HttpURLConnection connection = (HttpURLConnection) _url.openConnection();
		connection.setRequestMethod("PUT");
		connection.setRequestProperty("Content-Type", "application/json");
		String Token = api_admin.Token();
		connection.setRequestProperty("Authorization", "Bearer " + Token);
		connection.setDoOutput(true);
		
		JSONObject obj = new JSONObject();
		obj.put("TransactionID", tr.getTransactionID());
		obj.put("BankAccountID", tr.getBankAccountID());
		obj.put("TransactionType", tr.getTransactionType());
		obj.put("TransactionStatus", tr.getTransactionStatus());
		obj.put("Date", tr.getDate());
		obj.put("Description", tr.getDescription());
		obj.put("Credit", tr.getCredit());
		obj.put("Debit", tr.getDebit());
		obj.put("Amount", tr.getAmount());
		obj.put("IsIBG", tr.isIsIBG());
		obj.put("SMSNotification", tr.getSMSNotification());
		obj.put("PhoneNumber", tr.getPhoneNumber());
		obj.put("Email", tr.getEmail());
		obj.put("OtherDescription", tr.getOtherDescription());
		
		String data = obj.toString();
		byte[] dataBytes = data.getBytes();
		
		OutputStream outputStream = connection.getOutputStream();
		outputStream.write(dataBytes);
		outputStream.close();
		
		System.out.println(connection.getResponseCode());
		if(connection.getResponseCode() == 204) {
			return;
		}else {
			return;
		}

		
		
	}

    // 获取 数据
	public static Transaction getBankAccount_ByCardnum(String date,String des, String cre)throws Exception {
		
		List<Transaction> list_tr = getAllTransaction();
		Transaction tr = null;
		
		for(var i : list_tr) {
			if(i.getDate().equals(date) && i.getDescription().equals(des) && i.getCredit().equals(cre) ) {
				tr = i;
				break;
			}
		}
			
		return tr;
		
	}
	
    // 获取 数据 BY id
	public static Transaction gettr_Byid(int id)throws Exception {
		
		List<Transaction> list_tr = getAllTransaction();
		Transaction tr = null;
		
		for(var i : list_tr) {
			if(i.getTransactionID() == id ) {
				tr = i;
				break;
			}
		}
			
		return tr;
		
	}
	
    // 获取 数据 BY id
	public static Transaction gettr_Byid2(int id)throws Exception {
		
		List<Transaction> list_tr = getAllTransaction2();
		Transaction tr = null;
		
		for(var i : list_tr) {
			if(i.getTransactionID() == id ) {
				tr = i;
				break;
			}
		}
			
		return tr;
		
	}
	
	// 获取 List
	public static List<Transaction> getBankAccount_ByList(String debit,String date,String name, String pass)throws Exception {
		
		api_account.getKEY(name, pass);
		List<Transaction> list_tr = getAllTransaction();
		List<Transaction> tr = new ArrayList<>();
		
		for(var i : list_tr) {
			String da = i.getDate();
			String time = da.substring(0, 10);
			if(date.equals(time) && i.getDebit().equals(debit) && (i.getTransactionType().equals("MB Other Account") || i.getTransactionType().equals("IBG Transfer")) && i.getTransactionStatus().equals("true") && i.isIsIBG() == true) {
				tr.add(i);
			}
		}
			
		return tr;
		
	}
	
    // 获取 List
	public static List<Transaction> getBankAccount_ByBankAccountID(int id)throws Exception {

		List<Transaction> list_tr = getAllTransaction();
		List<Transaction> tr = new ArrayList<>();
		
		for(var i : list_tr) {
			if(i.getBankAccountID() == id && i.getTransactionStatus().equals("true") && i.isIsIBG() == true) {
				tr.add(i);
			}
		}
			
		return tr;
		
	}
	
	public static List<Transaction> getBankAccount_ByBankAccountID_Own(int id)throws Exception {

		List<Transaction> list_tr = getAllTransaction();
		List<Transaction> tr = new ArrayList<>();
		
		for(var i : list_tr) {
			if(i.getBankAccountID() == id && i.getTransactionType().equals("Transfer Own Account") && i.getTransactionStatus().equals("true")) {
				tr.add(i);
			}
		}
			
		return tr;
		
	}
	
	public static List<Transaction> getBankAccount_ByBankAccountID_IBG(int id)throws Exception {

		List<Transaction> list_tr = getAllTransaction();
		List<Transaction> tr = new ArrayList<>();
		
		for(var i : list_tr) {
			if(i.getBankAccountID() == id && i.getTransactionType().equals("IBG Transfer") && i.isIsIBG() == true && i.getTransactionStatus().equals("true")) {
				tr.add(i);
			}
		}
			
		return tr;
		
	}
	
	public static List<Transaction> getBankAccount_ByBankAccountID_Payment(int id)throws Exception {

		List<Transaction> list_tr = getAllTransaction();
		List<Transaction> tr = new ArrayList<>();
		
		for(var i : list_tr) {
			if(i.getBankAccountID() == id && i.getTransactionType().equals("Payment Transfer") && i.getTransactionStatus().equals("true")) {
				tr.add(i);
			}
		}
			
		return tr;
		
	}
	
	public static List<Transaction> getBankAccount_ByBankAccountID_Other(int id)throws Exception {

		List<Transaction> list_tr = getAllTransaction();
		List<Transaction> tr = new ArrayList<>();
		
		for(var i : list_tr) {
			if(i.getBankAccountID() == id && i.getTransactionType().equals("MB Other Account") && i.getTransactionStatus().equals("true")) {
				tr.add(i);
			}
		}
			
		return tr;
		
	}
	
	public static List<Transaction> getIBG()throws Exception {

		List<Transaction> list_tr = getAllTransaction2();
		List<Transaction> tr = new ArrayList<>();
		
		for(var i : list_tr) {
			if(i.isIsIBG() == false && i.getTransactionType().equals("IBG Transfer") && i.getTransactionStatus().equals("true")) {
				tr.add(i);
			}
		}
			
		return tr;
		
	}
	
	public static List<Transaction> getBankAccount_ByBankAccountID_All()throws Exception {

		List<Transaction> list_tr = getAllTransaction2();
		List<Transaction> tr = new ArrayList<>();
		
		for(var i : list_tr) {
			if(i.getTransactionStatus().equals("true") && i.isIsIBG() == true &&  (i.getTransactionType().equals("IBG Transfer") || i.getTransactionType().equals("MB Other Account"))) {
				tr.add(i);
			}
		}
			
		return tr;
		
	}
	
	public static List<Transaction> getBankAccount_ByBankAccountID_Select(String year,String month,int id)throws Exception {

		List<Transaction> list_tr = getAllTransaction();
		List<Transaction> tr = new ArrayList<>();
		
		for(var i : list_tr) {
			String month1 = i.getDate().substring(5, 7);
			String year1 = i.getDate().substring(0, 4);
			if(i.getBankAccountID() == id && i.getTransactionStatus().equals("true") && i.isIsIBG() == true &&
					month1.equals(month) && year.equals(year)) {
				tr.add(i);
			}
		}
			
		return tr;
		
	}
	
	public static List<Transaction> getBankAccount_ByBankAccountID_Own_Select(String year,String month,int id)throws Exception {

		List<Transaction> list_tr = getAllTransaction();
		List<Transaction> tr = new ArrayList<>();
		
		for(var i : list_tr) {
			String month1 = i.getDate().substring(5, 7);
			String year1 = i.getDate().substring(0, 4);
			if(i.getBankAccountID() == id && i.getTransactionType().equals("Transfer Own Account") && i.getTransactionStatus().equals("true") &&
					month1.equals(month) && year.equals(year)) {
				tr.add(i);
			}
		}
			
		return tr;
		
	}
	
	public static List<Transaction> getBankAccount_ByBankAccountID_IBG_Select(String year,String month,int id)throws Exception {

		List<Transaction> list_tr = getAllTransaction();
		List<Transaction> tr = new ArrayList<>();
		
		for(var i : list_tr) {
			String month1 = i.getDate().substring(5, 7);
			String year1 = i.getDate().substring(0, 4);
			if(i.getBankAccountID() == id && i.getTransactionType().equals("IBG Transfer") && i.isIsIBG() == true && i.getTransactionStatus().equals("true") && 
					month1.equals(month) && year.equals(year)) {
				tr.add(i);
			}
		}
			
		return tr;
		
	}
	
	public static List<Transaction> getBankAccount_ByBankAccountID_Payment_Select(String year,String month,int id)throws Exception {

		List<Transaction> list_tr = getAllTransaction();
		List<Transaction> tr = new ArrayList<>();
		
		for(var i : list_tr) {
			String month1 = i.getDate().substring(5, 7);
			String year1 = i.getDate().substring(0, 4);
			if(i.getBankAccountID() == id && i.getTransactionType().equals("Payment Transfer") && i.getTransactionStatus().equals("true") && 
					month1.equals(month) && year.equals(year)) {
				tr.add(i);
			}
		}
			
		return tr;
		
	}
	
	public static List<Transaction> getBankAccount_ByBankAccountID_Other_Select(String year,String month,int id)throws Exception {

		List<Transaction> list_tr = getAllTransaction();
		List<Transaction> tr = new ArrayList<>();
		
		for(var i : list_tr) {
			String month1 = i.getDate().substring(5, 7);
			String year1 = i.getDate().substring(0, 4);
			if(i.getBankAccountID() == id && i.getTransactionType().equals("MB Other Account") && i.getTransactionStatus().equals("true") && 
					month1.equals(month) && year.equals(year)) {
				tr.add(i);
			}
		}
			
		return tr;
		
	}

}
```



#### Models

Admin 例子

```java
package Models;

public class Admin {

	private int AdminID;
	private String FullName;
	private String IMG;
	private String Username;
	private String Password;
	
	public Admin() {
	}
	
	public Admin(int adminID, String fullName, String iMG, String username, String password) {
		AdminID = adminID;
		FullName = fullName;
		IMG = iMG;
		Username = username;
		Password = password;
	}
	
	public int getAdminID() {
		return AdminID;
	}
	public void setAdminID(int adminID) {
		AdminID = adminID;
	}
	public String getFullName() {
		return FullName;
	}
	public void setFullName(String fullName) {
		FullName = fullName;
	}
	public String getIMG() {
		return IMG;
	}
	public void setIMG(String iMG) {
		IMG = iMG;
	}
	public String getUsername() {
		return Username;
	}
	public void setUsername(String username) {
		Username = username;
	}
	public String getPassword() {
		return Password;
	}
	public void setPassword(String password) {
		Password = password;
	}
	
}
```



#### Controller

Admin_login 例子

```java
package Controller;

import jakarta.servlet.ServletConfig;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.servlet.http.HttpSession;

import java.io.IOException;
import java.text.SimpleDateFormat;
import java.time.LocalDate;
import java.time.LocalDateTime;
import java.time.Month;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Locale;

import AppDBContext.api_Account;
import AppDBContext.api_Admin;
import AppDBContext.api_BankAccount;
import AppDBContext.api_Transaction;
import Models.Account;
import Models.Admin;
import Models.BankAccount;
import Models.Transaction;

/**
 * Servlet implementation class admin_login
 */
public class admin_login extends HttpServlet {
	private static final long serialVersionUID = 1L;
	public static api_Admin api_admin = new api_Admin();
	public static api_Transaction api_tr = new api_Transaction();
	public static api_BankAccount api_bank = new api_BankAccount();
	public static api_Account api_acc = new api_Account();
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public admin_login() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see Servlet#init(ServletConfig)
	 */
	public void init(ServletConfig config) throws ServletException {
		// TODO Auto-generated method stub
	}

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		response.getWriter().append("Served at: ").append(request.getContextPath());
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		HttpSession session = request.getSession();
		String userid = request.getParameter("userid");
		String password = request.getParameter("password");

		try {
			api_admin.getKEY("Hoo123", "$2a$10$DlgC8wjFMWO0f1uYCyuKPeu3ADtNZNFmNJNBPglE1/NVCwWohERdC");
			Admin admin = api_admin.getAdmin(userid, password);
			if(admin != null) {
				api_admin.getKEY("Hoo123", "$2a$10$DlgC8wjFMWO0f1uYCyuKPeu3ADtNZNFmNJNBPglE1/NVCwWohERdC");
				List<Admin> list = api_admin.getAdmin_list(admin.getAdminID());
				session.setAttribute("Admin", admin);
				session.setAttribute("Adminlist", list);
				session.setAttribute("adminlogin", "");
				
				new_Change();
				limit_Change();
				
				LocalDate localDate = LocalDate.now();
				Month month = localDate.getMonth();
				
				String[] str = new SimpleDateFormat("yyyy-MM-dd").format(new Date()).toString().split("-");
				String day = str[2];
				
				Date date = new Date();
				
				session.setAttribute("month", month.toString());
				session.setAttribute("day", day.toString());
				session.setAttribute("mytime", date.toString());
				
				response.sendRedirect("Admin/page/admin_home.jsp");
				return;
			}else {
				session.setAttribute("adminlogin", "Login failed.");
				response.sendRedirect("Admin/page/Login.jsp");
				return;
			}
		}catch(Exception e) {
			session.setAttribute("adminlogin", "Login failed.");
			response.sendRedirect("Admin/page/Login.jsp");
			return;
		}
		
	}
	
    // 自动 更新 登入 次数
	public static void new_Change() {
		try {
			SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
			DateTimeFormatter dtf = DateTimeFormatter.ofPattern("yyyy-MM-dd");
			LocalDateTime now = LocalDateTime.now();
			
			api_admin.getKEY("Hoo123", "$2a$10$DlgC8wjFMWO0f1uYCyuKPeu3ADtNZNFmNJNBPglE1/NVCwWohERdC");
			List<Transaction> tr = api_tr.getIBG();
			if(tr.size() != 0) {
				for(var i : tr) {
					String date = i.getDate().substring(0, 10);
					
					Date bt = sdf.parse(dtf.format(now).toString());
					Date et = sdf.parse(date);
					
					if(bt.before(et)) {}else{
						//加钱
						api_admin.getKEY("Hoo123", "$2a$10$DlgC8wjFMWO0f1uYCyuKPeu3ADtNZNFmNJNBPglE1/NVCwWohERdC");
						BankAccount bank = api_bank.getBankAccount_ByCardnum(i.getCredit());
						double balance = bank.getBalance() + i.getAmount();
						bank.setBalance(balance);
						api_admin.getKEY("Hoo123", "$2a$10$DlgC8wjFMWO0f1uYCyuKPeu3ADtNZNFmNJNBPglE1/NVCwWohERdC");
						api_bank.UpdateBankAccountID(bank);
						
						//IBG true
						i.setIsIBG(true);
						api_admin.getKEY("Hoo123", "$2a$10$DlgC8wjFMWO0f1uYCyuKPeu3ADtNZNFmNJNBPglE1/NVCwWohERdC");
						api_tr.UpdateTransaction(i);
					}
				}
			}
			return;
		}catch(Exception e) {
			return;
		}
	}

    // 登入 次数
	public static void limit_Change() {
		try {
			SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
			DateTimeFormatter dtf = DateTimeFormatter.ofPattern("yyyy-MM-dd");
			LocalDateTime now = LocalDateTime.now();
			
			api_admin.getKEY("Hoo123", "$2a$10$DlgC8wjFMWO0f1uYCyuKPeu3ADtNZNFmNJNBPglE1/NVCwWohERdC");
			List<Account> a = api_acc.getAllAccount();
			
			for(var i : a) {
				String date = i.getLoginTime().substring(0, 10);
				Date bt = sdf.parse(dtf.format(now).toString());
				Date et = sdf.parse(date);
				
				if(bt.before(et)) {}else{
					//变回limit
					//变回次数 false
					api_admin.getKEY("Hoo123", "$2a$10$DlgC8wjFMWO0f1uYCyuKPeu3ADtNZNFmNJNBPglE1/NVCwWohERdC");
					List<BankAccount> Allbank = api_bank.getListBankAccount_By_AccountID(i.getAccountID());
					for(var j : Allbank) {
						double limit = j.getAllLimit();
						j.setCardLimit(limit);
						j.setChange(false);
						api_admin.getKEY("Hoo123", "$2a$10$DlgC8wjFMWO0f1uYCyuKPeu3ADtNZNFmNJNBPglE1/NVCwWohERdC");
						api_bank.UpdateBankAccountID(j);
					}
				}
			}	
			return;
			
		}catch(Exception e) {
			return;
		}
	}

}
```



#### Controller/Ajax

```java
package Controller;

import jakarta.servlet.ServletConfig;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.servlet.http.HttpSession;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import com.google.gson.Gson;

import AppDBContext.api_Account;
import AppDBContext.api_Admin;
import AppDBContext.api_BankAccount;
import AppDBContext.api_User;
import Models.Admin;
import Models.BankAccount;
import Models.User;

/**
 * Servlet implementation class AjaxFunction
 */
public class AjaxFunction extends HttpServlet {
	private static final long serialVersionUID = 1L;
	public static api_Account api_account = new api_Account();
	public static api_Admin api_admin = new api_Admin();
	public static api_BankAccount api_bank = new api_BankAccount();
	public static api_User api_user = new api_User();
	
	
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public AjaxFunction() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see Servlet#init(ServletConfig)
	 */
	public void init(ServletConfig config) throws ServletException {
		// TODO Auto-generated method stub
	}

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		response.getWriter().append("Served at: ").append(request.getContextPath());
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		
		String Action = request.getParameter("Action");
		if(Action.equals("getAllBankAccount_To_View")) {
			getAllBankAccount_To_View(request,response);
			return;
		}else if(Action.equals("getAllUser")) {
			getAllUser(request,response);
			return;
		}else if(Action.equals("SearchAllUser")) {
			SearchAllUser(request,response);
			return;
		}else if(Action.equals("update")) {
			HttpSession session = request.getSession();
			session.setAttribute("updateuseradmin", "");
			String Fullname = request.getParameter("Fullname");
			String email = request.getParameter("email");
			String nric = request.getParameter("nric");
			String age = request.getParameter("age");
			String gender = request.getParameter("gender");
			String birth = request.getParameter("birth");
			
			Admin admin = (Admin)session.getAttribute("Admin");
			User u = (User)session.getAttribute("upuser");
			Gson gson = new Gson();
			
			List<User> b_list = new ArrayList<>();
			try {
				api_admin.getKEY(admin.getUsername(), admin.getPassword());
				b_list = api_user.getAllUser();
				
				if(!u.getFullName().equals(Fullname)) {
					for(var i : b_list) {
						if(i.getFullName().equals(Fullname)) {
							session.setAttribute("updateuseradmin", "This fullname is already in use");
//							response.sendRedirect("Admin/page/user_select.jsp");
//							return;
							String json = gson.toJson(false);
							response.getWriter().write(json);
							return;
						}
					}
					u.setFullName(Fullname);
				}
				
				if(!u.getEmail().equals(email)) {
					for(var i : b_list) {
						if(i.getEmail().equals(email)) {
							session.setAttribute("updateuseradmin", "This email is already in use");
//							response.sendRedirect("Admin/page/user_select.jsp");
//							return;
							String json = gson.toJson(false);
							response.getWriter().write(json);
							return;
						}
					}
					u.setEmail(email);
				}
				
				if(!u.getNRIC().equals(nric)) {
					
					for(var i : b_list) {
						if(i.getNRIC().equals(nric)) {
							session.setAttribute("updateuseradmin", "This nric is already in use");
//							response.sendRedirect("Admin/page/user_select.jsp");
//							return;
							String json = gson.toJson(false);
							response.getWriter().write(json);
							return;
						}
					}
					
					int ageint = Integer.valueOf(age);
					if(age != null) {
						if(ageint < 18 && ageint > 60) {
							session.setAttribute("updateuseradmin", "Age must be 18 - 60");
//							response.sendRedirect("Admin/page/user_select.jsp");
//							return;
							String json = gson.toJson(false);
							response.getWriter().write(json);
							return;
						}else {
							u.setNRIC(nric);
							u.setEmail(email);
							u.setAge(ageint);
							u.setGender(gender);
							u.setBirthDate(birth);
						}
					}
					
				}
				
				
				
				api_admin.getKEY(admin.getUsername(), admin.getPassword());
				api_user.UpdateAccount(u);
				session.setAttribute("upuser", u);
				session.setAttribute("updateuseradmin", "");

				
			}catch(Exception e) {
				e.getMessage();
			}
			
			String json = gson.toJson(true);
			response.getWriter().write(json);
			return;
			
		}else if(Action.equals("blocked")) {
			Block(request,response);
			return;
		}
		
		return;
		
	}
	
	private void getAllBankAccount_To_View(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		String dataUsername = request.getParameter("AccountData");
		Gson gson = new Gson();
		List<BankAccount> b_list = new ArrayList<>();
		int id = Integer.valueOf(dataUsername);
		try {
			b_list = api_bank.getListBankAccount_By_AccountID(id);
		}catch(Exception e) {
			e.getMessage();
		}
		String json = gson.toJson(b_list);
		response.getWriter().write(json);
	}
	
	private void getAllUser(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		HttpSession session = request.getSession();
		Admin admin = (Admin)session.getAttribute("Admin");
		Gson gson = new Gson();
		List<User> b_list = new ArrayList<>();
		try {
			api_admin.getKEY(admin.getUsername(), admin.getPassword());
			b_list = api_user.getAllUser();
		}catch(Exception e) {
			e.getMessage();
		}
		String json = gson.toJson(b_list);
		response.getWriter().write(json);
	}
	
	private void SearchAllUser(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		HttpSession session = request.getSession();
		String dataUsername = request.getParameter("Value");
		Admin admin = (Admin)session.getAttribute("Admin");
		Gson gson = new Gson();
		List<User> b_list = new ArrayList<>();
		try {
			api_admin.getKEY(admin.getUsername(), admin.getPassword());
			b_list = api_user.getUser_list(dataUsername);
			if(b_list.size() == 0) {
				api_admin.getKEY(admin.getUsername(), admin.getPassword());
				b_list = api_user.getAllUser();
			}
			
		}catch(Exception e) {
			e.getMessage();
		}
		String json = gson.toJson(b_list);
		response.getWriter().write(json);
	}

	private void Block(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		HttpSession session = request.getSession();
		String id = request.getParameter("id");
		Admin admin = (Admin)session.getAttribute("Admin");
		Gson gson = new Gson();
		List<User> b_list = new ArrayList<>();
		try {
			api_admin.getKEY(admin.getUsername(), admin.getPassword());
			b_list = api_user.getAllUser();
			User u = new User();
			int mid = Integer.valueOf(id);
			for(var i : b_list) {
				if(i.getUserID() == mid) {
					u = i;
					break;
				}
			}
			
			if(u.isActive() == true) {
				u.setActive(false);
			}else {
				u.setActive(true);
			}
			
			api_admin.getKEY(admin.getUsername(), admin.getPassword());
			api_user.UpdateAccount(u);
			
		}catch(Exception e) {
			e.getMessage();
		}
		String json = gson.toJson(b_list);
		response.getWriter().write(json);
		return;
	}

}
```



#### HttpServletRequest

```java
protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		HttpSession session = request.getSession();
		String fullname = request.getParameter("fullname");
		String email = request.getParameter("email");
		String phone = request.getParameter("phone");
		String nric = request.getParameter("nric");
		String text = request.getParameter("text");
```



#### sendRedirect

```java
response.sendRedirect("MeyBank_Home/page/contact.jsp");
return;
```



#### Session 转换

```java
Account acc = (Account)session.getAttribute("Account"); // 取出数据
```

```java
session.setAttribute("AllHistory", tr_list); // 保存数据
```



#### List

```java
List<BankAccount> b_list = new ArrayList<>();
List<Transaction> tr_list = new ArrayList<>();
```

```java
for(var i : b_list) {
					tr_list.addAll(api_tr.getBankAccount_ByBankAccountID(i.getBankAccountID()));
				}
// 添加 数据
```



#### Collections.sort

按照 `TransactionID` 进行降序排列

```java
Collections.sort(tr_list, new Comparator<Transaction>() {
  @Override
  public int compare(Transaction u1, Transaction u2) {
    return -(u1.getTransactionID() - u2.getTransactionID());
  }
});
```



#### 头像

```html
<form action="../../User_Update" method="post" enctype="multipart/form-data">
```

```java
package Controller;

import jakarta.servlet.ServletConfig;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.MultipartConfig;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.servlet.http.HttpSession;
import jakarta.servlet.http.Part;

import java.io.File;
import java.io.IOException;

import org.mindrot.jbcrypt.BCrypt;

import AppDBContext.api_Account;
import AppDBContext.api_BankAccount;
import AppDBContext.api_Transaction;
import AppDBContext.api_User;
import Models.Account;
import Models.User;

@MultipartConfig()
public class User_Update extends HttpServlet {
	private static final long serialVersionUID = 1L;
	public static api_BankAccount api_bank = new api_BankAccount();
	public static api_User api_user = new api_User();
	public static api_Transaction api_tr = new api_Transaction();
	public static api_Account api_acc = new api_Account();
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public User_Update() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see Servlet#init(ServletConfig)
	 */
	public void init(ServletConfig config) throws ServletException {
		// TODO Auto-generated method stub
	}

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		response.getWriter().append("Served at: ").append(request.getContextPath());
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		HttpSession session = request.getSession();
		String fullname = request.getParameter("fullname");
		String gmail = request.getParameter("gmail");
		String password = request.getParameter("password");
		User u = (User)session.getAttribute("User");
		Account account = (Account) session.getAttribute("Account");
		
		try {
			String pass = account.getPassword();
			
			if(password != "" && password.length() != 0) {
				
				if(password.length() != 6) {
					session.setAttribute("updateusererror", "Password must be 6 digits");
					response.sendRedirect("MeyBank_User/page/User_Update.jsp");
					return;
				}
				
				api_acc.getKEY(account.getUsername(), account.getPassword());
				boolean bp = api_acc.Checking_By_password2(password);
				
				if(bp == true) {
					session.setAttribute("updateusererror", "Please enter another password.");
					response.sendRedirect("MeyBank_User/page/User_Update.jsp");
					return;
				}else {
					
					String hashedPassword = BCrypt.hashpw(password, BCrypt.gensalt());
					
					account.setPassword(hashedPassword);
					api_acc.getKEY(account.getUsername(), pass);
					api_acc.UpdateAccount(account, "account");
					session.setAttribute("Account", account);
				}
			}
			
			
			if(!u.getEmail().equals(gmail)) {
				
				boolean b = api_user.Checking_By_Email(gmail, account.getUsername(), pass, "account");
				if(b == false) {
					
					Part photoPart = request.getPart("Photo");
					String fileName = photoPart.getSubmittedFileName();
					if(fileName != "") {
						String savePath = "C:\\Users\\Hoo\\Desktop\\MyMeyBank\\MeyBank_Assignment\\src\\main\\webapp\\image\\User\\"+u.getEmail()+fileName;
						File saveFile = new File(savePath);
						photoPart.write(savePath);
						
						u.setIMG(u.getEmail()+fileName);
						u.setFullName(fullname);
						u.setEmail(gmail);
						api_Account.getKEY(account.getUsername(), pass);
						api_user.UpdateAccount(u);
						session.setAttribute("User", u);
						session.setAttribute("updateusererror", "");
						response.sendRedirect("MeyBank_User/page/profile_index.jsp");
						return;
					}else {
						u.setFullName(fullname);
						u.setEmail(gmail);
						api_Account.getKEY(account.getUsername(), pass);
						api_user.UpdateAccount(u);
						session.setAttribute("User", u);
						session.setAttribute("updateusererror", "");
						response.sendRedirect("MeyBank_User/page/profile_index.jsp");
						return;
					}	
				}else {
					session.setAttribute("updateusererror", "Please enter another email.");
					response.sendRedirect("MeyBank_User/page/User_Update.jsp");
					return;
				}
			}else {
				Part photoPart = request.getPart("Photo");
				String fileName = photoPart.getSubmittedFileName();
				if(fileName != "") {
					String savePath = "C:\\Users\\Hoo\\Desktop\\MyMeyBank\\MeyBank_Assignment\\src\\main\\webapp\\image\\User\\"+u.getEmail()+fileName;
					File saveFile = new File(savePath);
					photoPart.write(savePath);
					
					u.setIMG(u.getEmail()+fileName);
					u.setFullName(fullname);
					api_Account.getKEY(account.getUsername(), pass);
					api_user.UpdateAccount(u);
					session.setAttribute("User", u);
					session.setAttribute("updateusererror", "");
					response.sendRedirect("MeyBank_User/page/profile_index.jsp");
					return;
				}else {
					u.setFullName(fullname);
					api_Account.getKEY(account.getUsername(), pass);
					api_user.UpdateAccount(u);
					session.setAttribute("User", u);
					session.setAttribute("updateusererror", "");
					response.sendRedirect("MeyBank_User/page/profile_index.jsp");
					return;
				}	
			}

		}catch(Exception e) {
			e.getMessage();
			session.setAttribute("updateusererror", "Update Error.");
			response.sendRedirect("MeyBank_User/page/User_Update.jsp");
			return;
		}
		
	}

}
```

简单版

```java
@MultipartConfig()

Part photoPart = request.getPart("Photo");
				String fileName = photoPart.getSubmittedFileName();
				if(fileName != "") {
					String savePath = "C:\\Users\\Hoo\\Desktop\\MyMeyBank\\MeyBank_Assignment\\src\\main\\webapp\\image\\User\\"+u.getEmail()+fileName;
					File saveFile = new File(savePath);
					photoPart.write(savePath);
					
					u.setIMG(u.getEmail()+fileName);
					u.setFullName(fullname);
					api_Account.getKEY(account.getUsername(), pass);
					api_user.UpdateAccount(u);
					session.setAttribute("User", u);
					session.setAttribute("updateusererror", "");
					response.sendRedirect("MeyBank_User/page/profile_index.jsp");
					return;
				}else {
					u.setFullName(fullname);
					api_Account.getKEY(account.getUsername(), pass);
					api_user.UpdateAccount(u);
					session.setAttribute("User", u);
					session.setAttribute("updateusererror", "");
					response.sendRedirect("MeyBank_User/page/profile_index.jsp");
					return;
				}	
```

#### 发送 Email 和 OTP

```java
package Controller;

import jakarta.servlet.ServletConfig;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.servlet.http.HttpSession;

import java.io.IOException;
import java.util.Properties;
import java.util.Random;

import javax.mail.Authenticator;
import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;

/**
 * Servlet implementation class Tr_OTP
 */
public class Tr_OTP extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public Tr_OTP() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see Servlet#init(ServletConfig)
	 */
	public void init(ServletConfig config) throws ServletException {
		// TODO Auto-generated method stub
	}

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		HttpSession session = request.getSession();
		String Action = request.getParameter("Action");
		String num = NumberCode(4);
		email_OTP(num);
		
		if(Action.equals("MBTR")) {
			session.setAttribute("MBTROTHER", "true");
			session.setAttribute("MBTROTHEROTP", num);
			response.sendRedirect("MeyBank_User/page/transaction2.jsp");
			return;
		}else if(Action.equals("IBG")) {
			session.setAttribute("MBTROTHER", "true");
			session.setAttribute("MBTROTHEROTP", num);
			response.sendRedirect("MeyBank_User/page/transaction_IBG2.jsp");
			return;
		}else if(Action.equals("limit")) {
			session.setAttribute("MBTROTHER", "true");
			session.setAttribute("MBTROTHEROTP", num);
			response.sendRedirect("MeyBank_User/page/changelimit2.jsp");
			return;
		}else if(Action.equals("Payment")) {
			session.setAttribute("MBTROTHER", "true");
			session.setAttribute("MBTROTHEROTP", num);
			response.sendRedirect("MeyBank_User/page/Loan_Payment2.jsp");
			return;
		}
		
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		doGet(request, response);
	}
	

	public String NumberCode(int num) {
		Random r = new Random();
		char[] word = new char[num];
		for (int i = 0; i < num; i++)
		{
			int ran = r.nextInt(3);
			if (ran == 0)
				word[i] = (char)r.nextInt(49, 58);
			else
				word[i] = (char)r.nextInt(48, 58);

		}
		String str = new String(word);
		return str;
	}
	
	public static void email_OTP(String otp) {
		
		final String username = "wengchin1234567@gmail.com";
		final String password = "drwzhcsmtskejbeq";
		
		Properties props = new Properties();
		props.put("mail.smtp.host", "smtp.gmail.com");
		props.put("mail.smtp.auth", "true");
		props.put("mail.smtp.port", "587");
		props.put("mail.smtp.starttls.enable","true");
		
		Session session = Session.getDefaultInstance(props,
				new Authenticator() {
			protected PasswordAuthentication getPasswordAuthentication() {
				return new PasswordAuthentication(username,password);
			}
		});
		
		
		try {
			MimeMessage message = new MimeMessage(session);
			
			message.setFrom(new InternetAddress("wengchin1234567@gmail.com"));//from
			
			message.setRecipients(
					Message.RecipientType.TO, 
					InternetAddress.parse("wengchin123456@gmail.com")
			);//to email
			
			message.setSubject("MeyBank Transfer OTP");
			message.setText("OTP : "+otp);
			
			Transport.send(message);
		
		}catch(MessagingException e) {
			e.printStackTrace();
		}
		
	}
	
}
```



#### Get View

1，实体类

```java
package models;

public class User {
    private String name;
    private int age;

    // 构造函数
    public User(String name, int age) {
        this.name = name;
        this.age = age;
    }

    // Getter 和 Setter
    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public int getAge() {
        return age;
    }

    public void setAge(int age) {
        this.age = age;
    }
}
```

2，backend

```java
package controller;

import java.io.IOException;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.google.gson.Gson;

import models.User;
/**
 * Servlet implementation class ts
 */
@WebServlet("/")
public class ts extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public ts() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		
		// 创建 User 对象
	    User user = new User("Alice", 25);

	    // 将 User 对象放入请求属性中
	    request.setAttribute("user", user);

	    // 转发请求到 JSP 视图
	    request.getRequestDispatcher("UserView/index.jsp").forward(request, response);
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		doGet(request, response);
	}

}
```

3，frontend

```jsp
<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ page import="models.User" %> <!-- 引入 models -->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<body>

<h1>User Information</h1>
    <p>Name: ${user.name}</p> <!-- 假设 User 类有 getName() 方法 -->
    <p>Age: ${user.age}</p>       <!-- 假设 User 类有 getAge() 方法 -->

</body>
</html>
```







#### 重定向

```java
// 重定向到新的 URL，浏览器地址栏将更新
response.sendRedirect("MeyBank_User/page/index.jsp");
```

```java
// 转发请求到 JSP 视图，保持原有 URL
request.getRequestDispatcher("UserView/index.jsp").forward(request, response);
```







## WEB



#### JSP 写法

```jsp
<%
		String msg = (String)session.getAttribute("loginerror");
		if(msg == null){
			msg = "";
		}
%>

<p style="color:red;font-size:0.9rem;"><%= msg %></p>
```

```jsp
<p class="fitst-p2"><%=mybank.getBankAccNo()%>(<%=mybank.getAccountType()%>)
```

```jsp
<select class="form-control" id="m1" name="m1">
								<%
								for (BankAccount i : bank_list) {
								%>
								<%
								String type = i.getAccountType();
								double d = 0;
								if(type.equals("Saving Account")){
									d = 20;
								}else{
									d = 250;
								}
								
								double bal = i.getBalance() - d;
								if(bal < 0){
									bal = 0;
								}
								String balance = String.format("%.2f", bal).toString();
								%>
								<option><%=i.getBankAccNo()%>(RM
									<%=balance%>)
								</option>
								<%
								}
								%>
							</select>
```



#### 引入 Layout 和 Checking

```jsp
<%@include file="../../Layout/User_Index.jsp"%>
<%@page import="Models.*"%>
<%@include file="../../Layout/Checking_Login.jsp"%>

<% 
Account account = (Account)session.getAttribute("Account");
int id = account.getAccountID(); 
%>
```



#### Checking_Login.jsp

```jsp
<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
    <%@page import="Models.*"%>

    
<%
		Account acc = (Account)session.getAttribute("Account");
 		User user = (User)session.getAttribute("User");
 		String time = (String)session.getAttribute("lastlogintime");
		if(acc == null || acc == null || time == null){
			response.sendRedirect("../../MeyBank_Home/page/home.jsp");
			return;
		}
%>
```



#### Layout

`Admin` Checking

```java
<%@page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@page import="Models.*"%>

<%
   Admin admin = (Admin)session.getAttribute("Admin");
   if(admin == null){
	  response.sendRedirect("../../Admin/page/Login.jsp");
	  return;
   }
%>
```

`User`Checking

```java
<%@page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@page import="Models.*"%>

<%
	Account acc = (Account)session.getAttribute("Account");
 	User user = (User)session.getAttribute("User");
 	String time = (String)session.getAttribute("lastlogintime");
	if(acc == null || acc == null || time == null){
		response.sendRedirect("../../MeyBank_Home/page/home.jsp");
		return;
	}
%>
```

`Layout`

```jsp
<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
  </head>
<body>

	<section id="infinite2" class="text-white tm-font-big tm-parallax">

        <nav class="navbar navbar-expand-md tm-navbar2" id="tmNav">
      <div class="container">
        <div class="tm-next">
          <a href="index.jsp" class="navbar-brand"><img src="../../image/meybank-logo.png" width="30px">Meybank</a>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars navbar-toggler-icon"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <div class="navbar-nav ml-auto">
            <a href="../../Logout" class="logout-key"><i class="fa-solid fa-unlock-keyhole"></i>Logout</a>
          </div>
        </div>
      </div>
    </nav>
    
    </section>

    <section id="infinite2" class="text-white">
    <!-- Navigation -->
    <nav class="navbar tm-navbar2 navbar-select">
      <div class="container-list">

        <div class="div-item" id="box-0">
        	<a href="index.jsp" style="padding:10px 10px 0px 10px;
  					display:flex;
  					flex-direction: column;
  					transition: all .3s linear;
  					cursor: pointer;
  					color:white;
  					font-size:0.7rem">
        		<i class="fa-solid fa-house"></i>
            	<p>HOME</p>
        	</a> 
        </div>
        <div class="div-item" id="box-1" style="
        	display:flex;
    		flex-direction: column;
    		width: 170px;
    		transition: all .3s linear;
    		cursor: pointer;
    		border-right:1px solid #ced4da;">
        <a href="account_index.jsp" style="padding:10px 10px 0px 10px;
  					display:flex;
  					flex-direction: column;
  					transition: all .3s linear;
  					cursor: pointer;
  					color:white;">
            <i class="fa-sharp fa-solid fa-file"></i>
            <p>ACCOUNT</p>
            </a>
        </div>
        <div class="div-item" id="box-2" style="display:flex;
    		flex-direction: column;
    		width: 170px;
    		transition: all .3s linear;
    		cursor: pointer;
    		border-right:1px solid #ced4da;">
        <a href="transaction_index.jsp" style="padding:10px 10px 0px 10px;
  					display:flex;
  					flex-direction: column;
  					transition: all .3s linear;
  					cursor: pointer;
  					color:white;">
            <i class="fa-solid fa-arrow-right-arrow-left"></i>
            <p>FUND TRANSFER</p>
            </a>
        </div>
        <div class="div-item" id="box-3" style="display:flex;
    		flex-direction: column;
    		width: 170px;
    		transition: all .3s linear;
    		cursor: pointer;
    		border-right:1px solid #ced4da;">
        <a href="payment_index.jsp" style="padding:10px 10px 0px 10px;
  					display:flex;
  					flex-direction: column;
  					transition: all .3s linear;
  					cursor: pointer;
  					color:white;">
            <i class="fa-solid fa-dollar-sign"></i>
            <p>PAYMENT</p>
            </a>
        </div>
        <div class="div-item" id="box-4" style="display:flex;
    		flex-direction: column;
    		width: 170px;
    		transition: all .3s linear;
    		cursor: pointer;
    		border-right:1px solid #ced4da;"> 
        <a href="investment_index.jsp" style="padding:10px 10px 0px 10px;
  					display:flex;
  					flex-direction: column;
  					transition: all .3s linear;
  					cursor: pointer;
  					color:white;">
            <i class="fa-sharp fa-solid fa-arrow-trend-up"></i>
            <p>INVESTMENT</p>
            </a>
        </div>
        <div class="div-item" id="box-5" style="display:flex;
    		flex-direction: column;
    		transition: all .3s linear;
    		cursor: pointer;
    		border-right:1px solid #ced4da;">
        <a href="profile_index.jsp" style="padding:10px 0px 0px 0px;
  					display:flex;
  					flex-direction: column;
  					transition: all .3s linear;
  					cursor: pointer;
  					color:white;">
            <i class="fa-regular fa-user"></i>
            <p>PROFILE MAINTENANCE</p>
            </a>
        </div>
        <div class="div-item" id="box-6" style="display:flex;
    		flex-direction: column;
    		width: 170px;
    		transition: all .3s linear;
    		cursor: pointer;
    		border-right:1px solid #ced4da;">
        <a href="equity_index.jsp" style="padding:10px 10px 0px 10px;
  					display:flex;
  					flex-direction: column;
  					transition: all .3s linear;
  					cursor: pointer;
  					color:white;">
            <i class="fa-sharp fa-solid fa-layer-group"></i>
            <p>EQUITY RESEARCH</p>
            </a>
        </div>
        <div class="div-item" id="box-7" style="display:flex;
    		flex-direction: column;
    		width: 170px;
    		transition: all .3s linear;
    		cursor: pointer;
    		border-right:1px solid #ced4da;">
        <a href="mailbox_index.jsp" style="padding:10px 10px 0px 10px;
  					display:flex;
  					flex-direction: column;
  					transition: all .3s linear;
  					cursor: pointer;
  					color:white;">
            <i class="fa-solid fa-envelope"></i>
            <p>MAILBOX</p>
            </a>
        </div>
        <div class="div-item" id="box-8" style="display:flex;
    		flex-direction: column;
    		width: 170px;
    		transition: all .3s linear;
    		cursor: pointer;
    		border-right:1px solid #ced4da;">
        <a href="contact_index.jsp" style="padding:10px 10px 0px 10px;
  					display:flex;
  					flex-direction: column;
  					transition: all .3s linear;
  					cursor: pointer;
  					color:white;">
            <i class="fa-solid fa-phone"></i>
            <p>CONTACT US</p>
            </a>
        </div>

      </div>
    </nav>
</section>

</body>
</html>
```







`引入 import`

```java
<%@page import="Models.*"%>
<%@page import="java.util.*"%>
<%@include file="../../Layout/Checking_Login.jsp"%>

<%
User u = (User) session.getAttribute("User");
String amountUser = (String) session.getAttribute("amountUser");
String senUser = (String) session.getAttribute("senUser");
String countUser = (String) session.getAttribute("countUser");
String amountUsers = (String) session.getAttribute("amountUsers");
String senUsers = (String) session.getAttribute("senUsers");
String countUsers = (String) session.getAttribute("countUsers");
List<User> listUser = (List<User>) session.getAttribute("TodayUser");
%>
```

`For` 

```java
<% 
   // 假设 listUser 是一个存储 User 对象的列表
   List<User> listUser = UserDAO.getAllUsers();

   // 循环遍历 listUser 列表，输出每个用户的信息
   for (User user : listUser) {
%>
    	<div>
            <img src="../../image/User/<%= user.getIMG() %>" alt="profile-sample4" class="profile" />
            <div>
                <p><%= user.getGender() %></p>
                <p><%= user.getFullName() %></p> 
                <span><%= user.getBirthDate() %></span>
            </div>
            <p><%= user.getEmail() %></p>
        </div>
<% 
    }
%>
```

`Ajax`

```java
<td>${"${y.BankAccNo}"}</td>
```

`定义`

```java
<%
		String msg = (String)session.getAttribute("limitdone");
		if(msg == null){
			msg = "";
		}
	%>
```

`声明`

```java
<%! int i = 0; %> 
<%! int a, b, c; %> 
<%! Circle a = new Circle(2.0); %> 
```

`JSP注释`

```java
<%-- 该部分注释在网页中不会被显示--%> 
```

`**if…else** 块`

```java
<% if (day == 1 || day == 7) { %>
      <p>今天是周末</p>
<% } else { %>
      <p>今天不是周末</p>
<% } %>
```



## 插件

### **activation.jar**

辅助 邮件

- **功能**：JavaBeans Activation Framework 提供了一种动态查找、加载和调用对象的机制，主要用于处理电子邮件附件和 MIME 类型。

- **用途**：与 `javax.mail` 一起使用时，可以帮助处理邮件的 MIME 类型数据（如文本、图像、附件等）。

- 常见使用场景

  ：

  - 处理不同的 MIME 数据类型，如处理电子邮件中的附件。
  - 为程序提供通过数据类型自动选择合适的对象或工具的功能。



### **gson.jar**

用在 AJAX return

- **功能**：Gson 是 Google 开发的 Java 库，用于将 Java 对象与 JSON 数据相互转换（序列化和反序列化）。

- **用途**：广泛用于处理 JSON 数据，可以轻松地将 Java 对象转换为 JSON 字符串，或将 JSON 字符串解析为 Java 对象。

- 常见使用场景

  ：

  - 与 RESTful API 进行交互时，将 JSON 响应转换为 Java 对象，或将 Java 对象转换为 JSON 请求。
  - 配置文件或数据存储中使用 JSON 格式。

```java
Gson gson = new Gson();
String json = gson.toJson(myObject);  // Java 对象转换为 JSON
MyObject obj = gson.fromJson(json, MyObject.class);  // JSON 转换为 Java 对象
```



###  **javax.mail.jar**

发送 邮件

- **功能**：JavaMail API 提供了用于发送和接收电子邮件的功能，支持多种协议如 SMTP、IMAP 和 POP3。

- **用途**：用于处理电子邮件功能的标准库，可以发送电子邮件、接收邮件、处理邮件附件等。

- 常见使用场景

  ：

  - 开发邮件客户端应用。
  - 发送自动化邮件通知（如在 Web 应用中发送注册确认邮件）。
  - 从邮箱中提取并处理邮件。



### **jBCrypt.jar**

密码 哈希

- **功能**：jBCrypt 是 Java 版的 BCrypt 算法实现，专用于安全地进行密码哈希（hashing）和验证。

- **用途**：主要用于安全性要求较高的系统中保存用户密码，避免将明文密码存储在数据库中。BCrypt 算法设计为抗暴力破解。

- 常见使用场景

  ：

  - 用户注册和登录时，对密码进行哈希处理并存储。
  - 验证用户输入的密码与存储的哈希值是否匹配。



### **org.json.jar**

api json

- **功能**：这是一个轻量级的 JSON 库，主要用于在 Java 中解析 JSON 数据和构建 JSON 对象。

- **用途**：用于处理 JSON 数据的简单库，提供了将 JSON 数据转换为 Java 对象的功能，或者将 Java 数据转换为 JSON 字符串。

- 常见使用场景

  ：

  - 解析 JSON 响应，如从 API 获取数据。
  - 构建 JSON 请求，发送到服务器。



## 插件 配置

在 src/main 创建 resources 文件夹，copy 入 jar 文件

右键 项目名称 -> Build Path -> Configure Build Path

**1，Java Build Path**

在 Modulepath 引入 JAR

**2，Deployment Assen**

点击 Add -> Java Build Path Entries



## 快捷键

**ctrl+shift+M** 导入相应的包































