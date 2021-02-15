<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use App\Models\App\Logs;

class LogController extends Controller
{
	
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function read($id = 'all'){
        $result = Logs::table(); 
        return $this->response($result);
    }
    
}
