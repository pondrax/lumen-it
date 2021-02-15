<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use App\Models\App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
	
    public function read($id = 'all'){
        $result = User::table(); 
        return $this->response($result);
    }
    
    public function create(Request $request){
		$data	= $this->validate($request, User::rules['create']);
		$data['password'] = app('hash')->make($data['password']);
		$result = User::create($data);
		return $this->response(['message'=>"Created ($result->id)"], 201);
    }
    
    public function update(Request $request, $id){
		$data = $this->validate($request, User::rules['update']);
		if(!empty($data['password'])){
			$data['password'] = app('hash')->make($data['password']);
		}
        $result = User::where('id',$id)->update($data);
		return $this->response(['message'=>"Updated ($id)"]);
    }
    
    public function delete($id){
		$ids = explode(',',$id);
		$result = User::find($ids)->each(function($data, $key){
			$data->delete();
		}); 
		return $this->response(['message'=>"Deleted ($id)"]);
    }
    
}
