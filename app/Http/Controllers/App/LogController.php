<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\App\Logs;

class LogController extends Controller
{
	
    public function read($id = 'all'){
        $result = Logs::table(); 
        return response()->json($result);
    }
    
}
