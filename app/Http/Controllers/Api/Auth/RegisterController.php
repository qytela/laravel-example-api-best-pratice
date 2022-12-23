<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\RegisterResource;
use App\Actions\StoreUserAction;
use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke(
        User $user,
        StoreUserAction $storeUserAction,
        RegisterRequest $request
    ): RegisterResource {
        return new RegisterResource($storeUserAction->execute($user, $request));
    }
}
