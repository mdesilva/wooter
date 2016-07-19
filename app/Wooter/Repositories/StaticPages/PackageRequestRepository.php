<?php

namespace Wooter\Wooter\Repositories\StaticPages;

use Wooter\PackageRequest;

class PackageRequestRepository
{

    public function create(PackageRequest $packageRequest)
    {
        return $packageRequest->save();
    }

    public function update(PackageRequest $packageRequest)
    {
        return $packageRequest->save();
    }

    public function getById($packageRequestId) {
        return PackageRequest::whereId($packageRequestId)->first();
    }

    public function getAll() {
        return PackageRequest::get();
    }

}
