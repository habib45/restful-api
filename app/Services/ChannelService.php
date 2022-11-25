<?php
namespace App\Services;

use App\Enums\HttpStatusCode;
use App\Helpers\UtilityHelper;
use App\Http\Requests\API\Channel\ChannelApiRequest;
use App\Http\Resources\ChannelResource;
use App\Models\Channel;
use App\Repositories\ChannelRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Traits\CrudTrait;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;

/**
 * Class ChannelService
 * @package App\Services
 */
class ChannelService extends ApiBaseService
{

    use CrudTrait;


    /**
     * @var ChannelRepository
     */
    protected $channelRepository;


    /**
     * ChannelService constructor.
     * @param ChannelRepository $channelRepository
     */
    public function __construct(ChannelRepository $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }


    /**
     * @param $request
     * @return JsonResponse
     */
    public function store($request)
    {
        try {
            $channel =  $this->channelRepository->save($request->all());
            return $this->sendSuccessResponse($channel, 'Channel Saved Successfully!');
        } catch (Exception $exception) {
            return $this->sendErrorResponse($exception->getMessage());
        }
    }

    /**
     * @return JsonResponse
     */
    public function index($request)
    {
        try {
            $channels = $this->channelRepository->getChannelsForIndex($request);
            $data['data'] = ChannelResource::collection($channels);
            $data['pagination'] = $this->paginationResponse($channels);
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
    public function update(ChannelApiRequest $request, $id)
    {
        if (empty($id)) {
            return $this->sendErrorResponse('Please select what you want to edit', [], FResponse::HTTP_BAD_REQUEST);
        }
        try {
            $channel = $this->channelRepository->findOne($id);
            $channel = tap($channel)->update($request->all());
            return $this->sendSuccessResponse($channel, 'Successfully updated', [], HttpStatusCode::SUCCESS);
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
            $channel = $this->channelRepository->findOrFail($id);
            if (!empty($channel->id)) {
                $channel->delete();
            }
            return $this->sendSuccessResponse($channel, 'Successfully Deleted', [], HttpStatusCode::SUCCESS);
        } catch (QueryException $ex) {
            return $this->sendErrorResponse($ex->getMessage(), [], HttpStatusCode::BAD_REQUEST);
        }
    }

    /**
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $channel = $this->channelRepository->findOne($id);
            return $this->sendSuccessResponse($channel, 'Data fetched Successfully!');

        } catch (Exception $exception) {
            return $this->sendErrorResponse($exception->getMessage(),[], HttpStatusCode::BAD_REQUEST);
        }
    }


    /**
     * @return JsonResponse
     */
    public function getChannelListForDropDown()
    {
        $list = UtilityHelper::getDropDown('channels', "id","name");
        return $this->sendSuccessResponse($list, 'Data fetched Successfully!', [], HttpStatusCode::SUCCESS);
    }

}
