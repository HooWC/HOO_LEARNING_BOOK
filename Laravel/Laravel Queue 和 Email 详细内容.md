## Laravel Queue

*在 Laravel 中，Queue 是一种异步处理任务的机制。它允许你将任务推送到队列中，然后在后台异步地处理它们，而不会阻塞当前的请求处理流程。这对于需要处理耗时任务或者与外部服务进行通信的情况非常有用*

#### 介绍

```
//简洁 传递参数
SendEmailJob::dispatch();
SendEmailJob::dispatch($data, $header);

//传递参数
dispatch(new SendEmailJob());
dispatch(new SendEmailJob($userMail));
```



#### 安装 Table

```
php artisan queue:table
```

```
.env
QUEUE_CONNECTION=database
```

#### 启动

```
php artisan queue:work
```



## 基本用法

##### 安装 Queue 文件

```
php artisan make:job SlowJob
```

##### 使用 （发送数据）

```
SalesCsvProcess::dispatch($data, $header);
```

##### Job 文件


```
class SalesCsvProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $header;

    /**
     * Create a new job instance.
     */
    public function __construct($data,$header)
    {
        $this->data = $data;
        $this->header = $header;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->data as $sale){
            $saleData = array_combine($this->header,$sale);
            Sales::create($saleData);
        }
    }
}
```

#### 启动

```
php artisan queue:work
```



## Queue 和 Email 用法

##### 安装 Event

```
php artisan make:event UserRegistered
```

##### 安装 Listener

```
php artisan make:listener SendWelcomeEmail --event=UserRegistered
```

##### 发送数据

```
Register::dispatch($user);
```

##### Event 保存数据

```
class Register
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
```

##### Listener 发送Email 请求

```
class SendRegisterEmailNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 3;

    public function __construct()
    {
        //
    }

    public function handle($event)
    {
        $email = new Register($event->user);
        Mail::to($event->user->email)->send($email);
    }

}
```

#### 启动

```
php artisan queue:work
```





## Email 用法

##### 安装 Mail 文件

```
php artisan make:mail WelcomeMail
```

##### 代码

```
class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'CodingTOTP',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.register',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
```



### Email 2

register 代码里

```
Mail::to($data->email)->send(new WelcomeMail($data->name));
```

```
class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(private $name)
    {
		//
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'CodingTOTP',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.register',
            with: ['name' => $this->name]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
```

### 发送图片

```
public function attachments(): array
{
	$attachment = public_path('images/logo.png');
    return [
    	Attachment::fromPath($attachment),
    ];
}
```





======

使用

```
php artisan queue:table
php artisan make:job JobName
```

Job

```
private $email;
private $name;

construct($email, $name)
{
	$this->email = $email;
	$this->name = $name;
}

public function handle():vold
{
	Mail::to($data->email)->send(new WelcomeMail($data->name));
}
```

Controller

```
JobName::dispatch($data->email, $data->name);
```

