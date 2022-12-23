<?php

namespace App\Actions;

use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\PayloadRequest;

class DecryptResponseAction
{
    /**
     * Decrypt payload
     */
    public function execute(PayloadRequest $request)
    {
        $content = Crypt::decryptString($request->payload);
        return json_decode($content);
    }
}
