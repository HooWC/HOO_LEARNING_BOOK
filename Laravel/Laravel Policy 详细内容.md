### Laravel Policy 不需要安装

*在 Laravel 中，Policy 是一种授权机制，用于定义模型的授权策略。它允许你在应用程序中定义谁可以执行模型的哪些操作。通常，Policy 用于将授权逻辑与控制器逻辑分离开来，以确保你的应用程序具有良好的安全性和可维护性。*

*具体来说，Policy 允许你为特定的模型定义授权逻辑。这些逻辑决定了在给定的上下文中，哪些用户可以执行哪些操作。例如，你可以使用 Policy 来定义谁可以创建、查看、更新或删除特定类型的资源。在 Policy 中，你可以根据应用程序的需求和业务逻辑定义这些授权规则。*

**简单来说Policy是阻止黑客肆意破坏代码规矩**

##### 😁 安装 `Policy` 文件

```
php artisan make:policy PostPolicy
```
**或**

```
php artisan make:policy AuthenticatorsPolicy --model=Authenticators
```

##### 在 `app/Http/Providers` 里添加注册

```
protected $policies = [
    Authenticator::class => AuthenticatorPolicy::class,
];
```

### 🍂 Controller 用法

```
$request->validate([
    'authenticator_id' => ['required', 'integer', 'exists:authenticators,id'],
    'code' => ['required', 'digits:6'],
]);

$authenticator = Authenticator::find($request->authenticator_id);
$this->authorize('verify', $authenticator);
```

### 🍂 Policy 文件代码 `CRUM`

```
<?php

namespace App\Policies;

use App\Models\Authenticator;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AuthenticatorPolicy
{
    public function verify(User $user, Authenticator $authenticators)
    {
        if ($user->id === $authenticators->user_id)
            return Response::allow();
        else
            return Response::deny("You are not allowed to perform this operation");
    }

    public function view(User $user)
    {
        if ($user->roles->contains('name', 'account'))
            return Response::allow();
        else
            return Response::deny("You are not allow to view");
    }

    public function create(User $user)
    {
        if ($user->roles->contains('name', 'account'))
            return Response::allow();
        else
            return Response::deny("You are not allow to create");
    }

    public function update(User $user, Authenticator $authenticators)
    {
        if ($user->id === $authenticators->user_id)
            return Response::allow();
        else
            return Response::deny("You are not allow to update");
    }

    public function delete(User $user, Authenticator $authenticators)
    {
        if ($user->id === $authenticators->user_id)
            return Response::allow();
        else
            return Response::deny("You are not allow to delete");
    }

}
```

### 🔪🔪  正规项目的使用方法：例子如下

```
public function verify(Request $request)
{
    $request->validate([
        'authenticator_id' => ['required', 'integer', 'exists:authenticators,id'],
        'code' => ['required', 'digits:6'],
    ]);
    $authenticator = Authenticator::find($request->authenticator_id);
    $this->authorize('verify', $authenticator);

    $verifyCode = str_pad(TOTP::create($authenticator->secret_key)->now(), 6, '0', STR_PAD_LEFT);
    $isCodeValid = $verifyCode === $request->code;
    return response()->json([
        'message' => $isCodeValid ? 'Verification successful' : 'Verification failed',
        'authenticator' => $isCodeValid,
    ]);
}

public function index(Request $request)
{
    $this->authorize('view', Authenticator::class);

    $authenticators = $request->user()->authenticators;
    return AuthenticatorResource::collection($authenticators);
}

public function store(AuthenticatorRequest $request)
{
    $this->authorize('create', Authenticator::class);

    $authenticator = new Authenticator($request->validated());
    $authenticator->user_id = $request->user()->id;
    $authenticator->save();
    return response()->json([
       'message' => 'Authenticator created successfully',
       'authenticator' => AuthenticatorResource::make($authenticator)
    ]);
}

public function update(Authenticator $authenticator, AuthenticatorRequest $request)
{
    $this->authorize('update',$authenticator);

    $updateData = $request->only('account_name');
    $authenticator->update($updateData);
    return response()->json([
        'message' => 'Authenticator update successfully',
        'authenticator' =>  AuthenticatorResource::make($authenticator),
    ]);
}

public function destroy(Authenticator $authenticator, AuthenticatorRequest $request )
{
    $this->authorize('delete', $authenticator);

    $authenticator->delete();
    return response()->json([
        'message' => 'Authenticator deleted successfully'
    ]);
}
```