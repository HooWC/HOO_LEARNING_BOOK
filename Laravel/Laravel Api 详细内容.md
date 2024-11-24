### Laravel Api 写法

```php
Route::apiResource('user',UserController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgetPassword', [AuthController::class, 'forgetPassword']);
Route::post('/verifyEmail', [AuthController::class, 'verifyEmail'])->name('verifyEmail.post');
```
### API 默认路由

```
http://127.0.0.1:8000/api/account/authenticator/verify
```
```
http://127.0.0.1:8000/api/account/authenticators  (CRUD)
```

```php
Route::group(['prefix' => 'account', 'as' => 'api.account.', 'middleware' => 'auth:api'], function () {

    Route::group(['prefix' => 'authenticator', 'as' => 'authenticator.'], function () {
        Route::post('verify', [AuthenticatorController::class, 'verify']);
    });

    Route::resource('authenticators', AuthenticatorController::class)->parameters([
        'authenticator' => 'authenticator'
    ])->only(['index','store','update','destroy']);

});
```
### Ajax 默认路由

```
/api/ajax/account/filterProjectName
```

```php
Route::group(['prefix' => 'ajax'], function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::post('isDisabledUser', [AdminController::class, 'isDisabledUser']);
    });

    Route::group(['prefix' => 'account', 'as' => 'account.'], function () {
        Route::get('getKeyCode', [AccountController::class,'getKeyCode']);
        Route::post('getNewAuthenticator', [AccountController::class,'getNewAuthenticator']);
        Route::post('deleteAuthenticatorFunction', [AccountController::class,'deleteAuthenticatorFunction']);
        Route::post('filterProjectName', [AccountController::class,'filterProjectName']);
    });

});
```

### 快速建成 `User Api Controller`

```php
public function index()
{
    return User::all();
}

public function store(UserRequest $request)
{
    User::create($request->all());
    return true;
}

public function show(string $id)
{
    $data = User::find($id);
    if ($data) {
        return $data;
    } else {
        return response()->json([
            'status' => false,
            'message' => 'User not found'
        ]);
    }
}

public function update(UserRequest $request)
{
    $user_id = $request->input('user_id');
    $user = User::find($user_id);
    $updateData = $request->only('name', 'email');
    return $user->update($updateData);
}

public function destroy(UserRequest $request)
{
    // 禁止使用 delete function
    // 只有让用户 block account 而已
    $user_id = $request->input('user_id');
    $user = User::find($user_id);
    return $user->delete();
}
```
