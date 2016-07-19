<?php

namespace Wooter\Http\Controllers\Notifications;

use Exception;
use Illuminate\Http\Request;

use Wooter\Commands\Notifications\SendEmail;
use Wooter\Commands\Notifications\SendTwilioSMS;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;
use Wooter\Wooter\Exceptions\User\UserNotFound;

final class NotifyUserController extends Controller
{
    public function notifyUser(Request $request)
    {
        try
        {
            $emailSent = $this->dispatchFrom(SendEmail::class, $request);
            $smsSent = $this->dispatchFrom(SendTwilioSMS::class, $request);

            if ($emailSent && $smsSent) {
                $this->content = 'Success';
            } else {
                $this->content = 'Fail';
            }
        } catch (UserNotFound $e) {
            $this->error = $e->getMessage();
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }

        return [
            'success' => ! $this->error,
            'error' => $this->error,
            'content' => $this->content
        ];
    }
}
