# Dashboard widget usage

After generating a widget using the artisan command, you can edit its files. [By following the generation example](generate_widget.md), we obtain the following class:

---

## Widget class

```php
<?php

namespace App\Dashboard;

use Illuminate\Http\Request;
use Sebastienheyd\Boilerplate\Dashboard\Widget;

class MyAwesomeWidget extends Widget
{
    protected $slug = 'my-awesome-widget';
    protected $label = "my-awesome-widget label";
    protected $description = "my-awesome-widget description";
    protected $view = 'dashboard.widgets.my-awesome-widget';
    protected $editView = 'dashboard.widgets.my-awesome-widgetEdit';
    protected $size = 'sm';
    protected $permission = null;

    protected $parameters = [
        'color'    => 'primary',
    ];

    public function make()
    {
        // $this->assign('myVar', 'myValue');
    }

    public function validator(Request $request)
    {
        return validator()->make($request->post(), [
            'color' => 'required'
        ]);
    }
}
```

---

## Properties

| property | type | description |
| --- | --- | --- |
| [slug](#slug) | string | String used to identify the widget. |
| [label](#label) | string | Widget label, used to identify the widget in the selection modal. |
| [description](#description) | string | Widget description, used to identify the widget in the selection modal. |
| [view](#view) | string | View that will be used to render the widget. |
| [viewEdit](#viewEdit) | string | View that will be used to edit the widget parameters. |
| [size](#size) | string | Size of the widget. |
| [permission](#permission) | string | Permission to check to show the widget. |
| [parameters](#parameters) | array | Array of widget parameters and default values. |
| [width](#width) | array | Array of sizes to use. |

### slug

The `slug` will serve to identify the widget. For example, we can use it to call the widget in the [configuration file](../configuration/dashboard.md) and thus build the default dashboard.

The slug is also used to save the widget's settings for the current user.

### label

The widget label, used only in the modal window for selecting dashboard widgets.

It can be a localization string.

### description

Similar to the label, the description is used only in the modal window for selecting dashboard widgets.

It can be a localization string.

### view

Blade view used to render the widget.

### viewEdit

Blade view used to render the form for editing widget settings. The posted parameters will be automatically captured and assigned to the widget.

It is recommended to use string-type parameters only.

### size

Widget dimension, can be `xxs`, `xs`, `sm`, `md`, `xl`, `xxl`.

The corresponding table used is the one defined by the [width](#width) property.

Default value is `md`

### permission

Permission to be used to verify that the current user is authorized to use the widget.

Default value is null.

### parameters

Array of editable widget parameters. Used to define default values.

Default value is an empty array.

### width

Array of dimensions that the widget can use. This involves assigning Bootstrap column dimensions to use for each breakpoint. Default:

```php
[
    'xxs' => ['sm' => 4, 'md' => 4, 'xl' => 2, 'xxl' => 2],
    'xs'  => ['sm' => 6, 'md' => 6, 'xl' => 4, 'xxl' => 3],
    'sm'  => ['sm' => 12, 'md' => 6, 'xl' => 6, 'xxl' => 4],
    'md'  => ['sm' => 12, 'md' => 6, 'xl' => 6, 'xxl' => 6],
    'xl'  => ['sm' => 12, 'md' => 12, 'xl' => 8, 'xxl' => 8],
    'xxl' => ['sm' => 12, 'md' => 12, 'xl' => 12, 'xxl' => 12],
]
```

You can define specific dimensions and call them like this:

```php
protected $width = ['md' => ['sm' => 6, 'md' => 6, 'xl' => 4]];
protected $size = 'md';
```

---

## Assign values to the view

By default, all values from the [parameters](#parameters) array are assigned to the view. If user settings exist, they will override the default parameters.

Before rendering the widget view, we will call the `make()` method in the widget class.

In this method, by using the method `assign()` it is possible to assign values to the view from various sources such as the database.

But it is also possible to override the default parameters and user parameters by using the `set()` method.

```php
public function make()
{
    $count = User::count();

    // Assign number of users to the view.
    $this->assign('count', $count);
    
    // Change color (will override the default parameters and the user settings)
    $this->set('color', $count === 0 ? 'danger' : 'primary');
}
```

---

## User settings

The current user can define settings for each widget.

To do this, it is sufficient to first declare the default parameters in the widget's class (see above).

Once the parameters array is defined, you can create or edit the view for editing these settings.

In the view, the necessary input fields will be added for editing the widget's settings.

User settings are stored in the `users` table in the `settings` field.

Example:

```php
    protected $editView = 'dashboard.widgets.my-awesome-widgetEdit';

    protected $parameters = [
        'color'    => 'primary',
    ];
```

And the content of the view:

```php
<x-boilerplate::input type="select" name="color" label="Color" :value="$color ?? 'primary'" :options="['primary', 'danger', 'secondary']" />
```