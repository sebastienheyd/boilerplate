# laratrust.php

The `config/boilerplate/laratrust.php` file allows to define the classes used by [Laratrust](https://laratrust.santigarcor.me/).

Laratrust is a Laravel package that lets you handle very easily everything related with authorization (roles and 
permissions) inside your application. All of this through a very simple configuration process and API.

By default, boilerplate overloads the Laratrust models. You can define your own models to use if you need to authenticate by another way (LDAP, OAuth, ...)

---

```php
<?php
return [
    'user'       => Sebastienheyd\Boilerplate\Models\User::class,
    'role'       => Sebastienheyd\Boilerplate\Models\Role::class,
    'permission' => Sebastienheyd\Boilerplate\Models\Permission::class,
];
```

---

## user

The default value is `Sebastienheyd\Boilerplate\Models\User::class` 

See [Laratrust documentation](https://laratrust.santigarcor.me/docs/5.2/configuration/models/user.html) on extending 
User model 

## role

The default value is `Sebastienheyd\Boilerplate\Models\Role::class` 

See [Laratrust documentation](https://laratrust.santigarcor.me/docs/5.2/configuration/models/role.html) on extending 
Role model 

## permission

The default value is `Sebastienheyd\Boilerplate\Models\Permission::class` 

See [Laratrust documentation](https://laratrust.santigarcor.me/docs/5.2/configuration/models/permission.html) on extending 
Permission model ,
