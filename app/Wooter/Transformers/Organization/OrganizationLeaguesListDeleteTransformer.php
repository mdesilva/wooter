<?php

namespace Wooter\Wooter\Transformers\Organization;

use Wooter\Wooter\Transformers\Transformer;

class OrganizationLeaguesListDeleteTransformer extends Transformer {

    /**
     * Transform method
     *
     * @param $response
     * @return mixed
     */
    public function transform ($response) {
        $message = ( $response['state']) ? $response['name']." was deleted!":"Something wrong, your league don't exist!";

        $return = [
            'success' => $response['state'],
            'message' => $message
        ];
        
        return $return;
    }
}
