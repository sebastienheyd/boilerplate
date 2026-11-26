<?php

namespace Sebastienheyd\Boilerplate\Tests\Workbench;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

/**
 * Router of the local demo server (workbench/server.php): static files must be cacheable by the browser.
 */
class ServerRouterTest extends TestCase
{
    private static Process $server;
    private static string $public;
    private static int $port;

    public static function setUpBeforeClass(): void
    {
        self::$public = sys_get_temp_dir().'/bp-router-'.uniqid();
        mkdir(self::$public.'/assets', 0755, true);
        file_put_contents(self::$public.'/assets/app.css', 'body{}');
        file_put_contents(self::$public.'/index.php', '<?php echo "laravel";');
        touch(self::$public.'/assets/app.css', strtotime('2026-01-01 00:00:00 UTC'));

        $socket = stream_socket_server('tcp://127.0.0.1:0');
        self::$port = (int) substr(strrchr(stream_socket_get_name($socket, false), ':'), 1);
        fclose($socket);

        self::$server = new Process([PHP_BINARY, '-S', '127.0.0.1:'.self::$port, __DIR__.'/../../workbench/server.php'], self::$public);
        self::$server->start();

        // Wait for the server to accept connections, at most 5 seconds
        $deadline = microtime(true) + 5;
        while (microtime(true) < $deadline) {
            $connection = stream_socket_client('tcp://127.0.0.1:'.self::$port, $errno, $error, 0.1);
            if ($connection !== false) {
                fclose($connection);
                break;
            }
            usleep(50000);
        }
    }

    public static function tearDownAfterClass(): void
    {
        self::$server->stop();
        array_map('unlink', [self::$public.'/assets/app.css', self::$public.'/index.php']);
        rmdir(self::$public.'/assets');
        rmdir(self::$public);
    }

    private function request(string $uri, array $headers = []): array
    {
        $context = stream_context_create(['http' => ['header' => $headers, 'ignore_errors' => true]]);
        $body = file_get_contents('http://127.0.0.1:'.self::$port.$uri, false, $context);

        return [$http_response_header, $body];
    }

    private function header(array $response, string $name): ?string
    {
        foreach ($response[0] as $line) {
            if (stripos($line, $name.':') === 0) {
                return trim(substr($line, strlen($name) + 1));
            }
        }

        return null;
    }

    public function testVersionedAssetIsImmutable()
    {
        $response = $this->request('/assets/app.css?id=0123abcd');
        $this->assertStringContainsString('200', $response[0][0]);
        $this->assertSame('body{}', $response[1]);
        $this->assertStringStartsWith('text/css', $this->header($response, 'Content-Type'));
        $this->assertSame('public, max-age=31536000, immutable', $this->header($response, 'Cache-Control'));
    }

    public function testUnversionedAssetCanBeRevalidated()
    {
        $response = $this->request('/assets/app.css');
        $this->assertSame('no-cache', $this->header($response, 'Cache-Control'));
        $this->assertSame('Thu, 01 Jan 2026 00:00:00 GMT', $this->header($response, 'Last-Modified'));

        $response = $this->request('/assets/app.css', ['If-Modified-Since: Thu, 01 Jan 2026 00:00:00 GMT']);
        $this->assertStringContainsString('304', $response[0][0]);
        $this->assertSame('', $response[1]);
    }

    public function testOtherRequestsGoToLaravel()
    {
        $this->assertSame('laravel', $this->request('/admin/login')[1]);
        $this->assertSame('laravel', $this->request('/')[1]);
    }
}
