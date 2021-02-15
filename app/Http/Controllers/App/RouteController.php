<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use App\Models\App\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
	
    public function read($id = 'all'){
        $result = Route::table(); 
        return $this->response($result);
    }
    
    public function create(Request $request){
		$data	= $this->validate($request, Route::rules['create']);
		$result = Route::create($data);
		return $this->response(['message'=>"Created ($result->id)"], 201);
    }
    
    public function update(Request $request, $id){
		$data = $this->validate($request, Route::rules['update']);
        $result = Route::where('id',$id)->update($data);
		return $this->response(['message'=>"Updated ($id)"]);
    }
    
    public function delete($id){
		$ids = explode(',',$id);
		$result = Route::find($ids)->each(function($data, $key){
			$data->delete();
		}); 
		return $this->response(['message'=>"Deleted ($id)"]);
    }
    
}
