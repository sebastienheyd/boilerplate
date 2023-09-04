<?php

namespace Sebastienheyd\Boilerplate\Tests\Dashboard;

use Sebastienheyd\Boilerplate\Dashboard\Widget;

class FakeWidget extends Widget
{
    protected $slug = 'fake-widget';

    public function make()
    {
    }
}
