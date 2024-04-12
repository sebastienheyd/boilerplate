# Usage

Once the [configuration](configuration) is done, you are able to use the [Laravel broadcasting features](https://laravel.com/docs/broadcasting) in your application.

### Client side

To use pusher in a page of your application you will must load `pusher-js` and `laravel-echo`.

To do this, simply include the load view `boilerplate::load.pusher` in pages where you need to listen broadcasted events by using the `@include` blade directive :

```
@include('boilerplate::load.pusher')
```

Then you can use Laravel Echo :

```html
<script>
whenIsLoaded('echo', () => {
    Echo.channel('MyChannelName')
        .listen('MyEvent', (e) => {
            console.log(e);
        });
}); 
</script>
```

> To be sure that `Echo` is loaded, use the function `whenIsLoaded`. This is required to avoid errors when broadcasting is not used.

### Server side

See [Using An Example Application](https://laravel.com/docs/broadcasting#using-example-application) in the Laravel documentation.