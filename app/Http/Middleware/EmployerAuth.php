<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EmployerAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('employer_id')) {
            return redirect()->route('employer.login')->with('error', 'Please login first.');
        }
        return $next($request);
    }
}
