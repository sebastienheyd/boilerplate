# Broadcasting

In many modern web applications, WebSockets are used to implement realtime, live-updating user interfaces. When some data is updated on the server, a message is typically sent over a WebSocket connection to be handled by the client. WebSockets provide a more efficient alternative to continually polling your application's server for data changes that should be reflected in your UI.

[Laravel broadcasting features](https://laravel.com/docs/broadcasting) makes it easy to "broadcast" your server-side events over a WebSocket connection.

This package adds some extra features to make it even easier.

## Configuration

This package will only support the "pusher" driver.

> You can create a [Pusher account](https://dashboard.pusher.com/accounts/sign_up) or use [Soketi](https://docs.soketi.app/) if you don't want to be limited.

Once your application has been created, transfer its parameters to your `.env` file :

```
PUSHER_APP_ID=your-pusher-app-id
PUSHER_APP_KEY=your-pusher-key
PUSHER_APP_SECRET=your-pusher-secret
PUSHER_APP_CLUSTER=mt1
```

Also in you `.env` file, set the broadcast driver to pusher :

```
BROADCAST_DRIVER=pusher
```


**NB**: The broadcast service provider will be loaded automatically when the broadcast driver is set to `pusher`.