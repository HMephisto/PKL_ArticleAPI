<?php

namespace App\Services;

use App\Helper\ImageHelper;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Arr;

class UserService
{
    private $userRepo;
    private $imageHelper;

    public function __construct(UserRepositoryInterface $userRepo, ImageHelper $imageHelper)
    {
        $this->userRepo = $userRepo;
        $this->imageHelper = $imageHelper;
    }

    public function getAllUser($request)
    {
        return $this->userRepo->getAllUser($request);
    }

    public function getUserDetail($user_id)
    {
        return $this->userRepo->getUserById($user_id);
    }

    public function getUserContent($user_id)
    {
        $user_data = $this->userRepo->getUserContent($user_id);
        $article = ['articles' => $user_data->articles, 'liked_articles' => $user_data->liked_articles];
        return $article;
    }

    public function getUserFollowers($user_id)
    {
        $user_data = $this->userRepo->getUserFollowers($user_id);
        return $user_data->followers;
    }

    public function getUserFollowings($user_id)
    {
        $user_data = $this->userRepo->getUserFollowings($user_id);
        return $user_data->followings;
    }

    public function saveUser($request)
    {
        return $this->userRepo->createUser($request);
    }

    public function updateUser($request, $user_id)
    {
        $userDetail = $this->userRepo->getUserById($user_id);
        if ($userDetail->verifikasi != true) {
            $request += ['verifikasi' => true];
        }
        if (Arr::exists($request, 'profile_picture')) {
            if ($userDetail->profile_picture != null) {
                $this->imageHelper->deleteImage($userDetail->profile_picture);
            }
        }
        if (Arr::exists($request, 'profile_cover')) {
            if ($userDetail->profile_cover != null) {
                $this->imageHelper->deleteImage($userDetail->profile_cover);
            }
        }
        return $this->userRepo->updateUser($request, $user_id);
    }

    public function follow($request)
    {
        return $this->userRepo->follow(Auth('api')->id(), $request['follower_id']);
    }

    public function uploadFile($request)
    {
        $filename = time() . "-user." . $request['image']->getClientOriginalExtension();
        $this->imageHelper->upload($request['image'], $filename);
        return $filename;
    }
}
