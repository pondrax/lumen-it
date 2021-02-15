<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\App\Logs;

class Logger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$data = new Logs;
		$data->user 	= 'Guest';
		$data->route 	= $request->path();
		$data->method 	= $request->method();
		$data->data 	= json_encode($request->all());
		$data->ip 		= $request->ip();
		$data->save();
        return $next($request);
    }
}
