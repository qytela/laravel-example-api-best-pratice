<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Traits\GroupableTrait;
use App\Models\User;

class UserController extends Controller
{
    use GroupableTrait;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(PaginateRequest $request): UserCollection
    {
        return new UserCollection(
            $this->eligibleGroups($this->user)->withPaginate($request)
        );
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
