<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat_id;
    public $text;
    public $excludeUsers;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($chat_id, $text, $excludeUsers = [])
    {
        $this->chat_id = $chat_id;
        $this->text = $text;
        $this->excludeUsers = $excludeUsers;
    }

}
