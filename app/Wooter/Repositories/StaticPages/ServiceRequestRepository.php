<?php

namespace Wooter\Wooter\Repositories\StaticPages;

use Wooter\ServiceRequest;

class ServiceRequestRepository
{

    public function create(ServiceRequest $serviceRequest)
    {
        return $serviceRequest->save();
    }

    public function update(ServiceRequest $serviceRequest)
    {
        return $serviceRequest->save();
    }

    public function getById($serviceRequestId) {
        return ServiceRequest::whereId($serviceRequestId)->first();
    }

    public function getAll() {
        return ServiceRequest::get();
    }

}
