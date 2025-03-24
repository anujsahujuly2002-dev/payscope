<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests as BaseThrottleRequests;

class CustomThrottleRequests extends BaseThrottleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int|string  $maxAttempts
     * @param  int|string  $decayMinutes
     * @param  string  $prefix
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        // Call the parent handle method
        $response = parent::handle($request, $next, $maxAttempts, $decayMinutes, $prefix);
        
        // Customize the response in case of "Too Many Requests"
        if ($response->status() === 429) {
            $response->setContent(json_encode([
                'message' => 'Too many requests. Please slow down.',
                'status' => 429,
                'retry_after' => $response->headers->get('Retry-After'),
            ]));
        }

        return $response;
    }
}
