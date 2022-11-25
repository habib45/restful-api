<?php

namespace App\Services;

use App\Enums\ApiCustomStatusCode;
use App\Enums\HttpStatusCode;
use Illuminate\Http\JsonResponse;
use App\Contracts\ApiBaseServiceInterface;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response as FResponse;

/**
 * Class ApiBaseService
 * @package App\Services
 */
class ApiBaseService implements ApiBaseServiceInterface
{
    /**
     * @param $result
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    public function sendResponse($result, $message,$code=FResponse::HTTP_OK)
    {
        return $this->sendSuccessResponse($result, $message, [], $code);
    }

    /**
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    public function sendError($message, $code = FResponse::HTTP_BAD_REQUEST)
    {
        return $this->sendErrorResponse($message, $errorMessages = [], $code);
    }

    /**
     * @param $data
     * @param $message
     * @param $code
     * @return JsonResponse
     */
    public function sendSuccess($data,$message,$code)
    {
        return $this->sendSuccessResponse($data,$message,$code);
    }

    /**
     * Success response method.
     *
     * @param array $result
     * @param $message
     * @param array $pagination
     * @param int $http_status
     * @param int $status_code
     * @return JsonResponse
     */
    public function sendSuccessResponse(
        $result,
        $message,
        $pagination = [],
        $http_status = HttpStatusCode::SUCCESS,
        $status_code = ApiCustomStatusCode::SUCCESS
    ) {
        $response = [
            'status' => 'SUCCESS',
            'status_code' => $status_code,
            'message' => $message,
            'data' => $result
        ];

        if (!empty($pagination)) {
            $response ['pagination'] = $pagination;
        }

        return response()->json($response, $http_status);
    }


    /**
     * Return error response.
     *
     * @param $message
     * @param array $errorMessages
     * @param int $status_code
     * @return JsonResponse
     */
    public function sendErrorResponse($message, $errorMessages = [], $status_code = HttpStatusCode::VALIDATION_ERROR)
    {
        $response = [
            'status' => 'FAIL',
            'status_code' => $status_code,
            'message' => $message,
        ];

        if (!empty($errorMessages)) {
            $response['error'] = $errorMessages;
        }

        return response()->json($response, $status_code);
    }


    /**
     * Return Response with pagination
     *
     * @param $items
     * @return array
     */
    public function paginationResponse($items)
    {
        return array(
            "current_page"=>$items->currentPage(),
            "last_page"=> $items->lastPage(),
            "per_page"=> $items->perPage(),
            "total"=> $items->total(),
            "count"=> $items->count(),
            'has_more_pages' => $items->hasMorePages()
        );
    }

}
