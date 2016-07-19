<?php

namespace Wooter\Wooter\Transformers;

class ScheduleDemoTransformer extends Transformer
{
    public function transform($status)
    {
    	return [
           'status' => $status
       ];
    }
}