<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
	
    public function read($id = 'all'){
        $result = Role::table(); 
        return response()->json($result);
    }
    
    public function create(Request $request){
		$data	= $this->validate($request, [
			'role'			=> 'required',
			'description'	=> 'required'
		]);
		$result = Role::create($data);
		return response()->json(['inserted'=>$result->id]);
    }
    
    public function update(Request $request, $id){
        $data = Role::find($id);
        $data->role = 'coba';
        $data->description = 'coba';
        $result = $data->save();
        return response()->json($result, 200);
    }
    
    public function delete($id){
		try{
			$ids = explode(',',$id);
			$result = Role::find($ids)->each(function($data, $key){
				$data->delete();
			}); 
			return response()->json(['deleted'=>$id]);
		}catch(Exception $e){
			return response()->json(['message'=>'Delete Error','error'=>$e], 400);		
		}
    }
    
}
