<?php

namespace App\Http\Controllers\API\V1\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Mail;

class LoginController  extends Controller
{

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * PurchaseController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService,UserRepository $userRepo)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepo;
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(LoginRequest $request)
    {

        return $this->userService->authenticate($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function switchAccount(Request $request)
    {

        return $this->userService->switchAccount($request);

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        return $this->userService->logout($token,$request);
    }
}
