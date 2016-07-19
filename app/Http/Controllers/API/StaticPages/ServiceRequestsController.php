<?php

namespace Wooter\Http\Controllers\API\StaticPages;

use Exception;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\StaticPages\CreateServiceRequestCommand;
use Wooter\Commands\StaticPages\DeleteServiceRequestCommand;
use Wooter\Commands\StaticPages\ReadServiceRequestCommand;
use Wooter\Commands\StaticPages\ReadServiceRequestsCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\StaticPages\CreateServiceRequestRequest;
use Wooter\Wooter\Exceptions\StaticPages\ServiceRequestNotFound;
use Wooter\Wooter\Exceptions\User\UserIsNotAdmin;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Transformers\StaticPages\ServiceRequestTransformer;

final class ServiceRequestsController extends ApiController
{
    /**
     * @var ServiceRequestTransformer
     */
    private $serviceRequestTransformer;

    /**
     * @param ServiceRequestTransformer $serviceRequestTransformer
     */
    public function __construct(ServiceRequestTransformer $serviceRequestTransformer)
    {
        $this->serviceRequestTransformer = $serviceRequestTransformer;

        $this->middleware('jwt.auth', ['except' => [
            'store'
        ]]);

        $this->middleware('user.is_admin', ['except' => [
            'store',
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $serviceRequest = $this->dispatchFromArray(ReadServiceRequestsCommand::class, ['user_id' => $user->id]);

            return $this->respond([
                'data' => $this->serviceRequestTransformer->transformCollection($serviceRequest)
            ]);

        } catch (ServiceRequestNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserIsNotAdmin $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateServiceRequestRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateServiceRequestRequest $request)
    {
        try {
            $serviceRequest = $this->dispatchFrom(CreateServiceRequestCommand::class, $request);
            // print_r($serviceRequest);
            return $this->respond([
                'data' => $this->serviceRequestTransformer->transform($serviceRequest)
            ]);

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $serviceRequestId
     *
     * @return \Illuminate\Http\Response
     */
    public function show($serviceRequestId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $serviceRequest = $this->dispatchFromArray(ReadServiceRequestCommand::class, ['service_request_id' => $serviceRequestId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->serviceRequestTransformer->transform($serviceRequest)
            ]);

        } catch (ServiceRequestNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserIsNotAdmin $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $serviceRequestId
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy($serviceRequestId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteServiceRequestCommand::class,['service_request_id' => $serviceRequestId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => 'Deleted successfully'
            ]);

        } catch (ServiceRequestNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserIsNotAdmin $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
