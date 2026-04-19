# Events

The boilerplate package dispatches events on user lifecycle actions. You can listen to these events to hook into user management or extend default behaviors.

## User events

All three user events are automatically dispatched by the `User` model via the `$dispatchesEvents` property.

### UserCreated

Dispatched after a new user is created. By default, the package uses this event to automatically fetch the user's avatar from Gravatar if one exists.

```php
use Sebastienheyd\Boilerplate\Events\UserCreated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserCreated::class => [
            MyUserCreatedListener::class,
        ],
    ];
}
```

### UserSaved

Dispatched after a user record is saved (created or updated).

```php
use Sebastienheyd\Boilerplate\Events\UserSaved;

protected $listen = [
    UserSaved::class => [
        MyUserSavedListener::class,
    ],
];
```

### UserDeleted

Dispatched after a user is deleted.

```php
use Sebastienheyd\Boilerplate\Events\UserDeleted;

protected $listen = [
    UserDeleted::class => [
        MyUserDeletedListener::class,
    ],
];
```

### Listener example

Each listener receives the `User` model instance:

```php
namespace App\Listeners;

use Sebastienheyd\Boilerplate\Events\UserCreated;

class MyUserCreatedListener
{
    public function handle(UserCreated $event): void
    {
        // $event->user is the User model
    }
}
```

## RefreshDatatable

`RefreshDatatable` is a broadcasting event that triggers a real-time refresh of a DataTable on all connected clients. It is dispatched automatically when a user is saved or deleted.

You can dispatch it manually for any DataTable in your application:

```php
use Sebastienheyd\Boilerplate\Events\RefreshDatatable;

// Refresh the DataTable named "products" for all connected clients except the current one
RefreshDatatable::broadcast('products')->toOthers();

// Refresh for all connected clients including the current one
RefreshDatatable::dispatch('products');
```

The `name` argument must match the name defined when registering the DataTable.

::: tip
Broadcasting must be configured for `RefreshDatatable` to work. See the [Broadcasting configuration](../broadcasting/configuration.md) page.
:::
