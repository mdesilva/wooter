<?php

namespace Wooter\Wooter\Transformers;

use Wooter\Location;

class LocationTransformer extends Transformer
{
    public function transform($location)
    {
        $distance = '';
        $coordinates = json_decode(cookie('ZIP_COORDS'), true);

        if (isset($coordinates['latitude']) && isset($coordinates['longitude'])) {

            $longitude = $coordinates['longitude'];
            $latitude = $coordinates['latitude'];

            $earthRadius = Location::DISTANCE_KILOMETERS;

            $distance =  $earthRadius *
                acos (
                    cos ( deg2rad( $longitude ) )
                    * cos( deg2rad( $location->longitude ) )
                    * cos( deg2rad( $location->latitude ) - deg2rad($latitude) )
                    + sin ( deg2rad($longitude) )
                    * sin( deg2rad( $location->longitude ) )
                );
        }

        return [
            'id' => $location->id,
            'country' => $location->country->name,
            'country_name' => $location->country->name,
            'country_id' => $location->country->id,
            'city' => $location->city->name,
            'city_name' => $location->city->name,
            'city_id' => $location->city->id,
            'state' => $location->state,
            'longitude' => round($location->longitude, 11),
            'latitude' => round($location->latitude, 11),
            'name' => $location->name,
            'street' => $location->street,
            'zip' => $location->zip,
            'full_address' => $location->full_address,
            'flat' => $location->flat,
            'distance' => $distance,
        ];

    }
}
