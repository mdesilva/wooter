<?php

namespace Wooter\Http\Controllers\API;

use Exception;
use Wooter\Commands\Organization\League\SearchLeaguesCommand;
use Wooter\Commands\Search\AutoCompleteSearchCommand;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Search\AutoCompleteSearchRequest;
use Wooter\Http\Requests\Search\FullSearchRequest;

class SearchController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param AutoCompleteSearchRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function autoCompleteSearch(AutoCompleteSearchRequest $request)
    {
        try {
            $results = $this->dispatchFrom(AutoCompleteSearchCommand::class, $request);

            return $this->respond([
                'data' => $results
            ]);

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param FullSearchRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function search(FullSearchRequest $request)
    {
        try {
            $results = $this->dispatchFrom(SearchLeaguesCommand::class, $request);

            return $this->respond([
                'data' => $results->getCollection()
            ]);

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

}
