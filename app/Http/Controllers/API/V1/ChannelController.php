<?php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Channel\ChannelApiRequest;
use App\Services\ChannelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ChannelController
 * @package App\Http\Controllers\API\V1
 */
class ChannelController extends Controller
{

    /**
     * @var ChannelService
     */
    protected $channelService;

    /**
     * ChannelController constructor.
     * @param ChannelService $channelService
     */
    public function __construct(ChannelService $channelService)
    {
        $this->channelService = $channelService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->channelService->index($request);
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
    public function store(ChannelApiRequest $request)
    {
        return $this->channelService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->channelService->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
    public function update(ChannelApiRequest $request,$id)
    {
        return $this->channelService->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->channelService->delete($id);
    }

    /**
     * @return JsonResponse
     */
    public function  getChannelList(){
        return $this->channelService->getChannelListForDropDown();
    }
}
