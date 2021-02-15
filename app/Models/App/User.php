<?php

namespace App\Models\App;

use App\Models\BaseModel;

class User extends BaseModel 
{
	protected $table = 'app_user';
	
	protected $hidden = ['password'];
	
}
