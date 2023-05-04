<?php

namespace Sebastienheyd\Boilerplate;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader as LaravelTranslationFileLoader;
use RuntimeException;

class FileLoader extends LaravelTranslationFileLoader
{
    protected $path;
    protected $paths = [];
    protected $customJsonPaths = [];

    /**
     * Create a new file loader instance.
     *
     * @param Filesystem $files
     * @param string|array  $path
     * @param array  $paths
     */
    public function __construct(Filesystem $files, $path, array $paths = [])
    {
        $this->path = app()->langPath();
        $this->files = $files;

        $path = is_string($path) ? [$path] : $path;
        $this->paths = array_unique(array_merge($paths, $path));
    }

    /**
     * Load the messages for the given locale.
     *
     * @param string $locale
     * @param string $group
     * @param string $namespace
     * @return array
     *
     * @throws FileNotFoundException
     */
    public function load($locale, $group, $namespace = null)
    {
        $defaults = [];

        $locale = str_replace('-', '_', $locale);

        foreach ($this->paths as $path) {
            $defaults = array_replace_recursive($defaults, $this->loadPath($path, $locale, $group));
        }

        return array_replace_recursive($defaults, parent::load($locale, $group, $namespace));
    }

    /**
     * Fall back to base locale (i.e. de) if a countries specific locale (i.e. de-CH) is not available.
     *
     * @param string $path
     * @param string $locale
     * @param string $group
     * @return array
     */
    protected function loadPath($path, $locale, $group): array
    {
        $result = $this->loadLocalePath($path, $locale, $group);

        if (empty($result) && preg_match('#^([a-z]{2})[-_][A-Z]{2}$#', $locale, $m)) {
            return $this->loadLocalePath($path, $m[1], $group);
        }

        return $result;
    }

    /**
     * Load a locale path if exists.
     *
     * @param $path
     * @param $locale
     * @param $group
     * @return array
     */
    protected function loadLocalePath($path, $locale, $group): array
    {
        if ($this->files->exists($full = "{$path}/{$locale}/{$group}.php")) {
            try {
                return $this->files->getRequire($full);
            } catch (\Throwable $e) {
                throw new RuntimeException("Translation file [{$full}] contains an invalid PHP array structure.");
            }
        }

        return [];
    }

    /**
     * Add a new JSON path to the loader.
     *
     * @param  string  $path
     * @return void
     */
    public function addJsonPath($path)
    {
        $this->customJsonPaths[] = $path;
        parent::addJsonPath($path);
    }

    /**
     * Load a locale from the given JSON file path.
     *
     * @param  string  $locale
     * @return array
     *
     * @throws RuntimeException|FileNotFoundException
     */
    protected function loadJsonPaths($locale)
    {
        return collect(array_merge($this->jsonPaths, [$this->path]))
            ->reduce(function ($output, $path) use ($locale) {
                if (preg_match('#^([a-z]{2})[-_][A-Z]{2}$#', $locale, $m)) {
                    if (! $this->files->exists("{$path}/{$locale}.json")) {
                        $locale = $m[1];
                    }
                }

                if ($this->files->exists($full = "{$path}/{$locale}.json")) {
                    $decoded = json_decode($this->files->get($full), true);

                    if (is_null($decoded) || json_last_error() !== JSON_ERROR_NONE) {
                        throw new RuntimeException("Translation file [{$full}] contains an invalid JSON structure.");
                    }

                    $output = array_merge($output, $decoded);
                }

                return $output;
            }, []);
    }
}
