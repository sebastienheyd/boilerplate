<?php

/*
 * Router of the local demo server (composer serve, docker compose), copied to the Testbench skeleton by
 * "composer build" and used by "testbench serve" instead of the Laravel one.
 *
 * The PHP built-in server sends static files without any cache header: the browser downloads them again
 * on each page, and the Font Awesome icons (font-display: block) stay invisible meanwhile. This router
 * serves them with the headers of a real web server: versioned assets (Mix "?id=" or font hash query
 * string) are immutable, the others are revalidated with Last-Modified.
 */

$publicPath = getcwd();
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '');
$file = realpath($publicPath.$uri);

if ($uri === '/' || $file === false || ! is_file($file) || ! str_starts_with($file, $publicPath.DIRECTORY_SEPARATOR)) {
    require_once $publicPath.'/index.php';

    return;
}

$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

if ($extension === 'php') {
    return false;
}

$types = [
    'css'   => 'text/css; charset=UTF-8',
    'js'    => 'text/javascript; charset=UTF-8',
    'json'  => 'application/json',
    'map'   => 'application/json',
    'svg'   => 'image/svg+xml',
    'png'   => 'image/png',
    'jpg'   => 'image/jpeg',
    'jpeg'  => 'image/jpeg',
    'gif'   => 'image/gif',
    'webp'  => 'image/webp',
    'ico'   => 'image/x-icon',
    'woff2' => 'font/woff2',
    'woff'  => 'font/woff',
    'ttf'   => 'font/ttf',
    'eot'   => 'application/vnd.ms-fontobject',
    'txt'   => 'text/plain; charset=UTF-8',
    'html'  => 'text/html; charset=UTF-8',
];

$modified = filemtime($file);
$lastModified = gmdate('D, d M Y H:i:s', $modified).' GMT';

header('Content-Type: '.($types[$extension] ?? (mime_content_type($file) ?: 'application/octet-stream')));
header('Last-Modified: '.$lastModified);
header('Cache-Control: '.(empty($_SERVER['QUERY_STRING']) ? 'no-cache' : 'public, max-age=31536000, immutable'));

$since = $_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? null;

if ($since !== null && strtotime($since) >= $modified) {
    http_response_code(304);

    return;
}

header('Content-Length: '.filesize($file));
readfile($file);
