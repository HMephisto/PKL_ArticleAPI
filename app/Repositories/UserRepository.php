<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    private $users;

    public function __construct()
    {
        $this->users = new User();
    }
    public function getAllUser($request)
    {
        return $this->users->when($request->search, function ($q) use ($request) {
            $q->where('username', 'ilike', "%$request->search%");
        })->with('articles')->withCount(['followers', 'followings'])->simplePaginate($request->per_page ?? 15);
    }

    public function getUserById($id)
    {
        $a = $this->users::withCount(['followers', 'followings'])->findorfail($id);
        info($a);
        return $a;
    }

    public function getUserContent($id)
    {
        return $this->users::with(['articles', 'liked_articles'])->findorfail($id);
    }

    public function getUserFollowers($user_id)
    {

        return $this->users::with('followers')->findorfail($user_id);
    }

    public function getUserFollowings($user_id)
    {
        return $this->users::with('Followings')->findorfail($user_id);
    }

    public function createUser($userDetails)
    {
        return $this->users::create([
            "full_name" => $userDetails["full_name"],
            "username" => $userDetails["username"],
            "email" => $userDetails["email"],
            "password" => bcrypt($userDetails["password"]),
        ]);
    }

    public function follow($user_id, $follower_id)
    {
        $user = $this->users::findorfail($user_id);
        if ($user->followings()->where('follower_id', $follower_id)->exists()) {
            $user->followings()->detach($follower_id);
            return "unfollow";
        } else {
            $user->followings()->attach($follower_id);
            return "follow";
        }
    }


    public function updateUser($newDetails, $id)
    {
        return tap($this->users::findorfail($id))->update($newDetails);
    }

    public function deleteUser($id)
    {
        $this->users::where('id', $id)->delete();
    }
}
