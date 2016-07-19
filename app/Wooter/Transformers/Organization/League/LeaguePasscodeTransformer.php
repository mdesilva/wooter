<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;

class LeaguePasscodeTransformer extends Transformer
{
    public function transform($leaguePasscode)
    {
        $result = [
            'id'       => $leaguePasscode->id,
            'league_id'=> $leaguePasscode->league->id,
            'passcode' => $leaguePasscode->passcode,
        ];

        return $result;
    }
}