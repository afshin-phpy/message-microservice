<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class APIResource extends JsonResource
{
    private $isError;
    private $errorCode;
    private $errorMessage;

    public static function success($data)
    {
        return new APIResource($data);
    }

    public static function error($message, $code = 400)
    {
        return (new APIResource(null))->setError($message, $code);
    }

    private function setError($message, $code)
    {
        $this->isError = true;
        $this->errorCode = $code;
        $this->errorMessage = $message;
        return $this;
    }

    public function toArray($request) : array
    {
        return $this->isError ? $this->errorResponse() : $this->successResponse();
    }

    private function successResponse() : array
    {
        return ['data' => $this->resource];
    }

    private function errorResponse() : array
    {
        return [
            'error' => [
                'message' => $this->errorMessage,
                'code' => $this->errorCode
            ]
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->isError ? $this->errorCode : 200);
    }
}
