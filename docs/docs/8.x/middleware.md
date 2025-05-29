# Middlewares

The Boilerplate package provides a comprehensive set of custom middlewares to handle authentication, permissions, and user experience management.

## Available Middlewares

### BoilerplateAuthenticate

**Alias:** `boilerplate.auth`, `boilerplateauth` (legacy)  
**Class:** `Sebastienheyd\Boilerplate\Middleware\BoilerplateAuthenticate`

Extends Laravel's `Authenticate` middleware to redirect unauthenticated users to the boilerplate login route.

```php
// Redirect to boilerplate login route
return route('boilerplate.login');
```

**Route usage:**
```php
Route::middleware(['boilerplate.auth'])->group(function () {
    // Protected routes
});
```

---

### BoilerplateGuest

**Alias:** `boilerplate.guest`, `boilerplateguest` (legacy)  
**Class:** `Sebastienheyd\Boilerplate\Middleware\BoilerplateGuest`

Prevents authenticated users from accessing guest pages (login, register, password reset).

```php
// Redirect to dashboard if user is authenticated
return redirect(route('boilerplate.dashboard'));
```

**Route usage:**
```php
Route::middleware(['boilerplate.guest'])->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm']);
});
```

---

### BoilerplateEmailVerified

**Alias:** `boilerplate.emailverified`  
**Class:** `Sebastienheyd\Boilerplate\Middleware\BoilerplateEmailVerified`

Verifies that the user has confirmed their email address (if email verification is enabled in configuration).

**Required configuration:**
```php
// config/boilerplate/auth.php
'verify_email' => true,
```

**Behavior:**
- If `verify_email` is `false`: middleware is bypassed
- If user hasn't verified email: redirect to verification page

```php
return Redirect::guest(URL::route('boilerplate.verification.notice'));
```

**Route usage:**
```php
Route::middleware(['boilerplate.auth', 'boilerplate.emailverified'])->group(function () {
    // Routes requiring email verification
});
```

---

### BoilerplateLocale

**Alias:** `boilerplate.locale`, `boilerplatelocale` (legacy)  
**Class:** `Sebastienheyd\Boilerplate\Middleware\BoilerplateLocale`

Automatically manages application and Carbon locale based on user preferences.

**Configuration:**
```php
// config/boilerplate/locale.php
'switch' => true,               // Allow language switching
'allowed' => ['en', 'fr', 'es'], // Allowed languages
```

**Locale sources (in priority order):**
1. User preference (helper function `setting('locale')`)
2. Cookie `boilerplate_lang`
3. Default configuration `boilerplate.app.locale`

**Usage:**
```php
// Automatically applied to all boilerplate routes
'middleware' => ['web', 'boilerplate.locale']
```

---

### BoilerplateImpersonate

**Alias:** `boilerplate.impersonate`  
**Class:** `Sebastienheyd\Boilerplate\Middleware\BoilerplateImpersonate`

Enables user impersonation for administrators. This middleware is automatically added to the `web` group when impersonation is enabled.

**Required configuration:**
```php
// config/boilerplate/app.php
'allowImpersonate' => true,
```

**Functionality:**
- Checks for `session('impersonate')` presence
- Temporarily authenticates the target user
- Shares the original user in views via `$impersonator`
- Configures Laratrust for error redirections

```php
View::share('impersonator', Auth::user());
Auth::onceUsingId(session()->get('impersonate'));
```

---

## Laratrust Middlewares

The package also integrates [Laratrust](https://laratrust.santigarcor.com/) middlewares for role and permission management:

### role

Verifies that the user has one or more specific roles.

```php
Route::middleware(['role:admin|owner'])->group(function () {
    // Routes reserved for admins or owners
});
```

### permission

Verifies that the user has one or more specific permissions.

```php
Route::middleware(['permission:users.create|users.edit'])->group(function () {
    // Routes for creating or editing users
});
```

### ability

Verifies that the user has a role AND permission (more flexible).

```php
Route::middleware(['ability:admin,backend_access'])->group(function () {
    // Routes for admins with backend access
});
```

---

## Usage Patterns

### Public routes (guests)
```php
Route::group([
    'middleware' => ['web', 'boilerplate.locale'],
], function () {
    Route::group(['middleware' => ['boilerplate.guest']], function () {
        Route::get('login', [LoginController::class, 'showLoginForm']);
        Route::get('register', [RegisterController::class, 'showRegistrationForm']);
    });
});
```

### Protected routes (backend)
```php
Route::group([
    'middleware' => [
        'boilerplate.auth',
        'ability:admin,backend_access',
        'boilerplate.emailverified'
    ]
], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('users', UsersController::class)
        ->middleware('ability:admin,users_crud');
});
```

### Routes with specific permissions
```php
// Role management (full CRUD)
Route::resource('roles', RolesController::class)
    ->middleware(['ability:admin,roles_crud']);

// Logs (read-only)
Route::prefix('logs')->middleware('ability:admin,logs')->group(function () {
    Route::get('/', [LogViewerController::class, 'index']);
});
```

---

## Middleware Configuration

### Automatic Registration

Middlewares are automatically registered in the `BoilerplateServiceProvider`:

```php
// Modern aliases (recommended)
$this->router->aliasMiddleware('boilerplate.auth', BoilerplateAuthenticate::class);
$this->router->aliasMiddleware('boilerplate.guest', BoilerplateGuest::class);
$this->router->aliasMiddleware('boilerplate.locale', BoilerplateLocale::class);
$this->router->aliasMiddleware('boilerplate.emailverified', BoilerplateEmailVerified::class);

// Legacy aliases (backward compatibility)
$this->router->aliasMiddleware('boilerplateauth', BoilerplateAuthenticate::class);
$this->router->aliasMiddleware('boilerplateguest', BoilerplateGuest::class);
$this->router->aliasMiddleware('boilerplatelocale', BoilerplateLocale::class);

// Conditional registration
if (config('boilerplate.app.allowImpersonate', false)) {
    $this->router->aliasMiddleware('boilerplate.impersonate', BoilerplateImpersonate::class);
    $this->router->pushMiddlewareToGroup('web', BoilerplateImpersonate::class);
}
```

### Laratrust Middlewares

```php
$this->router->aliasMiddleware('role', LaratrustRole::class);
$this->router->aliasMiddleware('permission', LaratrustPermission::class);
$this->router->aliasMiddleware('ability', LaratrustAbility::class);
```

---

## Configuration Dependencies

| Middleware | Required Configuration | Default Value |
|------------|----------------------|---------------|
| `BoilerplateEmailVerified` | `boilerplate.auth.verify_email` | `false` |
| `BoilerplateImpersonate` | `boilerplate.app.allowImpersonate` | `false` |
| `BoilerplateLocale` | `boilerplate.locale.switch` | `false` |
| Laratrust | `boilerplate.laratrust.*` | See config |

---

## Customization

### Creating Custom Middleware

You can extend or replace existing middlewares:

```php
namespace App\Http\Middleware;

use Sebastienheyd\Boilerplate\Middleware\BoilerplateAuthenticate;

class CustomBoilerplateAuth extends BoilerplateAuthenticate
{
    protected function redirectTo($request)
    {
        // Custom logic
        return route('custom.login');
    }
}
```

### Registration in AppServiceProvider

```php
public function boot()
{
    $this->app['router']->aliasMiddleware('custom.auth', CustomBoilerplateAuth::class);
}
```

This middleware architecture provides comprehensive and flexible protection for boilerplate-based applications, with seamless integration of authentication, permission, and locale management systems.