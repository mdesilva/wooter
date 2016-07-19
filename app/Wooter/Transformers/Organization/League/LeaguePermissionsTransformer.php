<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;

class LeaguePermissionsTransformer extends Transformer
{
    public function transform($leaguePermission)
    {

        return [
            'id' => $leaguePermission->id,
            'league_id' => $leaguePermission->league_id,
            'type' => $leaguePermission->type,
            'permission' => $leaguePermission->permission,
        ];
    }
}
