<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;

class EncryptResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $this->modifyResponse($response);
        }

        return $response;
    }

    protected function modifyResponse(JsonResponse $response)
    {
        if (config('app.env') === 'production') {
            $content = json_decode($response->content(), true);
            $payload = [
                'payload' => Crypt::encryptString(json_encode($content))
            ];
        } else {
            $payload = json_decode($response->content(), true);
        }

        $response->setContent(json_encode($payload));
    }
}
