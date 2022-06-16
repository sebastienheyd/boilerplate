<?php

namespace Sebastienheyd\Boilerplate\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RefreshDatatable implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function broadcastAs()
    {
        return 'RefreshDatatable';
    }

    public function broadcastOn()
    {
        return new PrivateChannel(channel_hash('dt', $this->name));
    }
}
