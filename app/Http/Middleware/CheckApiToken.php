<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckApiToken
{
    protected $except = [
        'api/auth/login',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(in_array($request->path(),$this->except)){ return $next($request); }
        if(auth('sanctum')->check())
        {
            $is_exists = User::find(auth('sanctum')->user()->id);
            if($is_exists){ return $next($request); }
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid Token'
        ], 401);
    }
}
