### Migration 设定用法

```
$table->string('avatar')->after('email')->nullable();
$table->dropColumn('avatar');
```



```
$table->id();
$table->string('account_name');
$table->string('secret_key')->unique();
$table->unsignedBigInteger('user_id');
$table->foreign('user_id')->references('id')->on('users');
$table->timestamps();
```

```
$table->id();
$table->unsignedBigInteger('role_id');
$table->foreign('role_id')->references('id')->on('roles');
$table->unsignedBigInteger('user_id');
$table->foreign('user_id')->references('id')->on('users');
$table->timestamps();
```

```
$table->id();
$table->string('name');
$table->string('email')->unique();
$table->timestamp('email_verified_at')->nullable();
$table->string('password');
$table->timestamp('login_date')->nullable();
$table->boolean('is_disabled')->default(false);
$table->rememberToken();
$table->timestamps();
```