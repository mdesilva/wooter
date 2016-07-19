<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;

class LeagueInfoTransformer extends Transformer {

    public function transform($league) {
        $organization = $league->organization()->first();

        return [
            'id' => $league->first()->id,
            'name' => $league->first()->name,
            'description' => $league->details()->first()->description,
            'organization' => [
                'id' => $organization->id,
                'name' => $organization->name,
                'email' => $organization->email,
                'description' => $organization->description,
                'phone' => $organization->phone,
                'image' => $organization->image,
                'social' => [
                    'facebook' => $organization->facebook,
                    'twitter' => $organization->twitter,
                    'instagram' => $organization->instagram,
                    'pinterest' => $organization->pinterest,
                    'google' => $organization->google
                ]
            ]
        ];
    }
}
