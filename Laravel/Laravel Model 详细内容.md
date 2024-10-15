### 主

```
public function authenticators()
{
    return $this->hasMany(Authenticator::class, 'user_id');
}
```
### 副

```
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
```
### 多ID

```
public function roles()
{
    return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
}
```

拿数据

```
return $this->hasOne(Photos::class, 'product_id')
Products::with(photo)->get()
```

