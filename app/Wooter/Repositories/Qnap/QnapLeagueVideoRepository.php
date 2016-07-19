<?php

namespace Wooter\Wooter\Repositories\Qnap;

use DB;
use Wooter\QnapLeagueVideo;

class QnapLeagueVideoRepository
{


    public function create(QnapLeagueVideo $qnapLeagueVideo)
    {
        return $qnapLeagueVideo->save();
    }



    public function getByHash($hash)
    {
        return QnapLeagueVideo::whereVideoHash($hash)->first();
    }



    public function readAll()
    {
        return QnapLeagueVideo::all();
    }



    public function getByLeagueIdAndFileName($league_id, $filename)
    {
        return QnapLeagueVideo::whereLeagueId($league_id)->whereFileName($filename)->first();
    }




    public function delete(QnapLeagueVideo $qnapLeagueVideo)
    {
        return $qnapLeagueVideo->delete();
    }


}
