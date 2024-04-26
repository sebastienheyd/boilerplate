# Toggle

```html
<x-boilerplate::toggle />
<x-boilerplate::toggle label="Toggle label" color-on="green" checked/>
```

Will render

<img :src="$withBase('/assets/img/toggle.png')" alt="Toggle">

## Attributes

Attributes that can be used with this component :

| Option | Type | Default | Description |
| --- | --- | --- | --- |
| color-on | string | primary | Checkbox color when on (*) |
| color-off | string | light | Checkbox color when off (*) |
| checked | boolean | false | If true input will be checked |
| type | string | checkbox | Type of input : checkbox or radio |
| id | string | random id | Id of the input, if no value will set a unique random id |
| name | string | empty string | Name of the input |
| label | string | empty string | Label of the input, can be a translation string |
| class | string | empty string | Extra class that will be added to form-group |
| value | string | empty string | Value of input |

(\*) Available colors are : blue, green, cyan, yellow, red, gray-dark, gray, indigo, navy, purple, fuchsia, pink, maroon, orange, lime, teal, olive

All of the attributes that are not in the list above will be added as attributes to the div that contains the input :

```html
<x-boilerplate::toggle name="example[]" label="translation.string" data-toggle="tooltip" data-title="Tooltip content" />
```

**NB** : for non primitive values that not using a simple string you have to use the `:` character as a prefix :

```html
<x-boilerplate::toggle type="radio" name="radio" value="test" :checked="$value === 'test'" />
```