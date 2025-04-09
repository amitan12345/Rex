<?php

declare(strict_types=1);

namespace App\Presentation\Api\CompanySignOut;

use App\Application\UseCases\CompanySignOut\CompanySignOutUseCaseOutput;
use Illuminate\Http\JsonResponse;

/**
 * 企業サインアウトレスポンダー
 */
class CompanySignOutResponder
{
    /**
     * 成功レスポンスを返す
     *
     * @param CompanySignOutUseCaseOutput $output
     * @return JsonResponse
     */
    public function respond(CompanySignOutUseCaseOutput $output): JsonResponse
    {
        return response()->json([
            'success' => $output->success,
            'message' => 'サインアウトしました',
        ]);
    }

    /**
     * エラーレスポンスを返す
     *
     * @param string $message
     * @return JsonResponse
     */
    public function respondError(string $message): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 400);
    }
}
