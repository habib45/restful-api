<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ApiErrorCode extends Enum
{
    // Validation Constant
    const VALIDATOR_REQUIRED     = 'required';
    const VALIDATOR_REQUIRED_MSG = 'The :attribute is a mandatory field.';

    // Response Constant
    const RESPONSE_STATUS  = 'status';
    const RESPONSE_CODE    = 'code';
    const RESPONSE_MESSAGE = 'message';
    const RESPONSE_DATA    = 'data';
    const RESPONSE_500     = 'Internal Server Error !!!';
    const RESPONSE_503     = 'Service Unavailable !!!';
    const RESPONSE_400     = 'Request param validation error.';
    const RESPONSE_401     = 'Unauthorized !!!';
    const RESPONSE_402     = 'Malformed request !!!';
    const RESPONSE_403     = 'Forbidden request !!!';
    const RESPONSE_404     = 'Not found !!!';
    const GUZZLE_ERROR     = 'Guzzle http error !!!';
}
