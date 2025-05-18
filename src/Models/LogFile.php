<?php

namespace Sebastienheyd\Boilerplate\Models;

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LogFile
{
    protected Filesystem $storage;
    protected string $file;

    public static $levels = ['EMERGENCY', 'ALERT', 'CRITICAL', 'ERROR', 'WARNING', 'NOTICE', 'INFO', 'DEBUG'];

    public static function files()
    {
        $pattern = storage_path('logs/laravel-*.log');
        $files = array_map('basename', glob($pattern));
        return array_reverse($files);
    }

    public static function get($file)
    {
        return new static($file);
    }
    
    public function __construct($file)
    {
        $this->storage = Storage::disk('logs');
        $this->file = $file;

        if (! $this->storage->exists($this->file)) {
            throw new \Exception("File $file not found");
        }
    }

    public function getDate()
    {
        return Date::createFromFormat('Y-m-d', preg_replace(['/^laravel-/', '/\.log$/'], '', $this->file));
    }

    public function getFileName()
    {
        return $this->file;
    }

    public function fileSize()
    {
        return $this->storage->size($this->file);
    }

    public function fileSizeFormatted()
    {
        $bytes = $this->storage->size($this->file);
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    protected function content()
    {
        return $this->storage->readStream($this->file);
    }

    protected function formatContent($content)
    {
        $pattern = '/\[(?<date>.*)\] (?<env>\w+)\.(?<type>\w+): (?<message>.*)/';
        $entries = [];
        $lineNumber = 0;

        $stream = $content;
        $errorLineNumber = false;
        while (($line = fgets($stream)) !== false) {
            $lineNumber++;
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            if (preg_match($pattern, $line, $matches)) {
                $entries[$lineNumber] = [
                    'line' => $lineNumber,
                    'date' => Date::createFromFormat('Y-m-d H:i:s', $matches['date']),
                    'env' => $matches['env'],
                    'type' => $matches['type'],
                    'message' => $matches['message'],
                    'stacktrace' => [],
                ];
            }

            if ($line === '[stacktrace]' || $errorLineNumber !== false) {
                if (! $errorLineNumber && isset($entries[$lineNumber - 1])) {
                    $errorLineNumber = $lineNumber - 1;
                    continue;
                }

                if (preg_match($pattern, $line)) {
                    $errorLineNumber = false;
                    continue;
                }

                $line = preg_replace('/^#[0-9]+\s/', '', $line);
                $line = str_replace(base_path(), '', $line);
                $entries[$errorLineNumber]['stacktrace'][] = $line;
            }
        }

        fclose($stream);
        return array_reverse($entries);
    }

    public function parse()
    {
        return $this->formatContent($this->content());
    }

    public function stats()
    {
        $parse = $this->parse();

        $levels = [];
        foreach (static::$levels as $level) {
            $levels[$level] = 0;
        }

        foreach ($parse as $entry) {
             $levels[$entry['type']]++;
        }

        return [
            'file' => $this->file,
            'date' => $this->getDate(),
            'size' => $this->fileSize(),
            'sizeFormatted' => $this->fileSizeFormatted(),
            'entries' => count($parse),
            'levels' => $levels,
        ];
    }

    public function download(): StreamedResponse
    {
        return $this->storage->download($this->file);
    }

    public function delete(): bool
    {
        return $this->storage->delete($this->file);
    }
}
