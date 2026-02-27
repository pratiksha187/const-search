<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        if (session()->has('tenant_db')) {

            $dbName = session('tenant_db');

            Config::set('database.connections.tenant.database', $dbName);

            DB::purge('tenant');
            DB::reconnect('tenant');
        }

        return $next($request);
    }
}