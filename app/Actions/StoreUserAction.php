<?php

namespace App\Actions;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Models\Role;

class StoreUserAction
{
    /**
     * Store or create new user
     */
    public function execute(User $user, RegisterRequest $request): User
    {
        $obj = $user->create($request->validated());
        $obj->assignRole(Role::Member);
        $obj->token = $obj->createToken(config('app.name'))->accessToken;

        return $obj;
    }
}
