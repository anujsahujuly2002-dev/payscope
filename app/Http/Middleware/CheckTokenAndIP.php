<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ApiToken;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenAndIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $checkToken  = ApiToken::where(['ip_address'=>$request->ip(),'token'=>$request->header('X-Auth-Token')])->first();
        if(!$checkToken):
            return response()->json([
                'status'=>false,
                'msg'=>"Invalid Api token or ip address your current ip is ".$request->ip_address
            ],401);
        endif;
        // Return user ID for further processing
        $userId = $checkToken->user_id; // Assuming 'user_id' is the field that contains the user's ID
        // Optionally attach the user ID to the request for further use
        $request->attributes->set('user_id', $userId);
        // Create a response object to modify headers
        $response = $next($request);
        $response->headers->set('X-User-ID', $userId);
        return $response;
    }
}
