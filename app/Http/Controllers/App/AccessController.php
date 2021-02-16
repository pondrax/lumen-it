<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use App\Models\App\Access;
use Illuminate\Http\Request;

class AccessController extends Controller
{
	
    public function read($id = 'all'){
        $result = Access::with('role','route')->table(); 
        return $this->response($result);
    }
    
    public function create(Request $request){
		$data	= $this->validate($request, Access::rules['create']);
		$result = Access::create($data);
		return $this->response(['message'=>"Created ($result->id)"], 201);
    }
    
    public function update(Request $request, $id){
		$data = $this->validate($request, Access::rules['update']);
		$result = Access::where('id',$id)->update($data);
        return $this->response(['message'=>"Updated ($id)"]);
    }
    
    public function delete($id){
		$ids = explode(',',$id);
		$result = Access::find($ids)->each(function($data, $key){
			$data->delete();
		}); 
		return $this->response(['message'=>"Deleted ($id)"]);
    }    
}
