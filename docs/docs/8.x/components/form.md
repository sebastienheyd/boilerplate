# Form

```html
<x-boilerplate::form>
    // your form here...
</x-boilerplate::form>
```

Will render

```html
<form method="POST"><input name="_token" type="hidden" value="....">
    // your form here...
</form>
```

## Attributes

Attributes that can be used with this component :

| Option | Type | Default | Description |
| --- | --- | --- | --- |
| route | mixed | null | Route to use for action, can be a string or an array containing route and values |
| method | string | post | Form method to use |
| files | boolean | false | Set to true if you have files to upload in your form |

All of the attributes that are not in the list above will be added as attributes to the form tag.

**NB** : for non primitive values that not using a simple string you have to use the `:` character as a prefix :

```html
<x-boilerplate::form :route="['boilerplate.users.edit', 1]" method="put" files>
    // your form here...
</x-boilerplate::form>
```