# Select2

```html
<x-boilerplate::select2 name="example" label="Example" :options="[1 => 'Option 1', 2 => 'Option 2', 3 => 'Option 3']" />
```

Or

```html
<x-boilerplate::select2 name="example" label="Example">
    <option value="1">Option 1</option>
    <option value="2">Option 2</option>
    <option value="3">Option 3</option>
</x-boilerplate::select2>
```

Will render

<img :src="$withBase('/assets/img/select2.png')" alt="Select2">

## Attributes

Attributes that can be used with this component :

| Option                     | Type                | Default   | Description                                                                                              |
|----------------------------|---------------------|-----------|----------------------------------------------------------------------------------------------------------|
| name                       | string              | null      | Input name (required)                                                                                    |
| label                      | string              | name      | Input label, can be a translation string                                                                 |
| id                         | string              | random id | Id of the input, if no value will set a unique random id                                                 |
| help                       | string              | null      | Help message that will be displayed under the input field                                                |
| options                    | array               | null      | Associative array of options                                                                             |
| selected                   | string &#124; array | null      | A string or an array of the selected options                                                             |
| ajax                       | string              | null      | Ajax URL to call                                                                                         |
| ajax-params                | array               | []        | Array of additional ajax parameters                                                                      |
| tags                       | boolean             | false     | Allows to create new option from text input. Set `minimum-results-for-search=0` for non-multiple select  |
| model                      | string              | null      | Model to use to fill the list by using a generic ajax call, [see below](#model)                          |
| multiple                   | boolean             | false     | Set to true if select is multiple                                                                        |
| allow-clear                | boolean             | false     | Set to true to allow selection clear                                                                     |
| placeholder                | string              | "—"       | The placeholder value will be displayed until a selection is made                                        |
| max-length                 | integer             | 10        | When using the `model` attribute, defines the maximum length of the result list                          |
| minimum-input-length       | integer             | 0         | Minimum search term length before showing the options, efficient with large data sets                    |
| minimum-results-for-search | integer             | 10        | Minimum number of results required to display the search box                                             |
| group-class                | string              | null      | Additional class that will be added to form-group                                                        | 
| group-id                   | string              | null      | ID that will be added to form-group                                                                      | 

All of the attributes that are not in the list above will be added as attributes to the input field :

```html
<x-boilerplate::select2 name="example" data-example="example" multiple>
    <option value="1" selected>Option 1</option>
</x-boilerplate::select2>
```

**NB** : for non primitive values that not using a simple string you have to use the `:` character as a prefix :

```html
<x-boilerplate::select2 name="example" :placeholder="__('stringToTranslate')">
    <option value="1" selected>Option 1</option>
</x-boilerplate::select2>
```

## Ajax

To call in ajax a controller that will return the list of options, you can use the ajax attribute :

```html
<x-boilerplate::select2 name="example" :ajax="route('select2')">
    <option value="1" selected>Option 1</option>
</x-boilerplate::select2>
```

The controller will be called with the type "POST" and the following request parameters :

* `term` : The current search term in the search box.
* `q` : Contains the same contents as term.
* `_type`: A "request type". Will usually be query, but changes to query_append for paginated requests.
* `page` : The current page number to request. Only sent for paginated (infinite scrolling) searches.

Additional ajax parameters can be sent using the `ajax-params` attribute.

```html
<x-boilerplate::select2 name="example" :ajax="route('select2')" :ajax-params="['extra' => 'paramValue']" />
```

The controller must return selectable options in json format with this structure :

```json
{
  "results": [
    {
      "id": 1,
      "text": "Option 1"
    },
    {
      "id": 2,
      "text": "Option 2"
    }
  ]
}
```

Have a look to the Select2 official documentation : [https://select2.org/data-sources/ajax](https://select2.org/data-sources/ajax)

## Model

In most cases, it is not necessary to write a controller to build the list, a generic controller exists for that.

The only thing to do is to set the model to use and the field to search on.

```html
<x-boilerplate::select2 model="Sebastienheyd\Boilerplate\Models\User|first_name" />
```

In this case, select2 will search on the field first_name of the User model. By default, the model name will be used as the `name` attribute of the select and the model `keyName` as the options id.

You can set another field as the option key value by setting it after the field name :

```html
<x-boilerplate::select2 model="Sebastienheyd\Boilerplate\Models\User|first_name|email" />
```

To set the value, use the `selected` attribute, if you need to get the old input value you have to use the `old` function, e.g. :

```html
<x-boilerplate::select2 name="birth_country" model="Namespace\To\Country|label|iso_code" :selected="old('birth_country', $user->birth_country)" />
<x-boilerplate::select2 multiple name="countries[]" model="Namespace\To\Country|label|iso_code" :selected="old('countries', $user->countries)" />
```

You can also set the maximum length of the result list by using the `max-length` attribute. 

```html
<x-boilerplate::select2 model="Namespace\To\Country|label" max-length="20" />
```

By setting `max-length` to -1 and the attribute `minimum-input-length` to zero it will show the entire list :

```html
<x-boilerplate::select2 model="Namespace\To\Country|label" max-length="-1" minimum-input-length="0" />
```

### Model scope

You can also use a local scope to generate the option list, for example in your model : 

```php
public function scopeLocalScopeName($query, $q)
{
    $query->selectRaw('id as select2_id, CONCAT(field1, " ", field1) as select2_text')
          ->where(\DB::raw('CONCAT(field1, " ", select2_text)'), 'like', "$q%")
          ->orderBy('select2_text', 'desc');
}
```

Then call the component with the scope name :

```html
<x-boilerplate::select2 model="Namespace\To\ModelName|LocalScopeName" />
```

**IMPORTANT** : you must call the fields `select2_id` and `select2_text`