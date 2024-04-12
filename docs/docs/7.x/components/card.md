# Card

```html
<x-boilerplate::card>
    A card component
</x-boilerplate::card>
```

Will render

<img :src="$withBase('/assets/img/card.png')" alt="Card">

## Attributes

Attributes that can be used with this component :

| Option | Type | Default                                                  | Description |
| --- | --- |----------------------------------------------------------| --- |
| title | string | Empty string                                             | Title of the card, can be a translation string |
| color | string | Defined in [theme configuration](../configuration/theme) | Color of the header (\*) |
| bg-color | string | white                                                    | Color of the body (\*) |
| class| string | Empty string                                             | Extra class to add to the main div |
| outline | boolean | Defined in [theme configuration](../configuration/theme) | Set to true if card header must be outlined or false for fully colored |
| tabs | boolean | false                                                    | Set to true when card contains tabs, see [documentation below](#tabs) |
| maximize | boolean | false                                                    | Set to true to show the maximize button |
| reduce | boolean | false                                                    | Set to true to show the reduce button |
| close | boolean | false                                                    | Set to true to show the close button |
| collapsed | boolean | false                                                    | Set to true if card must be collapsed by default |

(\*) Available colors are : black, blue, green, cyan, yellow, red, gray-dark, gray, indigo, navy, purple, fuchsia, pink, maroon, orange, lime, teal, olive

All of the attributes that are not in the list above will be added as attributes to the main div.

## Slots

You can set a specific header and / or footer with slots :

```html
<x-boilerplate::card>
    <x-slot name="header">
        Card header content
    </x-slot>
    Card content
    <x-slot name="footer">
        Card footer content
    </x-slot>
</x-boilerplate::card>
```

You can also set tools buttons (buttons on the right in the header) with a slot :

```html
<x-boilerplate::card title="My card">
    <x-slot name="tools">
        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
    </x-slot>
</x-boilerplate::card>
```

## Tabs

For tabs cards, you have to set tabs option :

```html
<x-boilerplate::card tabs>
    <x-slot name="header">
        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab1-tab" data-toggle="pill" href="#tab1" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Tab 1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab2-tab" data-toggle="pill" href="#tab2" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Tab 2</a>
            </li>
        </ul>
    </x-slot>
    <div class="tab-content" id="custom-tabs-two-tabContent">
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            Tab 1 content
        </div>
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            Tab 2 content
        </div>
    </div>
</x-boilerplate::card>
```

## Laravel 6

Laravel 6 does not support Blade x components, but you can use the `@component` directive instead :

```html
@component('boilerplate::card', ['color' => 'red'])
    A card component
@endcomponent
```

With slots :

```html
@component('boilerplate::card')
    @slot('header')
        Card header content
    @endslot
    Card content
    @slot('footer')
        Card footer content
    @endslot
@endcomponent
```