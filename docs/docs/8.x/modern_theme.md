# Modern theme

The `modern` theme is a flat style for the backend, in light and dark mode, with named color palettes. It is the
default theme of new installations.

<img :src="$withBase('/assets/img/theme_modern.png')" alt="Modern theme, orange palette, light mode" style="max-width:49%">
<img :src="$withBase('/assets/img/theme_modern_dark.png')" alt="Modern theme, orange palette, dark mode" style="max-width:49%">

It keeps the AdminLTE layout and the Font Awesome icons, and replaces the colors with a single stylesheet
(`themes/modern.min.css`) loaded right after AdminLTE.

## Enable the modern theme

New installations use it by default: the `BOILERPLATE_THEME` environment variable defaults to `modern`.

```env
BOILERPLATE_THEME=modern
```

The theme file `config/boilerplate/themes/modern.php` sets `'style' => 'modern'`. Any theme file can use the modern
style by setting this key, see [theme.php](configuration/theme.md#style).

Existing installations keep their current look after an update, see [Upgrade](upgrade.md#modern-theme).

## Palettes

The palette is set with the `BOILERPLATE_PALETTE` environment variable (or the `palette` key of the theme file):

```env
BOILERPLATE_PALETTE=teal
```

| Palette | Accent (light) | Primary (light) | Accent (dark) | Primary (dark) |
|---------|----------------|-----------------|---------------|----------------|
| `orange` (default) | `#f98f34` | `#1746a2` | `#ff9133` | `#2563eb` |
| `blue` | `#2563eb` | `#1d4ed8` | `#60a5fa` | `#2563eb` |
| `green` | `#16a34a` | `#15803d` | `#4ade80` | `#16a34a` |
| `red` | `#dc2626` | `#b91c1c` | `#f87171` | `#dc2626` |
| `purple` | `#7c3aed` | `#6d28d9` | `#a78bfa` | `#7c3aed` |
| `teal` | `#0d9488` | `#0f766e` | `#2dd4bf` | `#0d9488` |

The accent color is used for the brand icon, the current page in the sidebar and the active tab. The primary color is
used for buttons, links, badges and the active page of paginations. An unknown palette falls back to `orange`.

The neutral colors (backgrounds, surfaces, borders, texts) are the same for all palettes. Switching between light and
dark mode does not reload the page.

## Customize the colors

The colors are CSS variables defined on the `body` tag, which has the `theme-modern` and `palette-<name>` classes. To
change them, push a stylesheet to the `css` stack: it is loaded after the modern stylesheet.

```css
body.theme-modern.palette-teal {
    --bp-accent: #0e7490;
    --bp-primary: #155e75;
}

body.theme-modern.palette-teal.dark-mode {
    --bp-accent: #22d3ee;
    --bp-link: #67e8f9;
}
```

| Variable | Usage |
|----------|-------|
| `--bp-accent` | Brand icon, current page, active tab |
| `--bp-accent-bg` | Background of the current page in the sidebar |
| `--bp-primary` | Buttons, active page, focus of the form fields |
| `--bp-primary-hover` | Buttons and links on hover |
| `--bp-link` | Links of the content |
| `--bp-badge`, `--bp-badge-text` | `badge-primary` badges |
| `--bp-bg`, `--bp-surface`, `--bp-surface-hover` | Page background, cards and menus, hover |
| `--bp-header`, `--bp-header-border` | Card headers, striped rows |
| `--bp-border`, `--bp-field` | Borders, form fields background |
| `--bp-text`, `--bp-text-muted` | Texts |

`--bp-accent-bg`, `--bp-primary-hover` and `--bp-badge` are computed from the accent and primary colors when the
palette does not set them.

## Demo

The `/admin/demo` page shows the elements styled by the theme. To try the palettes without a Laravel application, see
the [local demo environment](tests.md#local-demo-environment).
