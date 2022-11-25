<?php
namespace App\Services;

use App\Enums\HttpStatusCode;
use App\Helpers\UtilityHelper;
use App\Http\Requests\API\ExternalApi\ExternalApiRequest;
use App\Http\Resources\ExternalApiResource;
use App\Models\ExternalApi;
use App\Repositories\ExternalApiRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Traits\CrudTrait;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * Class ExternalApiService
 * @package App\Services
 */
class ExternalApiService extends ApiBaseService
{

    use CrudTrait;


    /**
     * @var ExternalApiRepository
     */
    protected $externalApiRepository;


    /**
     * GroupService constructor.
     * @param ExternalApiRepository $externalApiRepository
     */
    public function __construct(ExternalApiRepository $externalApiRepository)
    {
        $this->externalApiRepository = $externalApiRepository;
    }


    /**
     * @param ExternalApiRequest $request
     * @return JsonResponse
     */
    public function store(ExternalApiRequest $request)
    {
        try {
            $externalApi =  $this->externalApiRepository->save($request->all());
            return $this->sendSuccessResponse($externalApi, 'External Api Saved Successfully!');
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
            $externalApi = $this->externalApiRepository->getExternalApisForIndex($request);
            $data['data'] = ExternalApiResource::collection($externalApi);
            $data['pagination'] = $this->paginationResponse($externalApi);
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
            $externalApi = $this->externalApiRepository->findOne($id);
            return $this->sendSuccessResponse($externalApi, 'Data fetched Successfully!');

        } catch (Exception $exception) {
            return $this->sendErrorResponse($exception->getMessage());
        }
    }


    /**
     * @param ExternalApiRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(ExternalApiRequest $request, $id)
    {
        if (empty($id)) {
            return $this->sendErrorResponse('Please select what you want to edit', [], FResponse::HTTP_BAD_REQUEST);
        }
        try {
            $externalApi = $this->externalApiRepository->findOne($id);
            $externalApi = tap($externalApi)->update($request->all());
            return $this->sendSuccessResponse($externalApi, 'Successfully updated', [], HttpStatusCode::SUCCESS);
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
            $externalApi = $this->externalApiRepository->findOrFail($id);
            if (!empty($externalApi->id)) {
                $externalApi->delete();
            }
            return $this->sendSuccessResponse($externalApi, 'Successfully Deleted', [], HttpStatusCode::SUCCESS);
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
                $data = UtilityHelper::getDropDown($this->externalApiRepository->getTableName(),'id','name');
            } else{
                $data = $this->externalApiRepository->all();
            }
            return $this->sendSuccessResponse($data, 'Successfully Fetched', [], HttpStatusCode::SUCCESS);
        } catch (QueryException $ex) {
            return $this->sendErrorResponse($ex->getMessage(), [], HttpStatusCode::BAD_REQUEST);
        }

    }
}
