<?php

namespace Wooter\Http\Controllers\User;

use Wooter\Commands\User\VerifyUserTokenCommand;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;
use Wooter\User;
use Wooter\Role;
use Wooter\UserVerification;


class VerifyUser extends Controller
{
    const SuccessVerify = 200;
    const WrongToken = 404;

    /**
     * @param $token
     * @return array
     */
    public function verifyToken($token){
        $type = false;
        $uid = null;
        if($this->tokenExist($token)){
            $type = $this->getTypeof($token);
            $uid = $this->getUid($token);
            $response = $this->dispatch(new VerifyUserTokenCommand($token));
        } else {
            $response = self::WrongToken;
        }
        
        return response()->json([
            'success' => ($response == self::SuccessVerify)?true:false,
            'type' => $type,
            'error' => $this->getError($response)
        ], ($response == self::SuccessVerify)?200:422);
    }

    private function tokenExist($token){
        $res = UserVerification::wheretoken($token)->first();
        return (!is_null($res))?true:false;
    }

    private function getTypeof($token){
        if($this->tokenExist($token)) {

            $email = UserVerification::wheretoken($token)->first()->email;
            $user = User::whereemail($email)->first();

            if($user->preselected_role == Role::ORGANIZATION){
                return "organization";
            } else {
                if($user->preselected_role == Role::ATHLETE){
                    return 'athlete';
                } else {
                    return null;
                }
            }
        } else {
            return null;
        }
    }

    private function getError($response){
        switch($response){
            case self::WrongToken:
                return "Token don't exist or account is confirmed!";

            case self::SuccessVerify:
                return "Successfully Verified, we will redirect in some moments";

            default:
                return "Something went wrong try again later!";
        }
    }

    private function getUid($token){
        if($this->tokenExist($token)) {
            $email = UserVerification::wheretoken($token)->first()->email;
            $user = User::whereemail($email)->first();
            return $user->id;
        } else {
            return null;
        }
    }
}
