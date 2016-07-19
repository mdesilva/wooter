<?php

namespace Wooter\Http\Controllers\Organization;

use Exception;
use Illuminate\Http\Request;

use Wooter\Commands\Organization\CreateOrganizationAddressCommand;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Requests\Organization\CreateOrganizationAddressRequest;
use Illuminate\Support\Facades\Auth;
use Wooter\Wooter\Exceptions\Organization\OrganizationNotFound;

class OrganizationAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param CreateOrganizationAddressRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrganizationAddressRequest $request)
    {
        try
        {
            $this->content = $this->dispatchFrom(CreateOrganizationAddressCommand::class, $request, ['user_id' => Auth::User()->id]);
        } catch (OrganizationNotFound $e) {
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
    public function destroy($id)
    {
        //
    }
}
