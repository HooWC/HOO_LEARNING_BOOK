## Laravel Passport

[Laravel 10 RESTful APIs with Passport Authentication 安装网站](https://onlinewebtutorblog.com/laravel-10-rest-apis-with-passport-authentication/)

*Passport 模式介绍*

```
->授权码模式（Authorization Code Grant）: x
grant_type=authorization_code
在客户端与资源所有者之间的交互中，通过授权服务器颁发的授权码来获取访问令牌。

->隐式授权模式（Implicit Grant）: x
grant_type=implicit
在客户端直接获取访问令牌，适用于一些前端应用，如单页应用（SPA）。

->密码授权模式（Password Grant）:  ✓
grant_type=password
用户直接提供用户名和密码，适用于受信任的客户端和用户信任的场景。

->客户端凭证授权模式（Client Credentials Grant）: x
grant_type=client_credentials
适用于客户端自身而不是特定用户的场景，客户端使用自己的凭证直接从授权服务器获取访问令牌。

->刷新令牌模式（Refresh Token Grant）: x
grant_type=refresh_token
使用刷新令牌来获取新的访问令牌，适用于长期有效性的场景。
```

### 安装 Passport

```
composer require laravel/passport  --with-all-dependencies
```

```
php artisan migrate 
```

### 生成

`passport:install` 是用于初始化 Laravel Passport 并设置必要的数据库和数据

`passport:keys` 是用于生成 Passport 加密密钥

`passport:client` 是用于创建 OAuth 客户端。这些命令结合起来使得在 Laravel 应用程序中实现 OAuth 认证变得更加简单和便捷。

```
php artisan passport:install
```

```
php artisan passport:keys
```

```
php artisan passport:client
```

### 使用 Token Api

##### 例子：

```
public function login(Request $request)
{
    $loginData = $request->only('email', 'password');

    if (Auth::attempt($loginData)) {
        $user = User::where('email', $request->email)->first();
        $tokenResult = $user->createToken('auth_token');
        $token = $tokenResult->accessToken;

        return response([
            'message' => 'Login successfully',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    return response([
        'message' => 'Login failed. Please verify your email and password'
    ], 401);
}
```

*通常与 OAuth 2.0 一起使用*