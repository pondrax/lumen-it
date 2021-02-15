<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use App\Models\App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function register(Request $request){
		$this->validate($request, User::rules['register']);
		try {
            $user = new User;
            $user->role_id	= 4;
            $user->email 	= $request->post('email');
            $user->username = $request->post('username');
            $user->password = app('hash')->make($request->post('password'));
            $user->save();
            
			$credentials = $request->only(['username', 'password']);
			Auth::attempt($credentials);
			
            return $this->response(['message' => 'Registration Successfull'], 201);
            
        } catch (\Exception $e) {
            return $this->response([
				'message' => 'Registration Failed!',
				'error'	  => $e->getMessage()
			], 409);
        }
    }
    
    public function login(Request $request){
		$this->validate($request, User::rules['login']);
        $credentials = $request->only(['username', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return $this->response(['message' => 'Username or Password doesn\'t match'], 401);
        }
        
		return $this->response(['message' => 'Welcome back :D'], 200);
    }
    
}
