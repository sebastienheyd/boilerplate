<?php

namespace Sebastienheyd\Boilerplate\View;

final class Theme
{
    public const STYLES = ['classic', 'modern'];

    public const PALETTES = ['orange', 'blue', 'green', 'red', 'purple', 'teal'];

    /**
     * Get the configured style, falling back to classic when the value is unknown.
     *
     * @return string
     */
    public static function style(): string
    {
        $style = config('boilerplate.theme.style');

        return in_array($style, self::STYLES, true) ? $style : 'classic';
    }

    /**
     * Get the configured color palette, falling back to orange when the value is unknown.
     *
     * @return string
     */
    public static function palette(): string
    {
        $palette = config('boilerplate.theme.palette');

        return in_array($palette, self::PALETTES, true) ? $palette : 'orange';
    }

    /**
     * Check if the modern style is enabled.
     *
     * @return bool
     */
    public static function isModern(): bool
    {
        return self::style() === 'modern';
    }

    /**
     * Get the classes to add to the body tag.
     *
     * @return string
     */
    public static function bodyClasses(): string
    {
        return self::isModern() ? 'theme-modern palette-'.self::palette() : '';
    }

    /**
     * Get the style to force for a theme config published by the application.
     *
     * A theme config published before the modern style existed has no "style" key. As mergeConfigFrom only
     * merges the first level, the package default (modern) would otherwise leak into it on upgrade.
     *
     * @param  mixed  $published
     * @return string|null
     */
    public static function styleForPublishedConfig(mixed $published): ?string
    {
        return is_array($published) && ! array_key_exists('style', $published) ? 'classic' : null;
    }
}
