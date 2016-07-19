<?php

namespace Wooter\Wooter\Transformers;

class GameVenueTransformer extends Transformer
{
    /**
     * @var LocationTransformer
     */
    private $locationTransformer;

    /**
     * @param LocationTransformer $locationTransformer
     */
    public function __construct(LocationTransformer $locationTransformer) {

        $this->locationTransformer = $locationTransformer;
    }

    public function transform($gameVenue)
    {
        return [
            'id' => $gameVenue->id,
            'court_name' => $gameVenue->court_name,
            'number_of_courts' => $gameVenue->number_of_courts,
            'location' => $this->locationTransformer->transform($gameVenue->location),
        ];
    }
}
