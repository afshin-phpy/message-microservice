<?php

namespace App\Repositories;

use App\Models\Message;
use App\Repositories\Contracts\MessageRepositoryInterface;
use Exception;

class EloquentMessageRepository implements MessageRepositoryInterface
{
    public function create(array $data) : Message
    {
        try {
            return Message::create($data);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}