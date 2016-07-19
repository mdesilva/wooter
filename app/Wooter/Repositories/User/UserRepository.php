<?php

namespace Wooter\Wooter\Repositories\User;

use DB;
use Wooter\UserRole;
use Wooter\Role;
use Wooter\User;

class UserRepository
{

    /**
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->push();
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function update(User $user)
    {
        return $user->push();
    }

    /**
     * @param $userId
     * @return User
     */
    public function getById($userId)
    {
        return User::whereId($userId)->first();
    }

    /**
     * @param $phone
     *
     * @return mixed
     */
    public function getByPhone($phone)
    {
        return User::wherePhone($phone)->first();
    }

    /**
     * @param $email
     *
     * @return mixed
     */
    public function getByEmail($email)
    {
        return User::whereEmail($email)->first();
    }

    /**
     * @param $userIds
     *
     * @return mixed
     */
    public function getFromIds($userIds)
    {
        return User::whereIn('id', $userIds)->get();
    }

    /**
     * @param $facebookId
     *
     * @return mixed
     */
    public function getFromFacebookId($facebookId)
    {
        return User::whereFacebookId($facebookId)->first();
    }

    /**
     * @param $playerId
     * @param $leagueId
     *
     * @return mixed
     */
    public function getTeamPlayingLeague($playerId, $leagueId)
    {
        return User::find( $playerId  )->teams()->whereHas('leagues',
            function($query) use($leagueId)
            {
                $query->where('leagues.id', '=', $leagueId );

            })->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return User::all();
    }
    
    public function search($params) {
        $query = DB::table('users');
        

        if (isset($params['leagueId']) && $params['leagueId'] !== '' && $params['leagueId'] !== false) {
            $query->leftjoin('player_league', 'player_league.player_id', '=', 'users.id');
            $query->where('player_league.league_id', '=', $params['leagueId']);
        }

        if (isset($params['teamId']) && $params['teamId'] !== '' && $params['teamId'] !== false) {
            $query->leftjoin('player_team', 'player_team.player_id', '=', 'users.id');
            $query->where('player_team.team_id', '=', $params['teamId']);
        }

        if (isset($params['q']) && $params['q'] !== '' && $params['q'] !== false) {
            $query->whereRaw('lower(CONCAT_WS(" ", users.first_name, users.last_name)) LIKE lower(?)', ['%'.$params['q'].'%']);
        }
        
        $userIds = $query->distinct()->lists('users.id');
        $pages = $this->paginateUsers(count($userIds), $params['limit']);
        $users = User::whereIn('id', $userIds)->orderBy($params['orderBy'], $params['orderDirection'])->skip($params['offset'])->take($params['limit'])->get();
    
        return [
            'users' => $users,
            'pages' => $pages
        ];
    }
    
    private function paginateUsers($total, $limit) 
    {
        $quotient = $total / $limit;
        if ($quotient <= 1) {
            return 1;
        } else {
            $whole = floor($quotient);
            $fraction = $quotient - $whole;
            return $fraction ? $whole + 1 : $whole;
        }
    }

    public function getByFilters($offset, $limit, $orderBy, $orderDirection)
    {
        return User::orderBy($orderBy, $orderDirection)
            ->get()
            ->slice($offset, $limit);
    }

}
