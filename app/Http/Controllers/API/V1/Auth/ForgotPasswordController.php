<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Enums\HttpStatusCode;
use App\Services\ApiBaseService;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepository;
use App\Models\PasswordReset;
use Str;
use App\Mail\ForgetPasswordMail;
use Mail;
use Illuminate\Support\Facades\Hash;
use Swift_TransportException;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * @var \App\Services\ApiBaseService
     */
    protected $apiBaseService;

    /**
     * @var \App\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(ApiBaseService $apiBaseService, UserRepository $userRepository)
    {
        $this->middleware('guest');
        $this->apiBaseService = $apiBaseService;
        $this->userRepository = $userRepository;
    }

    /**
     * This method use for password reset mail send and token generation
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'email' => "required|email",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return $this->apiBaseService->sendErrorResponse('validation error', $validator->errors()->first(), HttpStatusCode::BAD_REQUEST);
        } else {
            try {
                $user = $this->userRepository->findOneByProperties(['email' => $input['email']]);
                if ($user) {
                    $token = Str::random(60);
                    $passwordUpdate = new PasswordReset();
                    $passwordUpdate->email = $input['email'];
                    $passwordUpdate->token = $token;
                    $passwordUpdate->save();
                    Mail::to($user->email)->send(new ForgetPasswordMail($user, $token, HttpStatusCode::WEB_DOMAIN));
                    return $this->apiBaseService->sendSuccessResponse([], 'Reset link sent to your email');
                } else {
                    return $this->apiBaseService->sendErrorResponse('Invalid Email', ['detail' => 'User Not found'],
                        HttpStatusCode::BAD_REQUEST
                    );
                }

            } catch (Exception $exception) {
                return $this->sendErrorResponse($exception->getMessage(), [], $exception->getStatusCode());
            } catch (Swift_TransportException $exception) {
                return $this->sendErrorResponse($exception->getMessage(), [], $exception->getStatusCode());
            }

        }


    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function forgetPasswordTokenVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendErrorResponse('validation error', $validator->errors(), HttpStatusCode::VALIDATION_ERROR);
        }

        $input = $request->all();
        $verified = PasswordReset::where('token', $input['token'])->first();
        if ($verified) {
            $data = [
                'token' => $input['token'],
                'email' => $verified->email,
                'validation' => true
            ];
            return $this->apiBaseService->sendSuccessResponse($data, 'This token is valid token');
        } else {
            return $this->apiBaseService->sendErrorResponse('Token not found', [], HttpStatusCode::NOT_FOUND);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request)
    {
        $input = $request->all();
        try {
            $user = $this->userRepository->findOneBy(['email' => $input['email']]);
            if ($user) {
                $user->password = Hash::make($input['password']);
                $user->save();
                PasswordReset::where('token', $input['token'])->delete();

                return $this->apiBaseService->sendSuccessResponse($user, 'Password updated successfully');

            } else {
                return $this->apiBaseService->sendErrorResponse('Invalid Token', ['detail' => 'User Not found'],
                    HttpStatusCode::BAD_REQUEST
                );
            }

        } catch (Exception $exception) {
            return $this->apiBaseService->sendErrorResponse($exception->getMessage(), [], $exception->getStatusCode());
        }
    }


}

