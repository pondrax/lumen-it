<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    public function register(Request $request){
		$this->validate($request, [
			'email'		=> 'required|email',
			'username'	=> 'required',
			'password'	=> 'required'
		]);
		// try {
            $user = new User;
            $user->role_id	= 2;
            $user->email 	= $request->post('email');
            $user->username = $request->post('username');
            $plainPassword 	= $request->post('password');
            $user->password = app('hash')->make($plainPassword);
            // var_dump($user);
            $user->save();
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);
        // } catch (\Exception $e) {
            // return response()->json(['message' => 'User Registration Failed!'], 409);
        // }
    }
    
    public function login(Request $request){
        $data = Role::find($id);
        $data->role = 'coba';
        $data->description = 'coba';
        $result = $data->save();
        return response()->json($result, 200);
    }
    
}
