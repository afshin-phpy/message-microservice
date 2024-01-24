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
        $this->authApiUrl   = config("auth_service.api_url");
        $this->endPointPath = "/api/token/validate";
    }

    public function handle(Request $request, Closure $next)
    {
        try {
            $hostname = gethostname();

            // Get the IP address associated with the hostname
            // return $localIP = gethostbyname($hostname);
            $token = $request->header('Authorization');

            // Optionally remove the bearer prefix if present
            $token = str_replace('Bearer ', '', $token);

            // Validate the token by sending it to the external service
            // validate token
            $response = Http::withToken($token)->post("http://192.168.130.52:8000/api/token/validate");
            if($response->failed()) {
                return APIResource::error('Unauthorized', 401);
            }

            // Token is valid, proceed with the request
            return $next($request);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 401);
        }
    }
}
