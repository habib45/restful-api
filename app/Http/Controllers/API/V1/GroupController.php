<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupFormRequest;
use App\Http\Requests\TeamFromRequest;
use App\Models\Team;
use App\Services\GroupService;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



/**
 * Class GroupController
 * @package App\Http\Controllers\API\V1
 */
class GroupController extends Controller
{

    /**
     * @var GroupService
     */
    protected $groupService;


    /**
     * GroupController constructor.
     * @param GroupService $groupService
     */
    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return  $this->groupService->index($request);
    }



    /**
     * @param GroupFormRequest $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(GroupFormRequest $request)
    {
       return  $this->groupService->store($request);
    }




    /**
     * Display the specified Item.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->groupService->show($id);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update($id, Request $request)
    {
        return $this->groupService->update($id, $request);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this->groupService->destroy($id);
    }

    /**
     * @return JsonResponse
     */
    public function  getGroupList(){

        return $this->groupService->getGroupListForDropDown();

    }

}
