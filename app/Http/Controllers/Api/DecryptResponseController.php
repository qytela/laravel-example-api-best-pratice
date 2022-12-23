<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayloadRequest;
use App\Actions\DecryptResponseAction;

class DecryptResponseController extends Controller
{
    public function __invoke(DecryptResponseAction $decryptResponseAction, PayloadRequest $request)
    {
        return $decryptResponseAction->execute($request);
    }
}
