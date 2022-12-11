<?php

namespace App\Services;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Models\Role;

class RegisterService
{
    protected User $user;
    protected Role $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Store or create new user
     */
    public function storeUser(RegisterRequest $request, string $roleName = 'member', string $tokenName = null): User
    {
        $filterRole = $this->role->countRoleByName($roleName);
        if ($filterRole === 0) abort(422, config('constants.errors.role_not_exists'));

        $obj = $this->user->create($request->validated());
        $obj->assignRole($roleName);
        $obj->token = $obj->createToken($tokenName)->accessToken;

        return $obj;
    }
}
