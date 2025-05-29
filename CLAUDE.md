# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a **Laravel Boilerplate package** based on AdminLTE 3, designed for creating back-office applications with user management, roles, permissions, and dashboard widgets. The package is compatible with Laravel 11-12 and distributed via Composer with namespace `Sebastienheyd\Boilerplate`.

## Development Commands

### Testing and Quality
- `make test` - Run PHPUnit tests with stop-on-failure
- `make testcoverage` - Run tests with code coverage (requires Xdebug)
- `make testcoveragehtml` - Generate HTML coverage report
- `make cs` - Check coding standards with PHP_CodeSniffer
- `make csfix` - Fix coding standards automatically
- `make clean` - Clean test artifacts and vendor files

### Composer Scripts
- `composer test` - Run PHPUnit tests
- `composer lint` - Run PHPStan static analysis
- `composer serve` - Start development server with Orchestra Testbench
- `composer build` - Build workbench for testing

### Asset Compilation
- `npm run docs:dev` - Start VuePress documentation development server
- `npm run docs:build` - Build documentation for production
- Frontend assets are compiled via Laravel Mix (see `src/webpack.mix.js`)

## Architecture Overview

### Service Provider Pattern
The main `BoilerplateServiceProvider` handles:
- Configuration merging for 7 config files (`app`, `auth`, `dashboard`, `laratrust`, `locale`, `menu`, `theme`)
- Package registration (Laratrust, Laravel Menu, DataTables)
- Custom middleware registration
- View composers for automatic data injection
- Repository singletons for Menu, Navbar, Datatables, and Dashboard Widgets

### Key Architectural Patterns
- **Repository Pattern**: Centralized registration for Menu items, DataTables, Dashboard widgets, Navbar items
- **Factory Pattern**: Dynamic generation of menus, widgets, and datatables
- **Observer Pattern**: Events for user actions (`UserCreated`, `UserSaved`, `UserDeleted`)
- **Command Pattern**: Console commands for code generation

### Code Generation System
Console commands for scaffolding:
- `boilerplate:datatable` - Generate DataTable classes
- `boilerplate:dashboard` - Create dashboard controllers
- `boilerplate:menu` - Add menu items
- `boilerplate:permission` - Manage permissions
- `boilerplate:scaffold` - Complete CRUD scaffolding
- `boilerplate:widget` - Dashboard widgets

Templates are stored in `src/Console/stubs/` with `.stub` extension.

### Asset Pipeline
Laravel Mix configuration handles:
- **SCSS compilation**: AdminLTE, Bootstrap 4, component-specific styles
- **JavaScript bundling**: AdminLTE, DataTables, TinyMCE, FullCalendar, and custom scripts
- **Plugin integration**: FontAwesome, Moment.js, Select2, DatePickers, ColorPicker
- **Multi-language support**: Asset localization for multiple languages

### Testing Architecture
- **Orchestra Testbench**: Laravel package testing environment
- **Test Structure**: Organized by functionality (Components, Console, Controllers, Dashboard)
- **Database**: SQLite in-memory for testing
- **No Mocks Policy**: Prefers integration tests over mocked dependencies
- **Test Isolation**: Each test suite runs independently

### Security & Permissions
- **Laratrust Integration**: Complete role-based access control
- **Custom Models**: `User`, `Role`, `Permission`, `PermissionCategory`
- **Middleware Stack**: Comprehensive security layer with custom middleware
- **Permission Categories**: Hierarchical permission organization

### Middleware Architecture
The package provides 5 custom middleware for authentication and user experience:

#### Core Middleware
- **`BoilerplateAuthenticate`**: Extends Laravel's Authenticate middleware, redirects unauthenticated users to `boilerplate.login` route
- **`BoilerplateGuest`**: Prevents authenticated users from accessing guest-only routes (login, register), redirects to dashboard
- **`BoilerplateEmailVerified`**: Configurable email verification (via `boilerplate.auth.verify_email` config), extends Laravel's EnsureEmailIsVerified
- **`BoilerplateLocale`**: Automatic locale management with Carbon integration, supports user preferences and cookie storage
- **`BoilerplateImpersonate`**: Admin user impersonation system with session-based state management

#### Middleware Registration
The ServiceProvider registers middleware aliases for both legacy and dotted notation:
```php
// Legacy aliases (backward compatibility)
$this->router->aliasMiddleware('boilerplateauth', BoilerplateAuthenticate::class);
$this->router->aliasMiddleware('boilerplateguest', BoilerplateGuest::class);
$this->router->aliasMiddleware('boilerplatelocale', BoilerplateLocale::class);

// Modern dotted aliases (preferred)
$this->router->aliasMiddleware('boilerplate.auth', BoilerplateAuthenticate::class);
$this->router->aliasMiddleware('boilerplate.guest', BoilerplateGuest::class);
$this->router->aliasMiddleware('boilerplate.locale', BoilerplateLocale::class);
$this->router->aliasMiddleware('boilerplate.emailverified', BoilerplateEmailVerified::class);

// Conditional registration
if (config('boilerplate.app.allowImpersonate', false)) {
    $this->router->aliasMiddleware('boilerplate.impersonate', BoilerplateImpersonate::class);
}
```

#### Laratrust Integration
The package also registers Laratrust middleware for permission-based routing:
```php
$this->router->aliasMiddleware('role', LaratrustRole::class);
$this->router->aliasMiddleware('permission', LaratrustPermission::class);
$this->router->aliasMiddleware('ability', LaratrustAbility::class);
```

#### Route Protection Patterns
```php
// Base route group - all boilerplate routes
'middleware' => ['web', 'boilerplate.locale']

// Guest routes (login, register, password reset)
'middleware' => ['boilerplate.guest']

// Protected backend routes (requires authentication + backend access + email verification)
'middleware' => ['boilerplate.auth', 'ability:admin,backend_access', 'boilerplate.emailverified']

// Resource-specific routes with permissions
'middleware' => ['ability:admin,roles_crud']
'middleware' => ['ability:admin,users_crud']
'middleware' => ['ability:admin,logs']

// Email verification routes (authenticated users only)
'middleware' => ['boilerplate.auth']
```

#### Middleware Configuration Dependencies
- **`BoilerplateEmailVerified`**: Requires `boilerplate.auth.verify_email` config to be enabled
- **`BoilerplateImpersonate`**: Requires `boilerplate.app.allowImpersonate` config to be enabled
- **`BoilerplateLocale`**: Uses `boilerplate.locale.switch` and `boilerplate.locale.allowed` configs
- **Global Web Integration**: `BoilerplateImpersonate` is automatically added to 'web' middleware group when enabled

### Dashboard & Widgets
- **Widget Repository**: Centralized widget registration and management
- **Default Widgets**: `CurrentUser`, `UsersNumber`, `LatestErrors`
- **Extensible API**: Interface for creating custom widgets
- **Dynamic Loading**: Widgets loaded on-demand via repository pattern

### Internationalization
- **Laravel-Lang Integration**: Standard Laravel translations
- **Custom Namespace**: `boilerplate::` for package-specific translations
- **Supported Languages**: EN, FR, ES, IT, TR, BG, FA
- **Dual Format**: Both JSON and PHP translation files

### DataTables System
- **Yajra DataTables**: Server-side processing integration
- **Repository Pattern**: Centralized datatable registration
- **Custom Components**: Buttons, columns, and filters
- **Multi-language**: Complete i18n support with localized strings

## Package Installation Workflow

When installing this package in a Laravel application:
1. `composer require sebastienheyd/boilerplate`
2. `php artisan vendor:publish --tag=boilerplate` - Publish config and views
3. `php artisan migrate` - Run boilerplate migrations
4. Optional: `php artisan vendor:publish --tag=boilerplate-public --force` - Update assets

## Extension Points

The package is designed for extensibility:
- **MenuItemInterface**: Standard interface for menu plugins
- **Widget System**: Custom widgets via repository registration
- **Event System**: Hook into user actions via Laravel events
- **View Composers**: Automatic data injection for views
- **Configuration Override**: All configs can be overridden in consuming application

## Development Notes

- **PSR-12 Compliance**: Code follows PSR-12 standards with StyleCI integration
- **Laravel Compatibility**: Supports Laravel 11-12 with version constraints
- **No Source Modification**: Tests should never modify source files
- **Minimal Mocking**: Integration tests preferred over mocked dependencies

## Documentation

- Documentation must be written in English only
- Documentation use VuePress
- Latest documentation source path : u/docs/docs/8.x
