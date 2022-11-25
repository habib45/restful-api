<?php
namespace App\Services;

use App\Enums\HttpStatusCode;
use App\Helpers\UtilityHelper;
use App\Http\Requests\API\Track\TrackApiRequest;
use App\Http\Resources\TrackResource;
use App\Models\Channel;
use App\Models\Track;
use App\Repositories\TrackRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Traits\CrudTrait;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * Class TrackService
 * @package App\Services
 */
class TrackService extends ApiBaseService
{

    use CrudTrait;


    /**
     * @var TrackRepository
     */
    protected $trackRepository;


    /**
     * GroupService constructor.
     * @param TrackRepository $trackRepository
     */
    public function __construct(TrackRepository $trackRepository)
    {
        $this->trackRepository = $trackRepository;
    }


    /**
     * @param TrackApiRequest $request
     * @return JsonResponse
     */
    public function store(TrackApiRequest $request)
    {
        try {
            $track =  $this->trackRepository->save($request->all());
            return $this->sendSuccessResponse($track, 'Track Saved Successfully!');
        } catch (Exception $exception) {
            return $this->sendErrorResponse($exception->getMessage());
        }
    }

    /**
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $tracks = $this->trackRepository->getTracksForIndex($request);
            $data['data'] = TrackResource::collection($tracks);
            $data['pagination'] = $this->paginationResponse($tracks);
            return $this->sendSuccessResponse($data, 'Data fetched Successfully!');
        } catch (Exception $exception) {
            return $this->sendErrorResponse($exception->getMessage());
        }
    }

     /**
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $track = $this->trackRepository->findOne($id);
            return $this->sendSuccessResponse($track, 'Data fetched Successfully!');

        } catch (Exception $exception) {
            return $this->sendErrorResponse($exception->getMessage());
        }
    }


    /**
     * @param TrackApiRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(TrackApiRequest $request, $id)
    {
        if (empty($id)) {
            return $this->sendErrorResponse('Please select what you want to edit', [], FResponse::HTTP_BAD_REQUEST);
        }
        try {
            $track = $this->trackRepository->findOne($id);
            $track = tap($track)->update($request->all());
            return $this->sendSuccessResponse($track, 'Successfully updated', [], HttpStatusCode::SUCCESS);
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
            $track = $this->trackRepository->findOrFail($id);
            if (!empty($track->id)) {
                $track->delete();
            }
            return $this->sendSuccessResponse($track, 'Successfully Deleted', [], HttpStatusCode::SUCCESS);
        } catch (QueryException $ex) {
            return $this->sendErrorResponse($ex->getMessage(), [], HttpStatusCode::BAD_REQUEST);
        }
    }


    /**
     * @param bool $dropdown
     * @return JsonResponse
     */
    public function getList($dropdown = true)
    {
        try {
            if($dropdown) {
                $data = UtilityHelper::getDropDown($this->trackRepository->getTableName(),'id','name');
            } else{
                $data = $this->trackRepository->all();
            }
            return $this->sendSuccessResponse($data, 'Successfully Fetched', [], HttpStatusCode::SUCCESS);
        } catch (QueryException $ex) {
            return $this->sendErrorResponse($ex->getMessage(), [], HttpStatusCode::BAD_REQUEST);
        }

    }
}
