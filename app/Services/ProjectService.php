<?php


namespace App\Services;

use App\Enums\HttpStatusCode;
use App\Http\Resources\ChannelResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\ProjectResource;
use App\Models\Channel;
use App\Repositories\GroupRepository;
use App\Repositories\ProjectRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Traits\CrudTrait;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ProjectService extends ApiBaseService
{

    use CrudTrait;

    /**
     * @var GroupRepository
     */
    protected $projectRepository;


    /**
     * GroupService constructor.
     * @param GroupRepository $groupRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }


    public function store($request)
    {
        try {
            $project =  $this->projectRepository->save($request->all());
            return $this->sendSuccessResponse($project, 'Channel Saved Successfully!');
        } catch (Exception $exception) {
            return $this->sendErrorResponse($exception->getMessage());
        }
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $projects = $this->projectRepository->all();
            $data = ProjectResource::collection($projects);
            return $this->sendSuccessResponse($data, 'Data fetched Successfully!');

        } catch (Exception $exception) {
            return $this->sendErrorResponse($exception->getMessage());
        }
    }


    
    public function update(Request $request, $id)
    {
        if (empty($id)) {
            return $this->sendErrorResponse('Please select what you want to edit', [], FResponse::HTTP_BAD_REQUEST);
        }
        try {
            $project = $this->projectRepository->getModel()->whereId($id)->update($request->all());
            return $this->sendSuccessResponse($project, 'Successfully updated', [], HttpStatusCode::SUCCESS);
        } catch (QueryException $ex) {
            return $this->sendErrorResponse($ex->getMessage(), [], HttpStatusCode::BAD_REQUEST);
        }
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        if (empty($id)) {
            return $this->sendErrorResponse('Please select what you want to delete', [], FResponse::HTTP_BAD_REQUEST);
        }

        try {
            $project = $this->projectRepository->findOrFail($id);
            if (!empty($project->id)) {
                $project->delete();
            }
            return $this->sendSuccessResponse($project, 'Successfully Deleted', [], HttpStatusCode::SUCCESS);
        } catch (QueryException $ex) {
            return $this->sendErrorResponse($ex->getMessage(), [], HttpStatusCode::BAD_REQUEST);
        }
    }

}
