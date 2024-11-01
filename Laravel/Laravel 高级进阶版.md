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

可以将耗时的任务（如发送电子邮件）推送到队列中，异步处理以提高应用性能。

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

用于过滤 HTTP 请求，例如身份验证、跨站请求伪造（CSRF）保护等。

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





### ☕  API 资源（API Resources）

API 资源为模型数据提供了一种灵活的 JSON 格式化方式，通过 `toArray` 方法定义结构，并可以附加额外的元数据。API 资源能够让你的 API 更加清晰、规范。

#### 1，创建 API 资源

使用 `make:resource` 命令生成一个 API 资源类。例如，为 `User` 模型创建一个 API 资源：

```
php artisan make:resource UserResource
```

该命令会在 `app/Http/Resources/` 目录中生成 `UserResource.php` 文件。



#### 2，定义 API 资源格式

在生成的 `UserResource.php` 文件中，使用 `toArray` 方法定义 API 资源的输出格式。你可以选择返回特定字段或自定义格式。例如：

```php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
```

在此示例中，只返回 `id`、`name`、`email` 和 `created_at` 字段。如果有敏感字段，比如密码，确保不包括在这里。



#### 3，使用 API 资源返回数据

在控制器中使用 API 资源返回模型数据。例如，在 `UserController` 中返回单个用户的数据：

```php
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }
}
```

如果你想返回一个用户集合，可以使用 `UserResource::collection` 方法：

```php
public function index()
{
    $users = User::all();
    return UserResource::collection($users);
}
```



#### 4，自定义资源集合格式（可选）

Laravel 还支持创建专用的资源集合类。你可以使用以下命令生成资源集合类：

```
php artisan make:resource UserCollection
```

在 `UserCollection.php` 中可以自定义集合返回格式。



#### 5，添加额外的元数据（可选）

可以在资源中添加额外的元数据，例如状态信息或分页数据。在资源类中可以使用 `with` 方法：

```php
public function with($request)
{
    return [
        'status' => 'success',
        'code' => 200,
    ];
}
```

#### 完整示例

创建了 `UserResource` 后，API 将返回以下格式的 JSON：

```json
{
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "johndoe@example.com",
        "created_at": "2024-10-31 12:34:56"
    },
    "status": "success",
    "code": 200
}
```





### ☕  Seeder 和 Factories

Laravel 的 Seeder 和 Factories 可以用于生成假数据，在开发和测试阶段填充数据库数据。以下是使用 Seeder 和 Factories 的详细步骤和完整代码示例。



#### 1，Factories：创建和定义工厂

Factories 用于创建模型的假数据，适合在数据库填充时生成不同的测试数据。

使用 `make:factory` 命令生成工厂。例如，为 `User` 模型生成工厂：

```
php artisan make:factory UserFactory
```

生成的工厂文件会位于 `database/factories/` 目录中。



#### 2，定义 Factory 的假数据

在生成的 `UserFactory.php` 文件中，使用 Faker 库来定义模型的假数据。以下是一个 `UserFactory` 的示例：

```php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // 默认密码
            'remember_token' => Str::random(10),
        ];
    }
}
```

在此示例中，工厂为 `User` 模型生成 `name`、`email` 等字段的假数据。



#### 3，Seeder：创建和定义数据填充

Seeder 用于在数据库中插入批量的测试数据。

使用 Artisan 命令生成 Seeder，例如生成 `UserSeeder`：

```
php artisan make:seeder UserSeeder
```

生成的 Seeder 文件会位于 `database/seeders/` 目录中。



#### 4，定义 Seeder 的数据填充逻辑

在 `UserSeeder.php` 中，调用工厂来生成多个用户记录：

```php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 使用工厂生成 10 个用户
        User::factory()->count(10)->create();
    }
}
```

这段代码会使用 `UserFactory` 创建 10 条用户记录。



#### 5，运行 Seeder

在 `DatabaseSeeder.php` 中，将 `UserSeeder` 注册到 `run` 方法中，使其在运行数据库填充时被调用：

```php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
    }
}
```

然后，运行 `db:seed` 命令执行 Seeder 并填充数据：

```
php artisan db:seed
```

你也可以单独运行指定的 Seeder：

```
php artisan db:seed --class=UserSeeder
```



#### 6， 使用 Tinker 测试 Factory（可选）

Laravel 提供了 Tinker 工具，可以用于快速生成数据。进入 Tinker 环境：

```php
php artisan tinker
```

然后运行以下命令生成单个用户：

```php
User::factory()->create();
```

或生成多个用户：

```php
User::factory()->count(5)->create();
```





### ☕  缓存（Caching）

Laravel 的缓存系统提供了多种缓存驱动支持，能够使用 `put`、`get`、`remember` 等方法来操作缓存，提高应用性能。

Laravel 的缓存系统支持多种驱动（如 Redis、Memcached、文件等），可以有效提高应用程序的性能。以下是使用缓存的详细步骤和代码示例。

#### 1，配置缓存驱动

Laravel 默认使用文件缓存，可以在 `.env` 文件中更改驱动类型。例如，将缓存驱动改为 Redis：

```
CACHE_DRIVER=redis
```

确认 `.env` 文件中的 Redis 配置正确无误。默认的 Redis 配置如下：

```php
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

确保 Redis 已在服务器上运行。如果使用其他驱动（如 Memcached），安装驱动程序并配置相应的 `.env` 设置。



#### 2，在 Laravel 中使用缓存

Laravel 提供了多个缓存方法，可以轻松操作缓存。

示例：将数据存储在缓存中

在控制器或服务中使用以下代码将数据存储到缓存中：

```php
use Illuminate\Support\Facades\Cache;

// 存储数据到缓存，有效期为 60 分钟
Cache::put('key', 'value', 60);

Cache::put('key', 'value', null); // 永久缓存

Cache::forever('key', 'value'); // 永久缓存
```

可以使用 `remember` 方法将数据缓存一段时间，如果缓存不存在则执行给定的回调并将结果缓存：

```php
Cache::remember('key', 60, function () {
    return 'value';
});
```

示例：从缓存中获取数据

使用 `get` 方法从缓存中获取数据：

```php
$value = Cache::get('key');

// 如果 key 不存在，返回默认值
$value = Cache::get('key', 'default');
```

示例：删除缓存

使用 `forget` 方法删除缓存项：

```php
Cache::forget('key');
```



#### 3，缓存集合数据

缓存查询结果等集合数据可以有效减少数据库查询。例如：

```php
$users = Cache::remember('users', 60, function () {
    return \App\Models\User::all();
});
```

上例将所有用户的数据缓存 60 分钟，之后的请求将直接从缓存中获取数据。



#### 4，Redis 特定缓存操作

如果使用 Redis 驱动，可以访问 Redis 实例进行操作：

```php
use Illuminate\Support\Facades\Redis;

// 存储值
Redis::set('key', 'value');

// 获取值
$value = Redis::get('key');
```



#### 5，清空缓存

使用 Artisan 命令清空所有缓存：

```
php artisan cache:clear
```





### ☕RabbitMQ

RabbitMQ 是一个消息代理，可以用于分布式系统中的任务队列、消息传递和异步处理。以下是如何在 Laravel 中配置和使用 RabbitMQ 的完整步骤和代码示例。

#### 1，安装 RabbitMQ 客户端库

Laravel 并没有内置对 RabbitMQ 的支持，所以需要使用社区提供的包，例如 `vladimir-yuldashev/laravel-queue-rabbitmq` 包。首先，安装该包：

```
composer require vladimir-yuldashev/laravel-queue-rabbitmq
```



#### 2，配置队列连接

在安装完成后，配置 `config/queue.php` 文件，在 `connections` 中添加 RabbitMQ 配置：

```php
'connections' => [
    'rabbitmq' => [
        'driver' => 'rabbitmq',
        'queue' => 'default', // 默认队列名称
        'connection' => 'default',
        'hosts' => [
            [
                'host' => env('RABBITMQ_HOST', '127.0.0.1'),
                'port' => env('RABBITMQ_PORT', 5672),
                'user' => env('RABBITMQ_USER', 'guest'),
                'password' => env('RABBITMQ_PASSWORD', 'guest'),
                'vhost' => env('RABBITMQ_VHOST', '/'),
            ],
        ],
        'options' => [
            'ssl_options' => [
                'cafile' => env('RABBITMQ_SSL_CAFILE', null),
                'local_cert' => env('RABBITMQ_SSL_LOCALCERT', null),
                'local_key' => env('RABBITMQ_SSL_LOCALKEY', null),
                'verify_peer' => env('RABBITMQ_SSL_VERIFY_PEER', true),
                'passphrase' => env('RABBITMQ_SSL_PASSPHRASE', null),
            ],
            'queue' => [
                'job' => \VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob::class,
            ],
        ],
    ],
],
```

在 `.env` 文件中添加以下 RabbitMQ 配置项：

```php
RABBITMQ_HOST=127.0.0.1
RABBITMQ_PORT=5672
RABBITMQ_USER=guest
RABBITMQ_PASSWORD=guest
RABBITMQ_VHOST=/
```



#### 3，创建任务队列 Job

可以使用 Laravel 的 Artisan 命令创建一个 Job 来处理任务：

```
php artisan make:job ProcessMessage
```

在 `app/Jobs/ProcessMessage.php` 文件中，定义任务的具体执行内容，例如：

```php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        // 在此处理消息
        \Log::info("Processing message: " . $this->data);
    }
}
```



#### 4，将任务放入队列

在需要使用队列的地方（例如控制器中），可以使用以下代码将任务放入队列：

```php
use App\Jobs\ProcessMessage;

Route::get('/send', function () {
    $data = 'This is a message for RabbitMQ';
    ProcessMessage::dispatch($data);
    return 'Message sent to RabbitMQ!';
});
```



#### 5，启动队列监听器

最后，使用以下命令启动队列监听器，以便处理 RabbitMQ 队列中的任务：

```php
php artisan queue:work --queue=rabbitmq
```

通过配置 `queue.php` 文件，创建 Job，并使用 `dispatch` 将任务发送到 RabbitMQ 队列中，就可以轻松地将 RabbitMQ 用作 Laravel 的队列驱动。





### ☕  服务提供者（Service Providers）



#### 1，创建服务提供者

在开发中常需要注册通用服务，比如自定义的支付处理或数据转换服务。服务提供者可以将这些服务类绑定到容器中，方便在项目的各处调用。

```
php artisan make:provider CustomServiceProvider
```

在 `app/Services/` 目录下创建 `CustomService.php`，实现基础的业务逻辑：

```php
namespace App\Services;

class CustomService
{
    public function performAction()
    {
        return "Custom Service Action Performed!";
    }
}
```

在 `CustomServiceProvider.php` 中的 `register` 方法中，将 `CustomService` 绑定到容器中：

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CustomService;

class CustomServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CustomService::class, function ($app) {
            return new CustomService();
        });
    }

    public function boot()
    {
        // 这里可以添加其他启动逻辑
    }
}
```



#### 2，注册服务提供者

**在 `config/app.php` 中注册服务提供者**：

```php
'providers' => [
    // 其他服务提供者
    App\Providers\CustomServiceProvider::class,
],
```

在控制器或其他位置注入 `CustomService`，然后调用其 `performAction` 方法：

```php
namespace App\Http\Controllers;

use App\Services\CustomService;

class ExampleController extends Controller
{
    protected $customService;

    public function __construct(CustomService $customService)
    {
        $this->customService = $customService;
    }

    public function index()
    {
        return $this->customService->performAction();
    }
}
```





### ☕  模型观察者（Observers）

如果你在开发中使用 Laravel 内置的 `php artisan serve` 来运行本地服务器，那么信息会显示在启动 `php artisan serve` 的命令行窗口中。

模型观察者（Observers）用于在模型事件（如创建、更新、删除等）发生时执行特定操作。使用观察者可以将业务逻辑从控制器中剥离出来，使代码更清晰、易维护。以下是详细步骤和代码示例：



#### 1，创建 Observer

Laravel 提供 Artisan 命令来快速生成观察者文件。假设你有一个 `User` 模型，并希望监听用户创建和删除事件。

```
php artisan make:observer UserObserver --model=User
```

执行该命令后，Laravel 会在 `app/Observers` 目录下生成 `UserObserver.php` 文件，并自动将其与 `User` 模型关联。



#### 2，定义 Observer 方法

打开 `app/Observers/UserObserver.php` 文件，定义在特定事件发生时要执行的操作。例如，在用户创建和删除时记录相关操作：

```
<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    // 监听用户创建事件
    public function created(User $user)
    {
        // 执行创建时的逻辑
        echo "User created with ID: " . $user->id;
    }

    // 监听用户删除事件
    public function deleted(User $user)
    {
        // 执行删除时的逻辑
        echo "User deleted with ID: " . $user->id;
    }
}
```



#### 3，在服务提供者中注册 Observer

为了使观察者生效，你需要在 `AppServiceProvider` 或自定义的服务提供者中注册它。在 `App\Providers\AppServiceProvider` 中的 `boot` 方法里，注册 `UserObserver`：

```
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        User::observe(UserObserver::class);
    }

    public function register()
    {
        //
    }
}
```



#### 4，测试 Observer

你可以通过创建或删除用户来测试观察者。打开 Laravel Tinker 或在控制器中执行以下代码来观察效果：

```
php复制代码// 创建用户
$user = \App\Models\User::create([
    'name' => 'John Doe',
    'email' => 'johndoe@example.com',
    'password' => bcrypt('password')
]);

// 删除用户
$user->delete();
```

观察者会在创建或删除操作执行时触发 `created` 和 `deleted` 方法，输出相应的消息。



#### 常见用法示例

除了创建和删除，观察者还可以监听其他事件，比如 `updated`、`saving`、`restoring` 等。你可以根据需要在 `UserObserver` 中定义相应方法：

```
php复制代码public function updated(User $user)
{
    echo "User updated with ID: " . $user->id;
}
```

这样，模型观察者就可以帮助你在模型事件触发时执行特定的操作，使得代码逻辑更具模块化和清晰性。



### ☕  自定义命令（Artisan Commands）

自定义 Artisan 命令允许你扩展 Laravel 的命令行工具，非常适合执行定时任务、批量处理数据等。以下是创建自定义命令的详细步骤和代码示例：



#### 1，生成自定义命令

使用 Artisan 命令来生成一个新的命令类：

```
php artisan make:command CustomCommand
```

运行后，Laravel 会在 `app/Console/Commands` 目录下创建一个 `CustomCommand.php` 文件。



#### 2，定义命令的名称和功能

打开 `app/Console/Commands/CustomCommand.php`，修改命令的名称、描述和处理逻辑：

```
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CustomCommand extends Command
{
    // 定义命令的名称，用于在命令行中调用
    protected $signature = 'custom:run';

    // 命令的描述信息，会显示在 `php artisan list` 中
    protected $description = 'Execute a custom command';

    // 命令的处理逻辑
    public function handle()
    {
        // 这里编写命令的实际逻辑
        $this->info('Custom Command Executed Successfully!');
    }
}
```

- **`$signature`**：定义命令的调用名称，例如 `custom:run`。
- **`$description`**：命令的描述信息，可以帮助理解命令的用途。
- **`handle` 方法**：命令的实际处理逻辑。这里可以添加任何需要的业务逻辑，例如查询数据库、处理数据等。



#### 3，注册自定义命令

在 `app/Console/Kernel.php` 中，将自定义命令注册到 `$commands` 数组：

```
protected $commands = [
    \App\Console\Commands\CustomCommand::class,
];
```

注册后，Laravel 就能识别并使用这个自定义命令。



#### 4，执行自定义命令

现在可以通过以下命令在终端中运行自定义命令：

```
php artisan custom:run
```

执行后，终端会输出 `Custom Command Executed Successfully!`，表示命令已成功运行。



#### 5，另一个例子

另一个例子，演示如何创建一个自定义 Artisan 命令，用于从一个 API 获取数据并将其存储到数据库中。假设我们要创建一个命令来获取用户数据并将其插入到 `users` 表中。



##### 5.1，生成自定义命令

首先，生成一个新的自定义命令：

```
php artisan make:command FetchUsers
```

这将在 `app/Console/Commands` 目录下创建一个名为 `FetchUsers.php` 的文件。



##### 5.2，定义命令的名称和功能

打开 `app/Console/Commands/FetchUsers.php` 文件，修改命令的名称、描述和处理逻辑：

```
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class FetchUsers extends Command
{
    // 定义命令的名称
    protected $signature = 'fetch:users';

    // 命令的描述
    protected $description = 'Fetch users from an external API and store them in the database';

    // 命令的处理逻辑
    public function handle()
    {
        // 调用外部 API 获取用户数据
        $response = Http::get('https://jsonplaceholder.typicode.com/users');

        if ($response->successful()) {
            $users = $response->json();

            foreach ($users as $userData) {
                // 将用户数据插入到数据库
                User::updateOrCreate(
                    ['email' => $userData['email']], // 唯一标识符
                    [
                        'name' => $userData['name'],
                        'username' => $userData['username'],
                        'address' => json_encode($userData['address']),
                    ]
                );
            }

            $this->info('Users fetched and stored successfully!');
        } else {
            $this->error('Failed to fetch users from the API.');
        }
    }
}
```

##### 代码解析

- **`$signature`**：定义命令的调用名称为 `fetch:users`。

- **`$description`**：描述命令的作用。

- `handle` 方法

  - 使用 Laravel 的 HTTP 客户端从指定的 API（这里使用 JSONPlaceholder 的示例 API）获取用户数据。

  - 如果请求成功，遍历用户数据并使用 `updateOrCreate` 方法将用户信息插入到数据库。如果用户已经存在（根据 email 字段），则更新该用户的信息。

  - 输出成功或失败的消息。

    

##### 5.3，注册自定义命令

在 `app/Console/Kernel.php` 文件中，将自定义命令注册到 `$commands` 数组：

```
protected $commands = [
    \App\Console\Commands\FetchUsers::class,
];
```



##### 5.4，执行自定义命令

现在可以通过以下命令在终端中运行自定义命令：

```
php artisan fetch:users
```

执行后，命令会从 API 获取用户数据并将其存储到数据库中。终端会显示 `Users fetched and stored successfully!` 表示操作成功。

##### 应用场景

这个命令可以用于定期同步外部 API 的用户数据到你的应用中，例如在用户注册、更新信息或进行数据分析时保持数据一致性。你可以结合 Laravel 的任务调度（Scheduler）将此命令设置为定时运行，确保你的数据库始终与外部数据源保持同步。







### ☕  用户头像

下面是一个详细的步骤和代码示例，用于处理用户头像上传，并将头像图片保存到 Laravel 应用中。



#### 1，创建数据库字段

首先，确保你的用户表中有一个字段用于存储头像的路径。如果你还没有这个字段，可以通过迁移来添加。

在终端中运行以下命令创建迁移：

```
php artisan make:migration add_avatar_to_users_table --table=users
```

然后，在生成的迁移文件中添加 `avatar` 字段：

```
// database/migrations/xxxx_xx_xx_xxxxxx_add_avatar_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvatarToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable(); // 添加头像字段
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar'); // 删除头像字段
        });
    }
}
```

运行迁移命令以更新数据库：

```
php artisan migrate
```



#### 2，创建头像上传控制器

接下来，创建一个控制器来处理头像上传。在终端中运行：

```
php artisan make:controller AvatarController
```

在生成的 `AvatarController` 中添加以下代码：

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function upload(Request $request)
    {
        // 验证请求中的文件
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 获取当前用户
        $user = Auth::user();

        // 处理上传的头像
        if ($request->hasFile('avatar')) {
            // 删除旧头像
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }

            // 上传新头像
            $path = $request->file('avatar')->store('avatars'); // 存储在 storage/app/avatars

            // 更新用户头像路径
            $user->avatar = $path;
            $user->save();
        }

        return response()->json(['message' => '头像上传成功', 'avatar' => $path]);
    }

    public function getAvatar()
    {
        // 获取当前用户的头像
        $user = Auth::user();
        return response()->json(['avatar' => $user->avatar]);
    }
}
```



#### 3，路由配置

在 `routes/web.php` 或 `routes/api.php` 中添加相应的路由：

```php
use App\Http\Controllers\AvatarController;

Route::middleware('auth:sanctum')->post('/upload-avatar', [AvatarController::class, 'upload']);
Route::middleware('auth:sanctum')->get('/get-avatar', [AvatarController::class, 'getAvatar']);
```



#### 4，前端上传表单示例

你可以使用 HTML 表单或 JavaScript/Axios 来上传头像。以下是一个简单的 HTML 表单示例：

```html
<form id="avatar-form" enctype="multipart/form-data">
    @csrf
    <input type="file" name="avatar" id="avatar" required>
    <button type="submit">上传头像</button>
</form>

<script>
    document.getElementById('avatar-form').addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        
        fetch('/upload-avatar', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Laravel CSRF token
            },
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
```



#### 5，获取头像

要获取当前用户的头像，可以调用 `getAvatar` 方法：

```javascript
fetch('/get-avatar', {
    method: 'GET',
    headers: {
        'Authorization': 'Bearer ' + token, // 替换为你的 Bearer Token
    },
})
.then(response => response.json())
.then(data => {
    if (data.avatar) {
        console.log('用户头像路径:', data.avatar);
    }
});
```



#### 6，显示头像

你可以通过生成的头像路径来显示头像，例如：

```html
<img src="{{ asset($user->avatar) }}" alt="用户头像" />
```

### 总结

以上步骤展示了如何在 Laravel 中实现用户头像上传的功能，包括数据库迁移、控制器、路由配置和前端代码示例。通过这些代码，用户可以上传、保存和获取他们的头像。根据需要，可以进一步扩展这个功能，例如添加更多的验证、调整存储路径等。





### ☕   middleware('auth:sanctum')

`middleware('auth:sanctum')` 是 Laravel 中的一种中间件，用于保护你的路由，使其只能被经过身份验证的用户访问。具体来说，`sanctum` 是 Laravel 提供的一个轻量级身份验证系统，特别适合 API 的开发。

验证用户身份。

记录请求信息。

修改请求或响应。

**`auth:api`**：适合需要复杂认证的应用，通常与 Passport 结合使用。

**`auth:sanctum`**：适合快速、简单的应用，通常用于 SPA 或移动应用，使用 Laravel Sanctum 提供的简单令牌认证

选择哪一个取决于你的应用需求和复杂性。如果你的应用只需要基本的用户认证，使用 Sanctum 会更简单快捷；如果需要更复杂的 OAuth2 功能，则应选择 Passport。

使用 `middleware('auth:sanctum')` 和 `HasApiTokens` 进行 API 身份验证的步骤如下。这将包括安装 Sanctum、设置用户模型、创建令牌，以及保护路由。



#### 1，安装 Laravel Sanctum

在你的 Laravel 项目中，首先通过 Composer 安装 Sanctum：

```
composer require laravel/sanctum
```



#### 2，发布 Sanctum 配置

安装完成后，发布 Sanctum 的配置文件和迁移文件：

```
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```



#### 3，运行数据库迁移

运行数据库迁移以创建必要的表：

```
php artisan migrate
```



#### 4，配置身份验证守卫

在 `config/auth.php` 文件中，将 API 守卫设置为使用 Sanctum：

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'sanctum', // 设置 API 守卫为 Sanctum
        'provider' => 'users',
    ],
],
```



#### 5，在用户模型中使用 `HasApiTokens` Trait

在用户模型（通常是 `App\Models\User`）中引入 `HasApiTokens` 特性：

```php
namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens; // 引入 HasApiTokens 特性

    // 其他模型属性和方法
}
```



#### 6，创建用户令牌

在控制器中为用户创建令牌。以下是一个示例控制器，用于用户登录并生成令牌：

```php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // 创建令牌
            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
```



#### 7，保护路由

在路由文件中使用 `middleware('auth:sanctum')` 保护需要身份验证的路由。例如，保护一个获取用户信息的路由：

```php
php复制代码use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(); // 返回当前登录用户的信息
});
```



#### 8，使用 API 令牌进行请求

在客户端（例如，Postman 或前端应用）中，使用生成的令牌进行 API 请求。在请求头中添加 `Authorization` 字段：

```
Authorization: Bearer your-token-here
```

### 

#### 撤销令牌

你可以通过以下方式撤销用户的令牌：

```php
// 撤销所有令牌
$user->tokens()->delete();

// 或者撤销特定令牌
$token = $user->tokens()->find($tokenId);
$token->delete();
```

#### 总结

通过以上步骤，你可以成功使用 `middleware('auth:sanctum')` 和 `HasApiTokens` 特性来实现 API 的身份验证。Laravel Sanctum 提供了一种简单而有效的方式来管理 API 令牌，适用于单页应用（SPA）和移动应用。









































































































































































































































