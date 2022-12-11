<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\RegisterResource;
use App\Services\RegisterService;

class RegisterController extends Controller
{
    public function __invoke(RegisterService $registerService, RegisterRequest $request): RegisterResource
    {
        return new RegisterResource($registerService->storeUser($request));
    }
}
