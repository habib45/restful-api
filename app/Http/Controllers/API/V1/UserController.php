<?php

namespace App\Http\Controllers\API\V1;


use App\Http\Requests\API\Users\CreateUserAPIRequest;
use App\Http\Requests\API\Users\UpdateUserAPIRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Http\Requests\UserRegistrationRequest;
use Mail;
use Illuminate\Http\Response;



class UserController extends Controller
{
    /**
     * @var  UserRepository
     */
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepo
     */
    public function __construct(UserService $userService,UserRepository $userRepo)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepo;
    }

    /**
     * @param Request $request
     * @return \App\Services\JsonResponse
     */
    public function index(Request $request)
    {
        return  $this->userService->getUserList($request);
    }

    /**
     * @param CreateUserAPIRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserAPIRequest $request)
    {
        return $this->userService->createUser($request);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->userService->getUserDetail($id);


    }

    /**
     * @param $id
     * @param UpdateUserAPIRequest $request
     * @return \App\Http\Controllers\JsonResponse
     */
    public function update($id, UpdateUserAPIRequest $request)
    {
        return $this->userService->update($id,$request);

    }

    /**
     * @param $id
     * @return \App\Http\Controllers\JsonResponse
     */
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);
        if (empty($user)) {
            return $this->sendError('User not found');
        }
        $user->delete();

        return $this->sendSuccessResponse([],'User deleted successfully');
    }


    public function profile(Request $request)
    {
        return $request->user();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getUser(Request $request)
    {
        return $request->user()->id;
    }
}
