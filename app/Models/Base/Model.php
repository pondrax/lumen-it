<?php

namespace App\Models\Base;

use App\Models\Base\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel 
{
	public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}
