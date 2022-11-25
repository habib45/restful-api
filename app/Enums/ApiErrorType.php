<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ApiErrorType extends Enum
{
     const VALIDATION_FAILED_ERROR   = 'validation_error';
     const TOKEN_NOT_FOUND_ERROR     = 'unauthenticated';
     const TOKEN_INVALID_ERROR       = 'unauthenticated';
     const NOT_FOUND_ERROR           = 'not_found';
     const METHOD_NOT_ALLOWED_ERROR  = 'method_not_allowed';
     const INTERNAL_SERVICE_ERROR    = 'internal_error';
     const CURL_EXCEPTION_ERROR      = 'curl_request_error';
}
