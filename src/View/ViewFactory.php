<?php

namespace Sebastienheyd\Boilerplate\View;

use Illuminate\View\Factory;

class ViewFactory extends Factory
{
    /**
     * The "once" block IDs that have been rendered.
     *
     * @var array
     */
    public $renderedOnce = [];

    /**
     * Determine if the given once token has been rendered.
     *
     * @param  string  $id
     * @return bool
     */
    public function hasRenderedOnce(string $id)
    {
        return isset($this->renderedOnce[$id]);
    }

    /**
     * Mark the given once token as having been rendered.
     *
     * @param  string  $id
     * @return void
     */
    public function markAsRenderedOnce(string $id)
    {
        $this->renderedOnce[$id] = true;
    }

    public function flushState()
    {
        parent::flushState();

        $this->renderedOnce = [];
    }
}
