<?php

namespace Sebastienheyd\Boilerplate\Tests\Helpers;

use Sebastienheyd\Boilerplate\Tests\TestCase;

class ChannelHashTest extends TestCase
{
    public function testChannelHashGeneratesSignature()
    {
        $signature = md5('Notifications|1'.config('app.key').config('app.url'));
        $expected = 'Notifications.1.'.$signature;

        $this->assertEquals($expected, channel_hash('Notifications', 1));
    }

    public function testChannelHashEqualsSuccess()
    {
        $signature = md5('Notifications|1'.config('app.key').config('app.url'));

        $this->assertTrue(channel_hash_equals($signature, 'Notifications', 1));
    }

    public function testChannelHashEqualsFailure()
    {
        $signature = md5('Notifications|2'.config('app.key').config('app.url'));

        $this->assertFalse(channel_hash_equals($signature, 'Notifications', 1));
    }
}
