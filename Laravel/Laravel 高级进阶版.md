## Laravel 高级进阶版





### ☕ 任务调度（Scheduler）

#### 1，配置 Scheduler

打开 `app/Console/Kernel.php` 文件，你会看到 `schedule` 方法，这里是定义任务的地方：

```php
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // 每天早上8点执行 report:daily 命令
        //$schedule->command('report:daily')->dailyAt('08:00');
        $schedule->command('report:daily')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
```

#### 2，SendDailyReport

```
php artisan make:command SendDailyReport
```

```php
<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyReport extends Command
{
// 命令签名
    protected $signature = 'report:daily';

    // 命令描述
    protected $description = 'Send daily report email to all users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('开始发送每日报告邮件');

        // 获取所有用户
        $users = User::all();
        $this->info('找到用户数量: ' . $users->count());

        if ($users->isEmpty()) {
            $this->error('没有找到用户。');
            return;
        }

        foreach ($users as $user) {
            try
            {
                Mail::raw('这是您的日报告内容', function ($message) use ($user) {
                    $message->to($user->email)
                        ->from(config('services.mail.mail_gmail'), config('services.mail.mail_name'),)
                        ->subject('每日报告');
                });
                $this->info('邮件成功发送给: ' . $user->email);
            }
            catch (\Exception $e)
            {
                $this->error('邮件发送失败给 ' . $user->email . ': ' . $e->getMessage());
            }
        }

        $this->info('每日报告邮件发送成功。');
    }
}
```

#### 3，ENV 设置

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ex_sh
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=11db8c1f10c50d
MAIL_PASSWORD=667fe814a795e7
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=HooBusiness@example.com
MAIL_FROM_NAME=Hoo
```

#### 4，php artisan migrate

创建用户

#### 5，启动 Scheduler

```
php artisan schedule:run
```



#### 自动执行 `php artisan report:daily`

在 Windows 环境中，可以使用 **任务计划程序** 来设置定时任务。

#### 设置步骤：

1. **打开任务计划程序**：按下 `Win + R` 键，输入 `taskschd.msc` 并按回车。

2. **创建基本任务**：

   - 点击右侧的 **“创建基本任务”**。
   - 输入任务名称，例如 “Laravel Report Daily”。

3. **设置触发器**：

   - 在触发器页面，选择 **“每天”** 或其他所需频率。
   - 指定开始时间，例如 `08:00`。

4. **设置操作**：

   - 在操作页面，选择 **“启动程序”**。

   - 程序或脚本路径输入你的 PHP 可执行文件路径，例如 `D:\php-8.3.10\php.exe`。

   - 添加参数处输入 

     ```
     artisan report:daily
     ```

     ，例如：

     ```
     D:\Code\Laravel P\example-app2\artisan report:daily
     ```

5. **保存并完成**





### ☕ 事件与监听器（Event & Listener）

#### 场景：用户注册后发送欢迎邮件

当新用户注册后，我们触发一个事件 `UserRegistered`，然后监听器 `SendWelcomeEmail` 会捕获该事件并发送一封欢迎邮件。



#### 1， 安装

```
php artisan make:event UserRegistered
php artisan make:listener SendWelcomeEmail --event=UserRegistered
```



#### 2，定义事件和监听器逻辑

打开 `app/Events/UserRegistered.php` 并编辑如下内容：

```php
namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    use Dispatchable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
```



#### 3，在监听器文件中编写发送邮件的逻辑

打开 `app/Listeners/SendWelcomeEmail.php` 文件，添加如下代码：

```php
namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
        // 可选的：在构造函数中进行初始化
    }

    public function handle(UserRegistered $event)
    {
        $user = $event->user;

        Mail::raw('欢迎来到我们的网站！', function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('欢迎！');
        });
    }
}
```



#### 4，注册事件和监听器

打开 `app/Providers/EventServiceProvider.php`，在 `$listen` 数组中注册事件和监听器：

```php
namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserRegistered::class => [
            SendWelcomeEmail::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
```



5，触发事件

在用户注册的逻辑中触发 `UserRegistered` 事件。比如在用户控制器中添加如下代码：

```php
php artisan make:controller UserController
```

```php
<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create($request->only('name', 'email', 'password'));

        event(new UserRegistered($user));

        return response()->json(['message' => '注册成功！']);
    }
}
```

api.php

```php
Route::post('register', [\App\Http\Controllers\UserController::class, 'register']);
```

通过 Postman 或命令行测试注册请求，确认是否收到欢迎邮件。





### ☕  授权策略（Policies）

在 Laravel 中使用授权策略 (Policies) 可以帮助你更好地管理用户权限。下面是创建并使用策略的详细步骤和代码。

#### 1，安装

```
php artisan make:policy PostPolicy
```

这会在 `app/Policies` 目录中创建 `PostPolicy.php` 文件。



#### 2，定义策略方法

打开 `app/Policies/PostPolicy.php`，在策略中定义用户权限逻辑。以下示例展示了检查用户是否拥有更新和删除特定 `Post` 的权限：

```php
<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * 判断用户是否可以更新帖子
     */
    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    /**
     * 判断用户是否可以删除帖子
     */
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
```



#### 3，注册策略

打开 `AuthServiceProvider` 文件 (`app/Providers/AuthServiceProvider.php`)，并在 `$policies` 数组中注册 `PostPolicy`：

```php
<?php

namespace App\Providers;

use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Post::class => PostPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
```



#### 4，使用策略进行授权检查

在控制器中，你可以使用策略检查用户的权限。

例如，在 `PostController` 中使用 `authorize` 方法：

```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function update(Request $request, Post $post)
    {
        // 检查用户是否有权限更新帖子
        $this->authorize('update', $post);

        // 进行更新操作
        $post->update($request->all());

        return response()->json(['message' => '帖子更新成功']);
    }

    public function delete(Post $post)
    {
        // 检查用户是否有权限删除帖子
        $this->authorize('delete', $post);

        // 进行删除操作
        $post->delete();

        return response()->json(['message' => '帖子删除成功']);
    }
}
```



#### 5，在 Blade 模板中使用策略

在 Blade 模板中可以使用 `@can` 指令来检查策略权限：

```php
@can('update', $post)
    <a href="{{ route('posts.edit', $post) }}">编辑帖子</a>
@endcan

@can('delete', $post)
    <form action="{{ route('posts.destroy', $post) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">删除帖子</button>
    </form>
@endcan
```





### ☕  实时事件广播（Broadcasting）x

在 Laravel 中，实时事件广播 (Broadcasting) 可以将服务器端事件广播到前端，让客户端实时接收并响应事件。这对实现实时更新的功能（如通知、聊天等）非常有用。以下是使用 Laravel Broadcasting 实现实时事件广播的详细步骤和代码。

实时事件广播 (Broadcasting) 是一种机制，允许 Laravel 应用程序将事件的发生实时通知给客户端应用，比如网页或移动应用。这样可以实现像实时聊天、通知推送等功能，而无需客户端不断轮询服务器获取更新。Pusher 是一个非常常用的第三方服务，可以让 Laravel 更加轻松地实现事件广播。

需要注册 Pusher

#### 1，安装

```
npm install
npm install vite --save-dev
composer require pusher/pusher-php-server
```

```
php artisan make:model Message -m
```

编辑 `Message` 模型

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

在此模型中，`user_id` 表示消息发送者，`content` 是消息内容。你可以根据需求自定义字段。

创建 Messages 表的迁移文件

```php
public function up()
{
    Schema::create('messages', function (Blueprint $table) {
    	$table->id();
    	$table->unsignedBigInteger('user_id');
    	$table->text('content');
    	$table->timestamps();
	});
}
```

```
php artisan migrate
```



#### 2， 配置广播驱动

```
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1
```



#### 3，设置广播事件

```
php artisan make:event MessageSent
```

在生成的事件类（如 `app/Events/MessageSent.php`）中，实现 `ShouldBroadcast` 接口：

```php
<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('chat');
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }
}
```



#### 4，触发事件

在需要触发事件的地方调用 `event(new MessageSent($message))`。例如，在 `MessageController` 中发送新消息时触发事件：

```
php artisan make:controller MessageController
```

```php
<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $message = Message::create([
            'user_id' => $request->user()->id,
            'content' => $request->input('content'),
        ]);

        // 广播事件
        event(new MessageSent($message));

        return response()->json(['message' => '消息发送成功！']);
    }
}
```



#### 5，前端监听广播事件

使用 Laravel Echo 和 Pusher 在前端接收广播事件。首先安装 Laravel Echo 和 Pusher JavaScript SDK：

```
npm install --save laravel-echo pusher-js
```

在前端 JavaScript 文件中初始化 Echo 并监听事件。例如，在 `resources/js/app.js` 中：

```js
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});

window.Echo.channel('chat')
    .listen('.message.sent', (e) => {
        console.log('新消息:', e.message);
    });
```



#### 6，运行广播服务

```
npm run dev
```

```
npm install --save laravel-echo pusher-js
```

.env

```
VITE_PUSHER_APP_KEY=your-app-key
VITE_PUSHER_APP_CLUSTER=your-app-cluster
```

cmd

```
composer require beyondcode/laravel-websockets --with-all-dependencies
```

```
php artisan websockets:serve
```

```
php artisan serve
```





### ☕  OAuth 2.0 / Laravel Passport

是的，Laravel Passport 确实提供了 `createToken` 方法，允许在 OAuth 2.0 的实现中创建访问令牌。这种方法非常适合为用户生成“个人访问令牌”（Personal Access Token），通常用于 API 认证。

#### 1，安装

```
composer require laravel/passport
```



#### 2，配置 Passport

```
php artisan migrate
```

**生成加密密钥**：生成 Passport 所需的加密密钥。

```
php artisan passport:install
```



#### 3，添加 Passport 服务提供者

在 `config/app.php` 文件中的 `providers` 数组中添加：

```php
Laravel\Passport\PassportServiceProvider::class,
```



#### 4，配置 Auth

在 `config/auth.php` 文件中，将 `api` 认证驱动设置为 `passport`：

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],
```



#### 5，设置 User 模型

```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    // 其他模型代码...
}
```



#### 6，定义路由

在 `routes/api.php` 中，定义 Passport 路由：

```php
use Laravel\Passport\RouteRegistrar;

Route::group(['middleware' => ['auth:api']], function () {
    // 需要认证的路由
});

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
```



#### 7，创建认证控制器

创建一个控制器来处理注册和登录：

```php
php artisan make:controller AuthController
```

然后在 `AuthController` 中实现注册和登录逻辑：

```php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json(['token' => $token]);
    }
}
```



#### 8，测试 API

你可以使用 Postman 或任何 API 客户端测试注册和登录 API：

**注册**：

- 请求类型：POST
- URL：`http://your-domain/api/register`
- 请求体：

```json
{
    "name": "Your Name",
    "email": "your-email@example.com",
    "password": "your-password",
    "password_confirmation": "your-password"
}
```

**登录**：

- 请求类型：POST
- URL：`http://your-domain/api/login`
- 请求体：

```json
{
    "email": "your-email@example.com",
    "password": "your-password"
}
```

返回的 JSON 中将包含一个 `token`，你可以使用这个令牌进行身份验证。



#### 9，保护路由

在需要保护的路由中添加 `auth:api` 中间件。例如：

```php
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
```







### ☕  任务队列（Queues）

通过这些步骤，你就可以在 Laravel 中创建和使用任务队列。异步处理任务可以显著提高系统的响应速度，同时保持后台任务的处理效率。



#### 1，配置队列驱动

在 `config/queue.php` 文件中，Laravel 提供了多种队列驱动，包括数据库、Redis、Beanstalkd 等。开发环境常用 `database` 驱动。确保 `.env` 文件中设置了适当的驱动，例如：

```
QUEUE_CONNECTION=database
```



#### 2，创建队列表

如果使用 `database` 驱动，请先生成队列表：

```
php artisan queue:table
php artisan migrate
```

生成的表 `jobs` 将保存队列任务的信息。



#### 3，创建队列任务

使用 Artisan 命令创建一个队列任务类。例如，这里创建一个任务用于发送电子邮件：

```
php artisan make:job SendEmailJob
```

此命令会在 `app/Jobs/` 目录中生成 `SendEmailJob.php` 文件。



#### 4，编写队列任务逻辑

在生成的 `SendEmailJob` 类中，编写任务的逻辑。假设我们要发送一封电子邮件，可以使用如下代码：

```php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        Mail::to($this->user->email)->send(new \App\Mail\WelcomeEmail($this->user));
    }
}
```

在此代码中，`handle` 方法定义了任务执行的具体逻辑。我们在这里使用 Laravel 的邮件发送功能给用户发送一封欢迎邮件。



#### 5，调度队列任务

在应用中使用任务时，可以通过 `dispatch` 方法将任务推送到队列。比如，在用户注册后发送欢迎邮件：

```php
use App\Jobs\SendEmailJob;
use App\Models\User;

$user = User::find(1); // 示例用户
SendEmailJob::dispatch($user);
```



#### 6，运行队列任务

使用 `queue:work` 命令启动队列工作者来处理队列任务：

```
php artisan queue:work
```

`queue:work` 命令将会监听队列，并处理队列中的任务。



#### 7，设置任务失败重试（可选）

若需要任务失败时自动重试，可以在任务类中定义 `$tries` 和 `$timeout` 属性：

```php
class SendEmailJob implements ShouldQueue
{
    public $tries = 3; // 最大尝试次数
    public $timeout = 120; // 超时时间（秒）
    // ...
}
```



#### 8，失败任务处理（可选）

可以使用 `queue:failed-table` 创建失败任务的数据库表：

```
php artisan queue:failed-table
php artisan migrate
```





### ☕  中间件（Middleware）

Laravel 中间件提供了对请求的灵活控制，允许你在请求处理过程中插入自定义逻辑，比如认证、日志记录、跨站点请求保护等。通过中间件，Laravel 能有效地增强应用程序的安全性和可维护性。

#### 1，创建中间件

```
php artisan make:middleware CheckAdmin
```

该命令会在 `app/Http/Middleware` 目录中生成 `CheckAdmin.php` 文件。



#### 2，编写中间件逻辑

在生成的 `CheckAdmin.php` 文件中，编写中间件的逻辑。这个示例将检查用户是否为管理员，如果不是管理员，则返回 403 错误。

```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // 检查用户是否已登录并为管理员
        if (!Auth::check() || !Auth::user()->is_admin) {
            // 如果不是管理员，返回 403 错误
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // 如果是管理员，继续请求
        return $next($request);
    }
}
```

```php
Schema::table('users', function (Blueprint $table) {
        $table->boolean('is_admin')->default(false); // 默认不是管理员
    });
```



#### 3，注册中间件

打开 `app/Http/Kernel.php` 文件，将中间件注册为路由中间件。在 `$routeMiddleware` 数组中添加：

```php
protected $routeMiddleware = [
    // 其他中间件
    'admin' => \App\Http\Middleware\CheckAdmin::class,
];
```

这样就可以使用 `admin` 作为中间件别名在路由中调用 `CheckAdmin`。



#### 4，应用中间件到路由

可以将中间件应用到单个路由或路由组。例如，在 `routes/web.php` 中应用 `admin` 中间件：

```php
use Illuminate\Support\Facades\Route;

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/settings', [AdminController::class, 'settings']);
});
```

或者将中间件应用到单个路由：

```php
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware('admin');
```



#### 5，全局中间件（可选）

如果需要在所有请求上应用中间件，可以将中间件添加到 `app/Http/Kernel.php` 文件中的 `$middleware` 数组中：

```php
protected $middleware = [
    // 全局中间件
    \App\Http\Middleware\CheckAdmin::class,
];
```

这样每个请求都会先通过 `CheckAdmin` 进行检查。































































