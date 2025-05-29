# Layout and Templating

The Boilerplate package provides a comprehensive layout system based on AdminLTE 3 with extensive customization options. The layout is built using Blade templates with a modular structure that allows for easy extension and customization.

## Layout Structure

### Main Layout Template

The main layout is located at `src/resources/views/layout/index.blade.php` and serves as the base template for all backend pages.

**Key features:**
- Responsive AdminLTE 3 design
- Dark mode support
- Dynamic CSS/JS loading with stacks
- CSRF token management
- Multi-language support
- Session-based preferences

### Layout Components

The layout is composed of several modular components:

| Component | File | Purpose |
|-----------|------|---------|
| **Header** | `layout/header.blade.php` | Top navigation bar with user menu, language switcher, and navbar items |
| **Sidebar** | `layout/mainsidebar.blade.php` | Left sidebar with brand logo, user panel, and navigation menu |
| **Content Header** | `layout/contentheader.blade.php` | Page title, subtitle, and breadcrumb navigation |
| **Footer** | `layout/footer.blade.php` | Bottom footer with copyright and version information |

---

## Using the Layout

### Basic Page Extension

To create a new page using the boilerplate layout:

```php
@extends('boilerplate::layout.index', [
    'title' => 'Page Title',
    'subtitle' => 'Optional Subtitle',
    'breadcrumb' => [
        'Section' => 'route.name',
        'Current Page'
    ]
])

@section('content')
    <!-- Your page content here -->
@endsection
```

### Available Layout Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `title` | string | **Required** - Page title displayed in header and browser tab |
| `subtitle` | string | Optional subtitle displayed next to the title |
| `breadcrumb` | array | Breadcrumb navigation array |

### Breadcrumb Configuration

The breadcrumb system supports multiple formats:

```php
'breadcrumb' => [
    'Users' => 'boilerplate.users.index',              // Simple route
    'Edit' => ['boilerplate.users.edit', $user->id],   // Route with parameters
    'Current Page'                                      // String without link
]
```

---

## Content Sections

### Main Content Section

The primary content area where your page content is rendered:

```php
@section('content')
    <div class="row">
        <div class="col-12">
            @component('boilerplate::card', ['title' => 'Card Title'])
                Your content here
            @endcomponent
        </div>
    </div>
@endsection
```

### Content Header Right Section

Add custom elements to the right side of the content header:

```php
@section('content-header-right')
    <button class="btn btn-primary">Custom Button</button>
@endsection
```

### Right Sidebar Section

Add content to the right control sidebar:

```php
@section('right-sidebar')
    <h5>Sidebar Content</h5>
    <p>Additional information or controls</p>
@endsection
```

---

## Asset Management

### CSS Stack

Add custom CSS files or inline styles:

```php
@push('css')
    <link rel="stylesheet" href="/custom/styles.css">
    <style>
        .custom-class { color: red; }
    </style>
@endpush
```

### JavaScript Stack

Add custom JavaScript files or inline scripts:

```php
@push('js')
    <script src="/custom/script.js"></script>
    <script>
        $(document).ready(function() {
            // Custom JavaScript
        });
    </script>
@endpush
```

### Plugin Assets

For plugin-specific assets that need to load before the main JavaScript:

```php
@push('plugin-css')
    <link rel="stylesheet" href="/plugin/plugin.css">
@endpush

@push('plugin-js')
    <script src="/plugin/plugin.js"></script>
@endpush
```

---

## Theme Customization

### Theme Configuration

The layout appearance is controlled by the `config/boilerplate/theme.php` configuration file:

```php
return [
    'navbar' => [
        'bg' => 'white',        // Background color
        'type' => 'light',      // light or dark
        'border' => true,       // Show navbar border
        'user' => [
            'visible' => false, // Show user info in navbar
            'shadow' => 0,      // Shadow elevation (0-4)
        ],
    ],
    'sidebar' => [
        'type' => 'dark',       // dark or light
        'shadow' => 4,          // Shadow elevation (0-4)
        'links' => [
            'bg' => 'blue',     // Sidebar links background
        ],
        'brand' => [
            'logo' => [
                'bg' => 'blue',
                'icon' => '<i class="fa fa-cubes"></i>',
                'text' => '<strong>BO</strong>ilerplate',
                'shadow' => 2,
            ],
        ],
        'user' => [
            'visible' => true,  // Show user panel in sidebar
            'shadow' => 2,
        ],
    ],
    'footer' => [
        'visible' => true,      // Show footer
        'vendorname' => 'Your Company',
        'vendorlink' => 'https://yoursite.com',
    ],
    'darkmode' => true,         // Enable dark mode toggle
    'fullscreen' => false,      // Enable fullscreen toggle
    'minify' => true,          // Minify inline CSS/JS
];
```

### Available Color Schemes

**Background colors:** `blue`, `indigo`, `purple`, `pink`, `red`, `orange`, `yellow`, `green`, `teal`, `cyan`, `gray`, `gray-dark`, `black`, `white`

**Shadow levels:** `0` (none) to `4` (maximum)

---

## Layout Extension

### Publishing Layout Views

To customize the layout templates, publish the views:

```bash
php artisan vendor:publish --tag=boilerplate-views
```

This copies all view files to `resources/views/vendor/boilerplate/` where you can modify them.

### Custom Layout Template

Create a custom layout by extending the base layout:

```php
{{-- resources/views/custom-layout.blade.php --}}
@extends('boilerplate::layout.index')

@section('content')
    <div class="custom-wrapper">
        <div class="custom-sidebar">
            @yield('custom-sidebar')
        </div>
        <div class="custom-content">
            @yield('custom-content')
        </div>
    </div>
@endsection
```

Use your custom layout:

```php
@extends('custom-layout', ['title' => 'Custom Page'])

@section('custom-content')
    Your content here
@endsection
```

### Overriding Layout Components

Override specific layout components by creating files in the published views directory:

```php
{{-- resources/views/vendor/boilerplate/layout/header.blade.php --}}
<nav class="main-header navbar navbar-expand custom-header">
    <!-- Your custom header -->
</nav>
```

---

## Advanced Customization

### Custom View Composers

Create view composers to inject data into layout components:

```php
namespace App\View\Composers;

use Illuminate\View\View;

class CustomLayoutComposer
{
    public function compose(View $view)
    {
        $view->with('customData', $this->getCustomData());
    }
    
    private function getCustomData()
    {
        return [
            'notifications' => auth()->user()->unreadNotifications,
            'stats' => $this->getStats(),
        ];
    }
}
```

Register the composer in your `AppServiceProvider`:

```php
public function boot()
{
    View::composer('boilerplate::layout.header', CustomLayoutComposer::class);
}
```

### Custom Navbar Items

Add custom items to the navbar using the navbar repository:

```php
// In a service provider
app('boilerplate.navbar.items')->registerItem('right', function() {
    return view('custom.navbar-item');
});
```

### Dynamic Theme Switching

Implement dynamic theme switching with user preferences:

```php
// In your controller or middleware
$theme = auth()->user()->getSetting('theme', 'default');
config(['boilerplate.theme' => config("themes.{$theme}")]);
```

---

## Performance Optimization

### Asset Minification

The layout supports automatic minification of inline CSS and JavaScript:

```php
@component('boilerplate::minify')
    <style>
        .my-class { margin: 10px; padding: 5px; }
    </style>
    <script>
        function myFunction() { console.log('Hello'); }
    </script>
@endcomponent
```

### Conditional Loading

Load assets conditionally based on page requirements:

```php
@if(request()->routeIs('users.*'))
    @push('css')
        <link rel="stylesheet" href="/css/users.css">
    @endpush
@endif
```

### CDN Integration

Configure CDN URLs for better performance:

```php
// In theme configuration
'cdn' => [
    'css' => 'https://cdn.example.com/css/',
    'js' => 'https://cdn.example.com/js/',
]
```

---

## Mobile Responsiveness

The layout is fully responsive and includes:

- **Bootstrap 4 grid system**
- **Mobile-first design**
- **Touch-friendly navigation**
- **Responsive sidebar collapse**
- **Adaptive content layout**

### Mobile-Specific Customizations

```php
@push('css')
<style>
@media (max-width: 768px) {
    .custom-mobile-class {
        display: block;
    }
}
</style>
@endpush
```

This layout system provides a solid foundation for building professional admin interfaces with extensive customization options while maintaining consistency and performance.