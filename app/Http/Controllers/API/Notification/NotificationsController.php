<?php

namespace Wooter\Http\Controllers\API\Notification;

use Exception;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Notifications\DeleteNotificationsCommand;
use Wooter\Commands\Notifications\MarkNotificationsAsConsumedCommand;
use Wooter\Commands\Notifications\ReadNotificationsCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Transformers\Notification\NotificationTransformer;

final class NotificationsController extends ApiController
{
    /**
     * @var NotificationTransformer
     */
    private $notificationTransformer;

    /**
     * @param NotificationTransformer $notificationTransformer
     */
    public function __construct(NotificationTransformer $notificationTransformer)
    {
        $this->middleware('jwt.auth');

        $this->notificationTransformer = $notificationTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $notifications = $this->dispatchFromArray(ReadNotificationsCommand::class, ['user_id' => $user->id]);

            return $this->respond([
                'data' => $this->notificationTransformer->transformCollection($notifications)
            ]);

        } catch(UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($notificationId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteNotificationCommand::class, ['user_id' => $user->id]);

            return $this->respond([
                'data' => [],
                'message' => 'Notifications deleted.'
            ]);

        } catch(UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function clear()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteNotificationsCommand::class, ['user_id' => $user->id]);

            return $this->respond([
                'data' => [],
                'message' => 'Notifications deleted.'
            ]);

        } catch(UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function markAsConsumed()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(MarkNotificationsAsConsumedCommand::class, ['user_id' => $user->id]);

            return $this->respond([
                'data' => [],
                'message' => 'Notifications marked as consumed.'
            ]);

        } catch(UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
