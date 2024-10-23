## Laravel 进阶版

#### Route

```php
Route::get()
Route::post()
Route::put()
Route::delete()
Route::any()
Route::match(['get','post'],'index'mfunction(){})
Route::resource()
```

**单个**

```php
Route::get('task/read/{id}',[TaskController::class,"read"])->where('id','[0-9]+');
```

**多个**

```php
Route::get('task/read/{id}',[TaskController::class,"read"])->where(['id' => '[0-9]+', 'name' => '[a-z]+']);
```

**全局路由** app -> Providers -> RouteServiceProvider

```php
// 在 `RouteServiceProvider` 中定义全局路由模式约束
public function boot()
{
    parent::boot();

    // 全局约束 id 必须为数字
    Route::pattern('id', '[0-9]+');
}
```

`where('id', '.*')` 意味着，`id` 参数可以接受任何字符（数字、字母、符号等），甚至可以为空字符串。这个正则表达式是非常宽泛的，可以几乎匹配所有的输入。

```php
Route::get('user/{id}', function ($id) {
    return 'User ID is: ' . $id;
})->where('id', '.*');
```

**跳转路由 **index 跳转到 task

```php
Route::redirect('index','task');
```

**跳转路由 **index 跳转到 task

```php
Route::permanentRedirect('index','task');
```

**View 路由**

```php
Route::view('uri','view',['id' => 10]);
```

**Controller**

```php
return redirect()->route('task.index');
```

**Group**

```php
Route::prefix('api')->get('task',[TaskController::class,"read"]);
```

```php
Route::group(['prefix' => 'api'], function(){
    Route::get('task',[TaskController::class,"read"]);
    Route::get('task',[TaskController::class,"read"]);
})
```

**namespace**

**`namespace('Admin')`**：将该组路由的控制器放在 `App\Http\Controllers\Admin` 命名空间下。

```php
Route::namespace('Admin')->group(function(){
	Route::get('read',[TaskController::class,"read"]);
    Route::get('bill',[TaskController::class,"bill"]);
})
 
// 路由 变成同一样
// Route::get('read', [\App\Http\Controllers\Admin\TaskController::class, 'read']);
// Route::get('bill', [\App\Http\Controllers\Admin\TaskController::class, 'bill']);
```

**Fallback**

`fallback` 路由用于捕获所有未匹配的请求，通常用于处理 404 错误。你可以使用 `Route::fallback()` 方法来定义一个处理器，当没有其他路由匹配时，这个路由就会被执行。

```php
Route::fallback(function () {
    return redirect('/');
});
```

```php
Route::fallback(function () {
    return view('404');
});
```

**Route::current()**

```php
dump(Route::current()->uri) //获取当前 url
```



#### 重定向 Return

```php
return response()->json([

],201)
```

```php
return redirect()->to('task');
```

这是 Laravel 提供的简洁语法。

```php
return redirect('task')
```

**route()**

```php
return redirect()->route('task');
```

**back()**

**`back()`**：返回到用户之前的页面，常用于表单或权限验证失败的情况。

```php
return redirect()->back();
```

**action()**

**`action()`**：通过控制器的特定方法生成 URL 并重定向，适合应用内操作。

```php
return redirect()->action([TaskController::class, 'read']);
return redirect()->action([TaskController::class, 'index'], ['id' => 10]);
```

**away()**

**`away()`**：跳转到外部 URL（不在 Laravel 应用内）。

```php
return redirect()->away('http://www.baidu.com');
```



#### 资源控制器 API Route

**Only()**

`only()` 是用于**限制用户只能访问指定操作**，即只有特定的路由可以被访问，其他的资源操作将不可用。它可以应用于资源控制器，也可以用于其他场景中，只允许特定属性或数据操作。 **特定可以访问**

```php
Route::resource('blogs','BlogController')->only(['index','show']);
```

**Except()**

`except()` 用于**排除某些操作的访问**，即除了被排除的操作外，其他操作都可以访问。  **其他可以访问**

```php
Route::resource('blogs','BlogController')->except(['index','show']);
```

**ApiResource()**

**`apiResource`**：专用于 API，只生成与数据操作相关的路由，不生成视图路由。**没有Edit那些**

```php
Route::apiResource('blogs','BlogController');
```



#### 表单

**POST**

```php
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
```

```php+HTML
<form action="{{ route('posts.store') }}" method="POST">
    
    @csrf
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required>

    <label for="content">Content:</label>
    <textarea name="content" id="content" required></textarea>

    <button type="submit">Submit</button>
</form>
```

**PUT**

```php
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
```

```php+HTML
<form action="{{ route('posts.update', $post->id) }}" method="POST">
    @csrf
    @method('PUT')  <!-- 添加隐藏的 _method 字段 -->

    <label for="title">Title:</label>
    <input type="text" name="title" id="title" value="{{ $post->title }}" required>

    <label for="content">Content:</label>
    <textarea name="content" id="content" required>{{ $post->content }}</textarea>

    <button type="submit">Update</button>
</form>
```

```php
Route::put('/posts/{post}/{anotherParam}', [PostController::class, 'update'])->name('posts.update');
```

```php+HTML
<form action="{{ route('posts.update', ['post' => $post->id, 'anotherParam' => $anotherValue]) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="title">Title:</label>
    <input type="text" name="title" id="title" value="{{ $post->title }}" required>

    <label for="content">Content:</label>
    <textarea name="content" id="content" required>{{ $post->content }}</textarea>

    <button type="submit">Update</button>
</form>
```

**DELETE**

```php+HTML
<form action="{{ route('posts.destroy', $post->id) }}" method="POST">
    @csrf
    @method('DELETE')  <!-- 添加隐藏的 _method 字段 -->

    <p>Are you sure you want to delete this post?</p>
    <button type="submit">Delete</button>
</form>
```



#### 数据库 语法

**Find**

```php
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
```

**Create**

```php
public function store(UserRequest $request)
{
    User::create($request->all());
    return true;
}
```

**All**

```php
public function index()
{
    return User::all();
}
```

**Update**

```php
public function update(UserRequest $request)
{
    $user_id = $request->input('user_id');
    $user = User::find($user_id);
    $updateData = $request->only('name', 'email');
    return $user->update($updateData);
}
```

**Delete**

```php
public function destroy(UserRequest $request)
{
    // 禁止使用 delete function
    // 只有让用户 block account 而已
    
    $user_id = $request->input('user_id');
    $user = User::find($user_id);
    return $user->delete();
}
```

**Where**

```php
public function index()
{
    return User::where('id', 1)->get();  // 获取 id 为 1 的用户
}
```

```php
public function index()
{
    return User::where('name', 'John')->get();  // 获取 name 为 'John' 的用户
}
```

```php
public function index()
{
    return User::where('name', 'John')
               ->where('email', 'john@example.com')
               ->get();  // 获取 name 为 'John' 且 email 为 'john@example.com' 的用户
}
```

```php
public function index()
{
    return User::where('email', 'john@example.com')->first();  // 获取 email 为 'john@example.com' 的第一个用户
}
```

**pluck()**

```php
public function index()
{
    return User::where('email', 'like', '%example.com')->pluck('name');  // 获取 email 包含 'example.com' 的用户的 name 列
}
```

**orWhere**

```php
public function index()
{
    return User::where('name', 'John')
               ->orWhere('email', 'john@example.com')
               ->get();  // 获取 name 为 'John' 或 email 为 'john@example.com' 的用户
}
```

**whereBetween()**

查询用户 `age` 在 18 到 30 之间的记录

```php
public function index()
{
    return User::whereBetween('age', [18, 30])->get();
}
```

**whereIn()**

```php
public function index()
{
    return User::whereIn('id', [1, 2, 3, 4])->get();
}
```

```php
public function index()
{
    return User::whereIn('status', ['active', 'pending'])->get();
}
```

**`whereIn('status', ['active', 'pending'])`**：查询 `status` 字段为 `'active'` 或 `'pending'` 的用户。

**whereNull()**

查询 `deleted_at` 为 `NULL` 的用户（即未被软删除的记录）

```php
public function index()
{
    return User::whereNull('deleted_at')->get();
}
```

 **orderBy()**

按 `created_at` 列升序排序（从旧到新）

```php
public function index()
{
    return User::orderBy('created_at', 'asc')->get();
}
```

```php
public function index()
{
    return User::orderBy('name', 'desc')->get();
}
```

```php
public function index()
{
    return User::orderBy('role', 'asc')
               ->orderBy('name', 'desc')
               ->get();
}
```

**latest()**

`latest()` 是一个简化的 `orderBy`，默认按 `created_at` 列进行降序排序，通常用于获取最新的记录。

```php
public function index()
{
    return User::latest()->get();
}
```

按 `updated_at` 获取最新的记录

```php
public function index()
{
    return User::latest('updated_at')->get();
}
```

**inRandomOrder()**

`inRandomOrder()` 用于随机排序查询结果，通常用于获取随机数据。

```php
public function index()
{
    return User::inRandomOrder()->get();
}
```

```php
public function index()
{
    return User::inRandomOrder()->take(5)->get();
}
```

**join()**

```php
public function index()
{
    return User::join('posts', 'users.id', '=', 'posts.user_id')
               ->select('users.name', 'posts.title', 'posts.content')
               ->get();
}
```

















