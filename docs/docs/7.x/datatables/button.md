# Button

This class allows you to generate a button.

Example:

```php
Button::add()
    ->route('boilerplate.users.edit', $user->id)
    ->icon('pencil-alt')
    ->color('primary')
    ->make(); 
```

| method | description |
| --- | --- |
| [add](#add) | Creates a new button |
| [icon](#icon) | Adds a FontAwesome icon to the button |
| [color](#color) | Sets the button color |
| [class](#class) | Sets additional class |
| [route](#route) | Sets the button link href by using a route |
| [link](#link) | Sets the button link href |
| [attributes](#attributes) | Sets HTML attributes to the button |
| [make](#make) | Renders the button |

---

## add

Creates a new button.

```php
Button::add()
```

You can specify a label:

```php
Button::add('Edit')
```

## icon

Adds a FontAwesome icon to the button:

> Available icons: [https://fontawesome.com/v5.15/icons](https://fontawesome.com/v5.15/icons)
 
You only have to specify the name of the icon:

```php
->icon('edit')
```

For other styles than `fas`, specify last letter of the class: 

```php
->icon('calendar', 'r')
```

## color

Sets the button color.

> Available colors: [https://getbootstrap.com/docs/4.0/utilities/colors/](https://getbootstrap.com/docs/4.0/utilities/colors/)

Only bootstrap4 colors are supported.

```php
->color('primary')
```

## class

Sets additional class.

```php
->class('mr-1 text-sm')
```

## route

Sets the button link href by using a route.

```php
->route('boilerplate.users.edit', $user->id)
```

## link

Sets the button link href.

```php
->link(route('boilerplate.users.edit', $user->id))
```

## attributes

Sets HTML attributes.

```php
->attributes(['data-action' => 'delete'])
```

## make

Renders the button.

```php
->make()
```

---

## Button aliases

```php
Button::show('route.to.resource.show', $resource);
```

```php
Button::edit('route.to.resource.edit', $resource);
```

```php
Button::delete('route.to.resource.destroy', $resource);
```

> `Button::delete` will show a modal to confirm the deletion. You can set another confirmation message by using the [`Datatable::locale()` method](options#locale).
