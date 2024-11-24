## Request 写法

#### 基本用法

```php
$request->validate([
    'authenticator_id' => ['required', 'integer', 'exists:authenticators,id'],
    'code' => ['required', 'digits:6'],
]);
```

```php
$request->validate([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
]);
```

```php
$loginData = $request->only('email', 'password');

if (Auth::attempt($loginData))
```

```php
$userId = $request->input('user_id');
$user = User::find($userId);
```

#### 文件用法

##### 安装 Request 文件

```
php artisan make:request UserRequest
```

**基础用法**

```php
public function authorize(): bool
{
    return true;
}

public function rules(): array
{
    return [
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string'],
    ];
}

# 错误信息
public function message()
{
	return [
		'email.required' => 'Please Press the email'
	]
}
```

##### 进阶用法 CRUD

**例子 1：**

```php
public function authorize(): bool
{
    return true;
}

public function rules(): array
{
    switch ($this->method()) {
        case 'POST':
            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:6', 'max:20']
            ];
        case 'PATCH':
            return [
                'user_id' => ['required', 'integer', 'exists:user,id'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email']
            ];
        case 'DELETE':
            return [
                'user_id' => ['required', 'integer', 'exists:user,id']
            ];
        default:
            return [];
    }
}

public function validated($key = null, $default = null)
{
    $validated = parent::validated($key, $default);
    return $validated;
}
```

**例子 2：**

```php
public function authorize(): bool
{
    return true;
}

public function rules()
{
    switch ($this->method()) {
        case 'POST':
            return [
                'account_name' => ['required', 'string', 'max:255'],
                'secret_key' => ['required', 'string']
            ];
        case 'PATCH':
            return [
                'authenticator_id' => ['required', 'integer', 'exists:authenticators,id'],
                'account_name' => ['required', 'string', 'max:255']
            ];
        case 'DELETE':
            return [
                'authenticator_id' => ['required', 'integer', 'exists:authenticators,id']
            ];
        default:
            return [];
    }
}

public function validated($key = null, $default = null)
{
    $validated = parent::validated($key, $default);
    return $validated;
}
```