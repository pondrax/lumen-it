<?php

namespace App\Models\App;

use App\Models\BaseModel;

class Role extends BaseModel 
{
	protected $table = 'app_role';
	
	protected $fillable = ['role','description'];
	
	// protected $guarded = [];
	
	public function store(){
		return [
			'role'			=> 'required',
			'description'	=> 'required'
		];
	}
}
