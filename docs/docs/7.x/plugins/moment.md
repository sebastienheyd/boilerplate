# Moment.js

A lightweight JavaScript date library for parsing, validating, manipulating, and formatting dates.

> [https://momentjs.com](https://momentjs.com)

## Usage

To use moment.js you can use the loading view [`boilerplate::load.moment`](https://github.com/sebastienheyd/boilerplate/blob/e1dc4b29920f011271a1a7ad682c3e82643180d9/src/resources/views/load/moment.blade.php)

> When loaded, moment.js will use the locale defined in [config/app.php](../configuration/app#locale)

Moment.js is automatically loaded when you use the loading view  ``boilerplate::load.datatables``

```html
@include('boilerplate::load.moment')

<script>
    moment().format('LLLL'); // Thursday, August 27, 2020 10:04 AM
</script>
```

