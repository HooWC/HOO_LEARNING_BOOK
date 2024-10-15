### Laravel Event 和 Listener

```
php artisan make:event Name
```

```
php artisan make:listener Name
```

event

```
public $student;
construct(Students $student)
{
	$this->student = $student
}
```

listener

```
function handle(EventName $eventname)
{
	Main::to($event->student->email)->send(new Mail($event->student->name))
}
```

providers/EventServiceProvider

```
protected $listen = [
	...
	EventName::class => [
		ListenerName::class,
		如果还有其他
	]
]
```

controller

```
event(new EventName($student));
```

