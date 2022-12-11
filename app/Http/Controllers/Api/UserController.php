<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(): UserCollection
    {
        return new UserCollection($this->user->get());
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function profile(): UserResource
    {
        return new UserResource($this->user->myProfile());
    }
}
