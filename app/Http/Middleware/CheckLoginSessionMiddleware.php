<?php

namespace App\Http\Middleware;

use App\Models\LoginSession;
use Closure;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLoginSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       try {
            if(auth()->check()):
                $loginUserCount = LoginSession::where(['user_id'=>auth()->user()->id,'is_logged_in'=>'0'])->get();
                if($loginUserCount->count() <=0):
                    session()->invalidate();
                    session()->regenerateToken();
                    return redirect()->route('admin.login');
                endif;
            endif;
            return $next($request);
       } catch (\Exception  $th) {
            dd($th->getMessgae());
       }
        
    }
}
