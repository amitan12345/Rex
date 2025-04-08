<?php

namespace App\Presentation\Api\Ping;

use App\Framework\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PingController extends Controller
{
    /**
     * Handle the ping request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'message' => 'pong',
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
