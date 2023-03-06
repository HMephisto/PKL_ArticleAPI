<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUser($request);
    public function getUserById($user_id);
    public function getUserContent($user_id);
    public function getUserFollowers($user_id);
    public function getUserFollowings($user_id);
    public function createUser(array $UserDetails);
    public function updateUser(array $newDetails, $user_id);
    public function follow($user_id, $follower_id);
    public function deleteUser($user_id);
}