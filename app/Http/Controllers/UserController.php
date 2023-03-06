<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserRequest;
use App\Http\Requests\FollowRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UploadFileRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->userService->saveUser($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'register success',
            'data' => new UserResource($user)
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (!$token = auth()->guard('api')->attempt($request->validated())) {
            return response()->json([
                'status' => 'failed',
                'message' => "Email or Password is incorrect"
            ], 401);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'login success',
            'data' => [
                'user' => new UserResource($this->userService->getUserDetail(auth()->guard('api')->user()->id)),
                'token' => $token,
            ]
        ], 200);
    }

    public function logout()
    {
        $removeToken = JWTAuth::parseToken()->invalidate();

        if ($removeToken) {
            return response()->json([
                'statuse' => 'success',
                'message' => 'Logout Success!',
            ]);
        }
    }

    public function getAllUser(Request $request)
    {
        return new UserCollection($this->userService->getAllUser($request), 'success', "List User Data");
    }

    public function getUserDetail($user_id)
    {
        return $this->userResponse($this->userService->getUserDetail($user_id), 'success', 'data found!');
    }

    public function getUserContent($user_id)
    {
        return response()->json([
            'statuse' => 'success',
            'message' => 'data found!',
            'data' => $this->userService->getUserContent($user_id)
        ]);
    }

    public function getUserFollowers($user_id)
    {
        return new UserCollection($this->userService->getUserFollowers($user_id), 'success', "List User Followers");
    }

    public function getUserFollowings($user_id)
    {
        return new UserCollection($this->userService->getUserFollowings($user_id), 'success', "List User Followings");
    }

    public function editUser(EditUserRequest  $request, $user_id)
    {
        return $this->userResponse($this->userService->updateUser($request->validated(), $user_id), "success", "data updated");
    }

    public function follow(FollowRequest $request)
    {
        // dd($request->validated());
        $message = $this->userService->follow($request->validated());
        return response()->json([
            "status" => "success",
            "message" => "$message success",
        ]);
    }

    public function uploadFile(UploadFileRequest $request)
    {
        $filename = $this->userService->uploadFile($request);
        return response()->json([
            "status" => "success",
            "message" => "Upload success",
            "data" => [
                "filename" => $filename
            ]
        ]);
    }

    public function userResponse($user, $status, $message)
    {
        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => new UserResource($user)
        ]);
    }
}
