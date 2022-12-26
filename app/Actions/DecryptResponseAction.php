<?php

namespace App\Actions;

use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\PayloadRequest;

class DecryptResponseAction
{
    /**
     * It takes a payload request, decrypts the payload, and returns the decrypted payload as a JSON
     * object
     * 
     * @param PayloadRequest request The request object that was sent to the endpoint.
     * 
     * @return The decrypted payload.
     */
    public function execute(PayloadRequest $request)
    {
        $content = Crypt::decryptString($request->payload);
        return json_decode($content);
    }
}
