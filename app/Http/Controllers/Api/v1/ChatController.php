<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Chat\EditMessageRequest;
use App\Http\Requests\Chat\SendMessageRequest;
use App\Services\v1\ChatService;
use Illuminate\Http\Request;

class ChatController extends ApiController
{
    private ChatService $chatService;

    public function __construct() {
        $this->chatService = new ChatService();
    }

    public function sendMessage(SendMessageRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->chatService->sendMessage(auth('api')->user(), $data));
    }

    public function editMessage($id, EditMessageRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->chatService->editMessage($id, auth('api')->user(), $data));
    }

    public function deleteMessage($id)
    {
        return $this->result($this->chatService->deleteMessage($id, auth('api')->user()));
    }
}
