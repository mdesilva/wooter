<?php

namespace Wooter\Wooter\Transformers;

class ReadAllContactTransformer extends Transformer
{
    public function transform($data)
    {
    	$array = array();
    	foreach ($data as $key => $value) {
    		$array[] = [
    		'id'=>$value->id,
        	'name' => $value->name,
        	'email' => $value->email,
        	'phone' => $value->phone,
        	'comments' => $value->comments,
    		'date' => $value->created_at,
       		];
    	}
    	return $array;
    }
}