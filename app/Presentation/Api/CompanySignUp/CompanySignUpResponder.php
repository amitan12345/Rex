<?php

namespace App\Presentation\Api\CompanySignUp;

use App\Application\UseCases\CompanySignUp\CompanySignUpUseCaseOutput;
use Illuminate\Http\JsonResponse;

/**
 * 企業サインアップレスポンダー
 */
class CompanySignUpResponder
{
    /**
     * 成功レスポンスを生成する
     *
     * @param CompanySignUpUseCaseOutput $output
     * @return JsonResponse
     */
    public function response(CompanySignUpUseCaseOutput $output): JsonResponse
    {
        return new JsonResponse([
            'message' => 'Company registered successfully',
            'data' => $output->toArray(),
        ], 201);
    }

    /**
     * エラーレスポンスを生成する
     *
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function error(string $message, int $statusCode = 400): JsonResponse
    {
        return new JsonResponse([
            'message' => $message,
        ], $statusCode);
    }
}
