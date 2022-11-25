<?php


namespace App\Services;

use App\Enums\HttpStatusCode;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Repositories\GroupRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use UtilityHelper;

class GroupService extends ApiBaseService
{

    use CrudTrait;

    /**
     * @var GroupRepository
     */
    protected $groupRepository;


    /**
     * GroupService constructor.
     * @param GroupRepository $groupRepository
     */
    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }


    /**
     * @param $request
     * @return JsonResponse
     */
    public function index($request)
    {
        try {

            $query = Group::query();
            $query->with('channels');
            if ($request->filled('search')) {
                $query->where('name', 'LIKE', "%{$request->search}%");
            }
            $groups = $query->paginate($request->get('per_page'));

            //$groups = $this->groupRepository->getItemsForIndex($request);

            $data['data'] = GroupResource::collection($groups);
            $data['pagination'] = $this->paginationResponse($groups);

            return $this->sendSuccessResponse($data, 'Data fetched Successfully!');

        } catch (Exception $exception) {
            return $this->sendErrorResponse($exception->getMessage());
        }
    }


    /**
     * @param $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($request)
    {
        return $this->groupRepository->save($request->all());
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $group = $this->groupRepository->findOrFail($id);
            $data = New GroupResource($group);
            return $this->sendSuccessResponse($data, 'Data fetched Successfully!');

        } catch (Exception $exception) {
            return $this->sendErrorResponse($exception->getMessage());
        }
    }


    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        if (empty($id)) {
            return $this->sendErrorResponse('Please select what you want to edit', [], HttpStatusCode::BAD_REQUEST);
        }
        try {
            $group = $this->groupRepository->find($id);
            if (!empty($group->id)) {
                $group->update($request->all());
            }

            return $this->sendSuccessResponse($group, 'Successfully updated', [], HttpStatusCode::SUCCESS);
        } catch (QueryException $ex) {
            return $this->sendErrorResponse($ex->getMessage(), [], HttpStatusCode::BAD_REQUEST);
        }
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if (empty($id)) {
            return $this->sendErrorResponse('Please select the group', [], HttpStatusCode::BAD_REQUEST);
        }

        try {
            $group = $this->groupRepository->find($id);

            if (!$group) {
                return $this->sendErrorResponse('Group not found', [], HttpStatusCode::NOT_FOUND);
            }

            if (!empty($group->id)) {
                $group->delete();
            }

            return $this->sendSuccessResponse($group, 'Successfully deleted', [], HttpStatusCode::SUCCESS);
        } catch (QueryException $ex) { dd($ex);
            return $this->sendErrorResponse($ex->getMessage(), [], HttpStatusCode::BAD_REQUEST);
        }
    }

    /**
     * @return JsonResponse
     */
    public function getGroupListForDropDown()
    {
        $list = UtilityHelper::getDropDown('groups', "id","name");
        return $this->sendSuccessResponse($list, 'Data fetched Successfully!', [], HttpStatusCode::SUCCESS);
    }

}
