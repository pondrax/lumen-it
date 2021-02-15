<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class BaseBuilder extends Builder 
{

    public function table()
    {
		$limit	= request('limit');
		$sort	= request('sort','id');
		$order	= request('order','desc');
		$data 	= $this->orderBy($sort,$order)
					->paginate($limit);
		$result = $data->toArray();
		unset($result['links']);
		return $result;
    }

}
