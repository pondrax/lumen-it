<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use App\Models\App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
	
    public function read($id = 'all'){
        $result = Role::table(); 
        return $this->response($result);
    }
    
    public function create(Request $request){
		$data	= $this->validate($request, Role::rules['create']);
		$result = Role::create($data);
		return $this->response(['message'=>"Created ($result->id)"], 201);
    }
    
    public function update(Request $request, $id){
		$data = $this->validate($request, Role::rules['update']);
        $result = Role::where('id',$id)->update($data);
        return $this->response(['message'=>"Updated ($id)"]);
    }
    
    public function delete($id){
		$ids = explode(',',$id);
		$result = Role::find($ids)->each(function($data, $key){
			$data->delete();
		}); 
		return $this->response(['message'=>"Deleted ($id)"]);
    }
    
}
