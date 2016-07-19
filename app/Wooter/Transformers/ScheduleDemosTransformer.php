<?php

namespace Wooter\Wooter\Transformers;

class ScheduleDemosTransformer extends Transformer
{
    public function transform($data, $multiple = false)
    {

    	$return = [];

        if($multiple){
            foreach ($data as $item){
                $return[] = $this->render($item);
            }
        } else {
            $return = $this->render($data);
        }

        return $return;
    }

    private function render ($item) {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'email' => $item->email,
            'phone' => $item->phone,
            'comments' => $item->comments,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at
        ];
    }
}