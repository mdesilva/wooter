<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;

class LeagueBasicsTransformer extends Transformer
{
    public function transform($leagueBasics)
    {
        $leagueBasics = $leagueBasics->fresh();

        $logo = [];
        if ($leagueBasics->logo) {
            $logo = [
                'id' => $leagueBasics->logo->id,
                'mime_type' => $leagueBasics->logo->mime_type,
                'extension' => $leagueBasics->logo->extension,
                'size' => $leagueBasics->logo->size,
                'file_path' => $leagueBasics->logo->file_path,
                'thumbnail_path' => $leagueBasics->logo->thumbnail_path,
                'file_name' => $leagueBasics->logo->file_name,
            ];
        }

        $result = [
            'id' => $leagueBasics->id,
            'league_id' => $leagueBasics->league_id,
            'logo_id' => $leagueBasics->logo_id,
            'min_age' => $leagueBasics->min_age,
            'max_age' => $leagueBasics->max_age,
            'gender' => $leagueBasics->gender,
            'league_name' => $leagueBasics->league->name,
            'sport' => $leagueBasics->league->sport->id,
            'sport_id' => $leagueBasics->league->sport->id,
        ];

        return array_merge($result, ['logo' => $logo]);
    }
}