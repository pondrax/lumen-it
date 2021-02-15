<?php

namespace App\Models\App;

use App\Models\Base\Model;

class Access extends Model 
{
	protected $table = 'app_access';
	
	protected $guarded = [];
	
	const rules = [
		'create' => [
			'role_id' => 'required',
			'route_id' => 'required',
		],
		'update' => []
	]; 
	
}
