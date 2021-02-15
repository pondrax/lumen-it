<?php

namespace App\Models\App;

use App\Models\Base\Model;

class Role extends Model 
{
	protected $table = 'app_role';
	
	protected $guarded = [];
	
	const rules = [
		'create' => [
			'role' => 'required',
			'description' => 'required'
		],
		'update' => [
			'role' => 'required',
			// 'description' => 'required'
		]
	]; 
}
