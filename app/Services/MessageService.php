<?php

namespace App\Services;

use App\Repositories\Contracts\MessageRepositoryInterface;
use Exception;

class MessageService
{
    protected $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function storeMessage($data) : array
    {
        try {
            $this->messageRepository->create([
                'user_id'   =>  $data['user_id'],
                'title'     =>  $data['title'],
                'content'   =>  $data['content']
            ]);    

            return [
                'status'    =>  'success',
                'message'   =>  'your data has been stored.'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}