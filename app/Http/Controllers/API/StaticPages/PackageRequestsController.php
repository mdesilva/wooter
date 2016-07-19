<?php

namespace Wooter\Http\Controllers\API\StaticPages;

use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\StaticPages\CreatePackageRequestCommand;
use Wooter\Commands\StaticPages\DeletePackageRequestCommand;
use Wooter\Commands\StaticPages\ReadPackageRequestCommand;
use Wooter\Commands\StaticPages\ReadPackageRequestsCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\StaticPages\CreatePackageRequestRequest;
use Wooter\Wooter\Exceptions\StaticPages\PackageRequestNotFound;
use Wooter\Wooter\Exceptions\User\UserIsNotAdmin;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Transformers\StaticPages\PackageRequestTransformer;

final class PackageRequestsController extends ApiController
{
    /**
     * @var PackageRequestTransformer
     */
    private $packageRequestTransformer;

    /**
     * @param PackageRequestTransformer $packageRequestTransformer
     */
    public function __construct(PackageRequestTransformer $packageRequestTransformer)
    {
        $this->packageRequestTransformer = $packageRequestTransformer;

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

            $packageRequest = $this->dispatchFromArray(ReadPackageRequestsCommand::class, ['user_id' => $user->id]);

            return $this->respond([
                'data' => $this->packageRequestTransformer->transformCollection($packageRequest)
            ]);

        } catch (PackageRequestNotFound $e) {
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
     * @param CreatePackageRequestRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePackageRequestRequest $request)
    {
        try {
            $packageRequest = $this->dispatchFrom(CreatePackageRequestCommand::class, $request);

            return $this->respond([
                'data' => $this->packageRequestTransformer->transform($packageRequest)
            ]);

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $packageRequestId
     *
     * @return \Illuminate\Http\Response
     */
    public function show($packageRequestId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $serviceRequest = $this->dispatchFromArray(ReadPackageRequestCommand::class, ['package_request_id' => $packageRequestId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->packageRequestTransformer->transform($serviceRequest)
            ]);

        } catch (PackageRequestNotFound $e) {
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
     * @param $packageRequestId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($packageRequestId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeletePackageRequestCommand::class,['package_request_id' => $packageRequestId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => 'Deleted successfully'
            ]);

        } catch (PackageRequestNotFound $e) {
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
