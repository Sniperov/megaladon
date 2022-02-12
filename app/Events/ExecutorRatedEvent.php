<?php

namespace App\Events;

use App\Models\Executor;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExecutorRatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $executor;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Executor $executor)
    {
        $this->executor = $executor;
    }
}
