<?php

namespace Wooter\Wooter\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use Wooter\Wooter\Contracts\HTTPStatusCode;

trait Responder {

    protected $statusCode = HTTPStatusCode::OK;

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param       $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }


    /**
     * @param     $name
     * @param     $message
     *
     * @param int $minutes
     *
     * @return JsonResponse
     */
    public function respondWithAlert($name, $message, $minutes = 1)
    {
        $data = [
            'name' => $name,
            'message' => $message
        ];
        
        Cookie::queue(Cookie::make('actionAlert', json_encode($data), $minutes));
    }

    /**
     * @param LengthAwarePaginator $collection
     * @param                      $data
     *
     * @return JsonResponse
     */
    public function respondWithPagination(LengthAwarePaginator $collection, $data)
    {
        $data = array_merge($data, [
            'paginator' => [
                'total_count'   => $collection->total(),
                'total_pages'   => ceil($collection->total() / $collection->perPage()),
                'current_page'  => $collection->currentPage(),
                'limit'         => $collection->perPage(),
            ]
        ]);
        return $this->respond($data);
    }

    /**
     * @param $message
     *
     * @return JsonResponse
     */
    private function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(HTTPStatusCode::NOT_FOUND)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondNotAuthorized($message = 'Not Authorized!')
    {
        return $this->setStatusCode(HTTPStatusCode::UNAUTHORIZED)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondNotAcceptable($message = 'Not Acceptable!')
    {
        return $this->setStatusCode(HTTPStatusCode::NOT_ACCEPTABLE)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondForbidden($message = 'Access not allowed!')
    {
        return $this->setStatusCode(HTTPStatusCode::FORBIDDEN)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(HTTPStatusCode::INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

}
