<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Tymon\JWTAuth\Facades\JWTAuth;
use Auth;
class CustomAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->bearerToken();
            $user = auth('api')->setToken($token)->user();
            if (!$user) {
                return response()->json([
                    "status" => false ,
                    "message" => "your are unauthorized .. please login again ",
                    "statusNumber"=> 400
                ]);            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => false ,
                "message" =>"your are unauthorized .. please login again" ,
                "statusNumber"=> 400
            ]);
        }

        return $next($request);
    }
}
