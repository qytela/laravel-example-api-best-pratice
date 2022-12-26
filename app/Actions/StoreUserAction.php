<?php

namespace App\Actions;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Models\Role;

class StoreUserAction
{
    /**
     * It creates a new user, assigns the role of Member to the user, and then creates a token for the
     * user
     * 
     * @param User user The user model
     * @param RegisterRequest request The request object
     * 
     * @return User The User object.
     */
    public function execute(User $user, RegisterRequest $request): User
    {
        $obj = $user->create($request->validated());
        $obj->assignRole(Role::Member);
        $obj->token = $obj->createToken(config('app.name'))->accessToken;

        return $obj;
    }
}
