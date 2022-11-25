<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ExternalApi\ExternalApiRequest;
use App\Services\ExternalApiService;
use Illuminate\Http\Request;

class ExternalApiController extends Controller
{
    protected $externalApiService;


    public function __construct(ExternalApiService $externalApiService)
    {
        $this->externalApiService = $externalApiService;

    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->externalApiService->index($request);
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
    public function store(ExternalApiRequest $request)
    {
        return $this->externalApiService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->externalApiService->show($id);
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
    public function update(ExternalApiRequest $request, $id)
    {
        return $this->externalApiService->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->externalApiService->delete($id);
    }

    public function getList($dropdown = true)
    {
        if($dropdown)
        {
            return $this->externalApiService->getList();
        }
        return $this->externalApiService->getList(false);
    }
}
