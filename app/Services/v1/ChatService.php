<?php

namespace App\Services\v1;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use App\Repositories\ChatRepo;
use App\Services\BaseService;

class ChatService extends BaseService
{
    private ChatRepo $chatRepo;

    public function __construct() {
        $this->chatRepo = new ChatRepo();
    }

    public function sendMessage(User $user, array $data)
    {
        $data['user_id'] = $user->id;
        return $this->result(['message' => $this->chatRepo->storeChatMessage($data)]);
    }

    public function editMessage(int $message_id, User $user, array $data)
    {
        $chatMessage = ChatMessage::find($message_id);

        if (is_null($chatMessage)) {
            return $this->errNotFound('Сообщение не найдено');
        }

        if ($chatMessage->user_id != $user->id) {
            return $this->error(406, 'Вы не можете редактировать чужие сообщения');
        }

        $message = $this->chatRepo->editMessage($chatMessage, $data);

        return $this->result([
            'message' => 'Сообщение изменено',
            'data' => $message,
        ]);
    }

    public function deleteMessage(int $message_id, User $user)
    {
        $chatMessage = ChatMessage::find($message_id);

        if (is_null($chatMessage)) {
            return $this->errNotFound('Сообщение не найдено');
        }

        if ($chatMessage->user_id != $user->id) {
            return $this->error(406, 'Вы не можете редактировать чужие сообщения');
        }

        $this->chatRepo->deleteMessage($message_id);

        return $this->ok('Сообщение удалено');
    }
}