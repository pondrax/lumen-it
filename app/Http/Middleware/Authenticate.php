<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\App\Access;
use App\Models\App\Route;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }else{
			// Check if current role is allowed
			$user		= $this->auth->user();
			$controller = str_replace('App\\Http\\Controllers\\', '', $request->route()[1]['uses']);
			$route 		= Route::where('controller', $controller)->first();
			
			$access		= Access::where('role_id', $user->role_id)->where('route_id', $route->id);
			// var_dump($user->role_id, $route->id);
			if($access->doesntExist()){
				return response()->json(['message' => 'Role is not Allowed for this Route.'], 401);
			}
		}

        return $next($request);
    }
}
