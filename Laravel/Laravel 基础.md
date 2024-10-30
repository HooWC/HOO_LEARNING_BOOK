# Laravel 基础 👻

### 🌂 初步使用Laravel，需安装以下

[Node.js 安装]: https://nodejs.org/en/download/
[PHPStorm 安装]: https://www.jetbrains.com/phpstorm/download/#section=windows
[PHPStorm 免费激活码]: https://www.ajihuo.com/
[Postman 安装]: https://www.postman.com/downloads/
[xampp 安装]: https://www.apachefriends.org/download.html
[Laragon 安装]: https://laragon.org/download/index.html
[Laragon 安装步骤或者解决方法]: https://www.kreaweb.be/laragon-add-phpmyadmin/

### Laravel 安装

```
composer create-project laravel/laravel example-app
```

```
composer create-project laravel/laravel:^10.0 example-app
```

```
composer create-project laravel/laravel .
```

### Laravel 启动

```
php artisan serve
php artisan serve --port=8080
```

```
php artisan key:generate
```



### 🎲 安装 Model 命令

```
php artisan make:model <model-name> -m    (model / migrate)

php artisan make:model <model-name> -cm   (model / migration / controller)

php artisan make:model <model-name> --all
```
### 🎲 安装 Controller 命令

```
php artisan make:controller <controller-name>

php artisan make:controller <controller-name> --resource  (api)
```
### 🎲 安装 Migration 命令

```
php artisan make:migration <migration-name>

php artisan make:migration <migration-name> --table=users
```
### 💘 Migrate命令

```
php artisan migrate

php artisan migrate:fresh

//迁移后向数据库插入一些初始数据 , 重新运行所有的迁移
php artisan migrate:fresh --seed
```
### 💘 创建 虚拟数据 命令

```
php artisan db:seed

php artisan db:seed --class=ProjectNameSeeder
```

### 🍂 Model 写法

```
protected $fillable = [
        'name',
        'email',
        'password',
    ];
    
//如果没有写，系统会默认变成products
public $table = "product";
    
//不要使用就写
public $timestamps = false;
```

### 🍂 Migration 写法

```php
$table->id();
$table->bigIncrements('id'); // 大整数自增字段
$table->string('name');
$table->boolean('is_active');
$table->char('code', 10); // 固定长度的字符串
$table->date('start_date');
$table->dateTime('created_at');
$table->time('meeting_time');
$table->timestamp('last_updated');
$table->decimal('price', 8, 2);
$table->float('discount', 5, 2);
$table->enum('gender', ['male', 'female']);
$table->integer('quantity');
$table->bigInteger('total'); // 不会受到普通整数类型的数值范围限制
$table->text('description'); // 适用于较小的文本内容
$table->longText('full_text'); // 用于较大的文本内容
$table->uuid('uuid');
$table->foreignId('user_id')->constrained(); // 用于指定该外键与另一张表的关联关系。
$table->foreignId('creator_id')->constrained('users');
$table->foreign('user_id')->references('id')->on('users');

->nullable()
->unique()
->nullable()->unique()
->default('active')
->unsigned() //零和正数，而不允许负数
->onDelete('cascade')
->foreign('service_category_id')->references('id')->on('service_categories')->onDelete('cascade')

```



## ENV URL

`ENV`

```php
IDP_METADATA=http://www.saml-ip-v1.localhost/saml/metadata
IDP_LOGOUT=http://www.saml-ip-v1.localhost/logout
IDP_SPLOGOUT=http://www.saml-ip-v1.localhost/idp/logout
```

`config / services`

```php
'idp' => [
        'idp_metadata' => env('IDP_METADATA'),
        'idp_logout' => env('IDP_LOGOUT'),
        'idp_splogout' => env('IDP_SPLOGOUT'),
    ],
```

`使用`

```php
config('services.idp.idp_logout')
```



```
@include('view_名字')
@include('view_名字',['name' => 'Hoo']) #传数据

return view('view',compact('a','b')) #传数据

$items = User::with('photo')->get(); #获取function
```

### 添加 、删除  Table  某一个

```
# 修改 Products
php artisan make:migration RemoveColumnFromProducts #删除
$table->dropColumn('tests')


php artisan make:migration AddColumnToProducts #添加
$table->string('tests')
```

### Error

```
@if($errors->any())
	@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
	@endforeach
@endif
```







