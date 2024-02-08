<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\CacheQueryResults;
use App\Models\LoginSession;

class SessionTimeOutHandleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if(auth()->check() && auth()->user()->id >= 1):
                $lastActivityTime = DB::table('sessions')->where('user_id',auth()->user()->id)->first();
                $lastActivity = Carbon::parse($lastActivityTime->last_activity);
                // dd(now(),now()->diffInMinutes($lastActivity),(config('session.lifetime') - 1));
                if(now()->diffInMinutes($lastActivity) >= (config('session.lifetime') - 1)):
                    $user = auth()->user()->id;
                    LoginSession::where(['user_id'=>$userId,'is_logged_in'=>'0'])->update([
                        'is_logged_in' => '1',
                        'logout_time'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                    auth()->logout();
                    return redirect()->route('admin.login');
                endif;
                return $next($request);
            endif;
            return $next($request);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        
    }
}
