# Example (private channel)

In this example, we will create an artisan command that will send a message to all users.

This message will be visible directly in the browser without refreshing the page.

## Auth

Add a broadcast route to add the authentication to the channel by adding it in the file `routes/channels.php` :

```php
Broadcast::channel('Notifications.{id}.{signature}', function ($user, $id, $signature) {
    if (channel_hash_equals($signature, 'Notifications', $id)) {
        return (int) $user->id === (int) $id;
    }

    return false;
});
```

> In this example we use a channel signature check to improve the security.

## Listener (client side)

We will use a layout overload to add the listener on each page.

Copy the file `vendor/sebastien/boilerplate/src/views/layout/index.blade.php` to the folder `resources/views/vendor/boilerplate/layout`

Then edit the copied file `resources/views/vendor/boilerplate/layout/index.blade.php` and add these lines before `</body>`

```html
@include('boilerplate::load.pusher')
<script>
    whenIsLoaded('echo', () => {
        Echo.private('{{ channel_hash('Notifications', Auth::id()) }}')
            .listen('NotifyUser', (e) => {
                growl(e.message)
            });
    });
</script>
```

## Event (server side)

To create the event, we will use the `make:event` artisan command:

```
php artisan make:event NotifyUser
```

Edit the file `app/Events/NotifyUser.php`:

```php
<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyUser implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $message;

    public function __construct($userId, $message)
    {
        $this->userId = $userId;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new PrivateChannel(channel_hash('Notifications', $this->userId));
    }
}
```

## Artisan command

Now we will create an artisan command to send notifications to the given user: 

```
php artisan make:command NotifyUser
```

Then edit the file `app/Console/Commands/NotifyUser.php` :

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\NotifyUser as NotifyUserEvent;

class NotifyUser extends Command
{
    protected $signature = 'notify:user {userId} {message}';
    protected $description = 'Send a notification to a user';

    public function handle()
    {
        NotifyUserEvent::dispatch($this->argument('userId'), $this->argument('message'));
    }
}
```

Open your browser, connect to your application and call the artisan command (in this example, 1 is the user ID, maybe yours is different):

```
php artisan notify:user 1 "Lorem ipsum dolor sit amet"
```

If everything is OK, the user 1 will see a notification with the text "Lorem ipsum dolor sit amet"