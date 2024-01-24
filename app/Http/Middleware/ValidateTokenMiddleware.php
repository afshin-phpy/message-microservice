<?php

namespace App\Http\Middleware;

use App\Http\Resources\APIResource;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ValidateTokenMiddleware
{
    protected $authApiUrl;
    protected $endPointPath;

    public function __construct()
    {
        // $this->authApiUrl   = config("auth_service.api_url");
        $this->endPointPath = "/api/token/validate";
    }

    public function handle(Request $request, Closure $next)
    {
        try {

            $token = $request->header('Authorization');

            // Optionally remove the bearer prefix if present
            $token = str_replace('Bearer ', '', $token);

            // Validate the token by sending it to the external service
            // validate token
            $response = Http::withToken($token)->post("http://192.168.130.52:8000".$this->endPointPath);
            if($response->failed()) {
                return APIResource::error('Unauthorized', 401);
            }
            $data = $response->json();

            // return $data['data']['user_id'];
            $request->merge(['user_id' =>   $data['data']['user_id']]);

            // Token is valid, proceed with the request
            return $next($request);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 401);
        }
    }
}
