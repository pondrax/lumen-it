<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Builder as BaseBuilder;

class Builder extends BaseBuilder 
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
