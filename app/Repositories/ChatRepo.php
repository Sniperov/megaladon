<?php

namespace App\Repositories;

use App\Models\ChatMessage;

class ChatRepo
{
    public function storeChatMessage(array $data)
    {
        return ChatMessage::create($data);
    }

    public function editMessage(ChatMessage $chatMessage, array $data)
    {
        return $chatMessage->update($data);
    }

    public function deleteMessage($message_id)
    {
        ChatMessage::find($message_id)->delete();
    }
}