# Laravel Seeder 

*Laravel seeder 是创建虚拟用户数据中SQL,可以很好的帮助程序员测试项目*

#### 安装 Factory 

```
php artisan make:factory UserFactory --model=User
```

```
public function definition(): array
{
    return [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'email_verified_at' => now(),
        'password' => static::$password ??= Hash::make('password'),
        'login_date' => now(),
        'is_disabled' => false,
    ];
}
```

#### 安装 Seeder

```
php artisan make:seeder UsersTableSeeder
```

```
$user1 = User::factory()
    ->create([
        'name' => 'fakeAccount011',
        'email' => 'fakeaccount@gmail.com',
        'email_verified_at' => now(),
        'password' => Hash::make('AccountPassword'),
        'login_date' => now(),
        'is_disabled' => false,
    ]);

$user2 = User::factory()
    ->create([
        'name' => 'fakeAdmin099',
        'email' => 'fakeadmin@gmail.com',
        'email_verified_at' => now(),
        'password' => Hash::make('AdminPassword'),
        'login_date' => now(),
        'is_disabled' => false,
    ]);

RoleUser::firstOrCreate([
    'user_id' => $user1->id,
    'role_id' => 1,
]);

RoleUser::firstOrCreate([
    'user_id' => $user2->id,
    'role_id' => 2,
]);

$FakeUsers = User::factory()
    ->count(5)
    ->create();

$FakeUsers->each(function ($user) {
    RoleUser::firstOrCreate([
        'user_id' => $user->id,
        'role_id' => mt_rand(1, 2),
    ]);
});
```

```
Role::create(['name' => 'account']);
Role::create(['name' => 'admin']);
```

### 创建虚拟数据

```
php artisan db:seed
```
*如果你只想运行特定的 seeders，你可以使用 `--class` 选项指定要运行的填充类的名称。*

```
php artisan db:seed --class=UsersTableSeeder
```

