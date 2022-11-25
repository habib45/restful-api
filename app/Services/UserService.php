<?php


namespace App\Services;


use App\Enums\HttpStatusCode;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\ProfileLog;
use App\Models\VerifyUser;
use App\Models\GroupsUser;
use App\Mail\VerifyMail as VerifyEmail;
use App\Repositories\RepresentativeInformationRepository;
use App\Services\GroupService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Repositories\UserRepository;
use App\Repositories\EmailVerificationRepository as EmailVerifyRepository;
use App\Transformers\CandidateTransformer;
use App\Repositories\CandidateRepository;
use App\Repositories\ProfileLogRepository;
use DB;
use Symfony\Component\HttpFoundation\Response as FResponse;
use UtilityHelper;

class UserService extends ApiBaseService
{

    use CrudTrait;

    /**
     * @var UserRepository
     */
    protected $userRepository;


    /**
     * UserService constructor.
     *
     * @param UserRepository $UserRepository
     * @param EmailVerifyRepository $emailVerifyRepository
     */
    public function __construct( UserRepository $UserRepository)
    {
        $this->userRepository = $UserRepository;
    }
    /**
     * @return JsonResponse
     */
    public function getUserList($request)
    {
        try {
            $query = User::query()->orderBy('id', 'DESC');
            if ($request->filled('search')) {
                $query->where('name', 'LIKE', "%{$request->search}%");
                $query->orWhere('email', 'LIKE', "%{$request->search}%");
            }
            $users = $query->paginate($request->get('per_page'));
            $data['data'] = UserResource::collection($users);
            $data['pagination'] = $this->paginationResponse($users);
            return $this->sendSuccessResponse($data, 'Data fetched Successfully!');
        } catch (Exception $exception) {
            return $this->sendErrorResponse($exception->getMessage());
        }
    }

    /**
     * this function use for user registration
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register($request)
    {
        try {
            $data = array();
            $inputData = $request->all();
            $inputData['password'] = Hash::make($request->get('password'));
            // email emailVerify bypass
            $inputData['is_verified'] = 1;
            $user = $this->userRepository->save($inputData);
            if ($user) {
                VerifyUser::create([
                    'user_id' => $user->id,
                    'token' => sha1(time()) . $user->id,
                ]);
                Mail::to($user->email)->send(new VerifyEmail($user, HttpStatusCode::WEB_DOMAIN));
                //                event(new Registered($user));
                self::authenticate($request);
                $expireTime = auth('api')->factory()->getTTL() * 60;
                $dateTime = Carbon::now()->addSeconds($expireTime);
                $token = JWTAuth::fromUser($user);
                $data['token'] = self::TokenFormater($token);
                $data['user'] = $user;
                return $this->sendSuccessResponse($data, 'User registration successfully completed', [], FResponse::HTTP_CREATED);
            } else {
                return $this->sendErrorResponse('Something went wrong. try again later', [], FResponse::HTTP_BAD_REQUEST);
            }
        } catch (Exception $exception) {
            return $this->sendErrorResponse($exception->getMessage());
        }
    }

    /**
     * This function use for user login by email and password
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $data = array();
        try {

            $userInfo = User::where('email', $request->input('email'))->first();
            if (empty($userInfo)) {
                return $this->sendErrorResponse(
                    'You are not a registered you should registration first ',
                    [],
                    HttpStatusCode::BAD_REQUEST
                );
            }
            if (!$userInfo || !Hash::check($request->password, $userInfo->password)) {
                return $this->sendErrorResponse(
                    'These credentials do not match our records.',
                    [],
                    HttpStatusCode::BAD_REQUEST
                );
            }
            if ($userInfo->status == 2) {
                //  status == 2 delete account
                return $this->sendErrorResponse(
                    'This account has been deleted ( ' . $userInfo->email . ' )',
                    [],
                    HttpStatusCode::BAD_REQUEST
                );
            }
            $token = $userInfo->createToken('my-app-token')->plainTextToken;
            $data['token'] = $token;
            $data['user'] = $userInfo;
            return $this->sendSuccessResponse($data, 'Login successfully');
        } catch (Exception $exception) {
            return $this->sendErrorResponse($exception->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $token
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout($token, $request)
    {
        if (empty($token)) {
            return $this->sendErrorResponse('Authorization token is empty', [], HttpStatusCode::VALIDATION_ERROR);
        }
        try {
            $request->user()->currentAccessToken()->delete();;
            return $this->sendSuccessResponse([], 'User has been logged out');
        } catch (Exception $exception) {
            return $this->sendErrorResponse('Sorry, user cannot be logged out', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserDetail($id)
    {

        try {
            $user = $this->userRepository->findOne($id, ['groups']);
            $groups = UtilityHelper::getDropDown('groups', "id", "name");
            $grouplist=[];
            $userGroup=array_column(json_decode($user['groups'],true), 'id');
            foreach ($groups as $key => $info) {
                $id = $info->id;
                $name = $info->name;
                if (in_array($id, $userGroup)) {
                    $check = true;
                } else {
                    $check = false;
                }
                $grouplist[] = ['id' => $id, 'name' => $name, 'checked' => $check];
            }
            $user['grouplist'] = $grouplist;
            if (empty($user)) {
                return $this->sendError('User not found');
            }
            return $this->sendResponse($user->toArray(), 'User retrieved successfully');
        } catch (Exception $exception) {
            return $this->sendErrorResponse('Sorry, something went wrong', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createUser($request)
    {
        $input = $request->all();
        try {

            $input['password'] = Hash::make(trim($input['password']));
            $user = $this->userRepository->save($input);
            if(!empty($input['groups']) AND !empty($user->id)){
                self::groupAssign($user->id,$input['groups']);
            }
            return $this->sendResponse($user->toArray(), 'User saved successfully');

        } catch (Exception $exception) {
            return $this->sendErrorResponse('Sorry, something went wrong', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $userId
     * @param $groupArray
     */
    public function groupAssign($userId,$groupArray){

        if(!empty($userId) and !empty($groupArray)) {
            GroupsUser::where(['user_id'=>$userId])->delete();
            $groupAssign = [];
            foreach ($groupArray as $value) {
                $groupAssign[] = ['user_id' => $userId, 'group_id' => $value, 'created_at' => now(), 'updated_at' => now()];
            }
            GroupsUser::insert($groupAssign);
        }

    }

    /**
     * @param $id
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, $request)
    {
        try {
            $user = $this->userRepository->find($id);
            $groups = [];
            $input = $request->all();
            if(!empty($input['password'])){
                $input['password']=Hash::make(trim($input['password']));
            }else{
                unset($input['password']);
            }
            if (empty($user)) {
                return $this->sendError('User not found');
            }

            if (!empty($input['password'])) {
                $input['password'] = Hash::make(trim($input['password']));
            }
            if (!empty($input['groups']) AND !empty($user->id)) {
                $groups = $input['groups'];
                unset($input['groups']);
            }
            $input['updated_at'] = now();
            unset($input['created_at'], $input['get_user_groups']);
            $user->update($input);
            $user = $this->userRepository->getModel()->find($id);
            if (!empty($groups)) {
              return  self::groupAssign($user->id, $groups);
            }

            return $this->sendResponse($user, 'User updated successfully');
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->sendErrorResponse($ex->getMessage());
        } catch (Exception $exception) {
            return $this->sendErrorResponse($exception->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function groupDataFormatForSelectBox($groupsUser)
    {

        $result = [];
        if (!empty($groupsUser)) {
            foreach ($groupsUser as $value) {
                $result[] = ['id' => $value->group_id, 'user' => $value->user_id];
            }
        }
        return $result;

    }
}
