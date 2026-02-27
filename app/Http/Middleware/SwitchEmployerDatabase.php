<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SwitchEmployerDatabase
{
    public function handle($request, Closure $next)
    {
        if (session()->has('employer_db')) {

            $databaseName = session('employer_db');

            // 🔥 Modify TENANT connection, not mysql
            Config::set('database.connections.tenant.database', $databaseName);

            DB::purge('tenant');
            DB::reconnect('tenant');
        }

        return $next($request);
    }
}