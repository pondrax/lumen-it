<?php

namespace App\Http\Middleware;

use Closure;

class ThrowError
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
        $response = $next($request);
        if($response->exception){
			return response()->json([
				'message' => 'Error', 
				'error'	  => $response->exception->getMessage()
			],500);
		}else{
			return $response;
		}
    }
}
