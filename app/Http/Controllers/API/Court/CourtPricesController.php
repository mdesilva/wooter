<?php

namespace Wooter\Http\Controllers\API\Court;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Court\CreateCourtPriceRequest;
use Wooter\Http\Requests\Court\UpdateCourtPriceRequest;
use Wooter\Commands\Court\ReadCourtPricesCommand;
use Wooter\Commands\Court\ReadCourtPriceCommand;
use Wooter\Commands\Court\CreateCourtPriceCommand;
use Wooter\Wooter\Transformers\Court\CourtPriceTransformer;

final class CourtPricesController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $courtPriceTransformer;
    
    public function __construct(CourtPriceTransformer $courtPriceTransformer) 
    {
        $this->courtPriceTransformer = $courtPriceTransformer;
    }
    
    public function store(CreateCourtPriceRequest $request)
    {
        try {
            $price = $this->dispatchFrom(CreateCourtPriceCommand::class, $request, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtPriceTransformer->transform($price)
            ]);
            
        } catch (Exception $ex) {

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($price_id)
    {
        try {
            $price = $this->dispatchFrom(ReadCourtPriceCommand::class, $request, ['userId' => 1, 'price_id' => $price_id]);

            return $this->respond([
                'data' => $this->courtPriceTransformer->transform($price)
            ]);
            
        } catch (Exception $ex) {

        }
    }

    /** eturn \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourtPriceRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}

