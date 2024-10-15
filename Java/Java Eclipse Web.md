# Java Eclipse Web



## Eclipse 

`File` -> `New` -> `Project` 

`Web` -> `Dynamic Web Project` -> `选择 apache-tomcat-9.0.65` -> `打勾 Generate web.xml deployment descriptor`



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
```



## Layout

`Admin`

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

`User`

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



## AppDBContext

以下是连接 `API NET` 的写法例子

`api_Admin`

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
	
	public static String URL()throws Exception {
		final URL url = new URL("http://localhost:5200/api/Admin/");
		return url.toString();
	}
	
	public static void getKEY(String id , String Password) {
		tokem_id = id;
		token_Password = Password;
	}

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
	
	public static String URL()throws Exception {
		final URL url = new URL("http://localhost:5200/api/Transaction/");
		return url.toString();
	}
	
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





## JSP 写法

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



## Models 

`User`

```java
package Models;

public class User {

	private int UserID;
	private String FullName;
	private String IMG;
	private String NRIC;
	private int Age;
	private String BirthDate;
	private String Gender;
	private String Email;
	private boolean Active;
	
	public User(int userID, String fullName, String iMG, String nRIC, int age, String birthDate, String gender, String email, boolean active) {
		UserID = userID;
		FullName = fullName;
		IMG = iMG;
		NRIC = nRIC;
		Age = age;
		BirthDate = birthDate;
		Gender = gender;
		Email = email;
		Active = active;
	}
	public boolean isActive() {
		return Active;
	}
	public void setActive(boolean active) {
		Active = active;
	}
	public User() {
	}

	public int getUserID() {
		return UserID;
	}
	public void setUserID(int userID) {
		UserID = userID;
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
	public String getNRIC() {
		return NRIC;
	}
	public void setNRIC(String nRIC) {
		NRIC = nRIC;
	}
	public int getAge() {
		return Age;
	}
	public void setAge(int age) {
		Age = age;
	}
	public String getBirthDate() {
		return BirthDate;
	}
	public void setBirthDate(String birthDate) {
		BirthDate = birthDate;
	}
	public String getGender() {
		return Gender;
	}
	public void setGender(String gender) {
		Gender = gender;
	}
	public String getEmail() {
		return Email;
	}
	public void setEmail(String email) {
		Email = email;
	}
}
```



## 头像

```
<form action="../../User_Update" method="post" enctype="multipart/form-data">
```

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













