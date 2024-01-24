<?php

namespace App\Http\Controllers;

use App\Http\Resources\APIResource;
use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $messageService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function store(Request $request) //: APIResource
    {
        try {
            $this->validate($request, [
                'user_id'       =>  'required',
                'title'         =>  'required|string',
                'content'       =>  'required|string'
            ]);

            return APIResource::success(
                $this->messageService->storeMessage($request->only(['user_id', 'title', 'content']))
            );
        } catch (\Throwable $th) {
            return APIResource::error($th->getMessage());
        }
    }
}
