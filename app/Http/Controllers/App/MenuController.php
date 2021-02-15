<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use App\Models\App\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
	
    public function read($id = 'all'){
        $result = Menu::table(); 
        return $this->response($result);
    }
    
    public function create(Request $request){
		$data	= $this->validate($request, Menu::rules['create']);
		$result = Menu::create($data);
		return $this->response(['message'=>"Created ($result->id)"], 201);
    }
    
    public function update(Request $request, $id){
		$data = $this->validate($request, Menu::rules['update']);
        $result = Menu::where('id',$id)->update($data);
		return $this->response(['message'=>"Updated ($id)"]);
    }
    
    public function delete($id){
		$ids = explode(',',$id);
		$result = Menu::find($ids)->each(function($data, $key){
			$data->delete();
		}); 
		return $this->response(['message'=>"Deleted ($id)"]);
    }
    
}
