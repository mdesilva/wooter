<?php

namespace Wooter\Wooter\Transformers;

class ContactTransformer extends Transformer
{
    public function transform($status)
    {
    	return [
           'status' => $status
       ];
    }
}