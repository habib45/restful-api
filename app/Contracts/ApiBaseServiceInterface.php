<?php
namespace App\Contracts;

interface ApiBaseServiceInterface
{
    /**
     * Send Success Response
     *
     * @param $result
     * @param $message
     * @param $pagination
     * @param $http_status
     * @param $status_code
     * @return mixed
     */
    public function sendSuccessResponse($result, $message, $pagination, $http_status, $status_code);


    /**
     * Send Error Response
     *
     * @param $message
     * @param $errorMessages
     * @param $status_code
     * @return mixed
     */
    public function sendErrorResponse($message, $errorMessages, $status_code);
}