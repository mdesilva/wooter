<?php

namespace Wooter\Wooter\Transformers\StaticPages;

use Wooter\Wooter\Transformers\Transformer;

class ServiceRequestTransformer extends Transformer
{
    public function transform($serviceRequest)
    {
        return [
            'id' => $serviceRequest->id,
            'email' => $serviceRequest->email,
            'name' => $serviceRequest->name,
            'phone' => $serviceRequest->phone,
            'sport' => $serviceRequest->sport,
            'type' => $serviceRequest->type,
            'address_1' => $serviceRequest->address_1,
            'address_2' => $serviceRequest->address_2,
            'number_of_teams' => $serviceRequest->number_of_teams,
            'number_of_players' => $serviceRequest->number_of_players,
            'number_of_games_per_team' => $serviceRequest->number_of_games_per_team,
        ];
    }
}