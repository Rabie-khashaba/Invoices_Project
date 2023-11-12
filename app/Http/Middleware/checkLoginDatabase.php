<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkLoginDatabase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user()->Status;  // يعني المستخدم ال هيسجل هات الحاله بتاعته

            if($user == 'غير مفعل'){
                return response()->json(['error' => 'هذا الحساب غير مفعل'], 500);
            }

        return $next($request);
    }
}
