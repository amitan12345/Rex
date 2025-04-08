<?php

declare(strict_types=1);

namespace App\Presentation\Api\CompanySignIn;

use App\Application\UseCases\CompanySignIn\CompanySignInUseCaseOutput;
use Illuminate\Http\JsonResponse;

/**
 * 企業サインインレスポンダー
 */
class CompanySignInResponder
{
    /**
     * 成功レスポンスを返す
     *
     * @param CompanySignInUseCaseOutput $output
     * @return JsonResponse
     */
    public function respond(CompanySignInUseCaseOutput $output): JsonResponse
    {
        return response()->json([
            'message' => 'サインインに成功しました',
            'data' => [
                'id' => $output->id,
                'name' => $output->name,
                'email' => $output->email,
            ],
            'token' => $output->token,
        ], 200);
    }

    /**
     * バリデーションエラーレスポンスを返す
     *
     * @param array<string, string> $errors
     * @return JsonResponse
     */
    public function respondValidationError(array $errors): JsonResponse
    {
        return response()->json([
            'message' => 'バリデーションエラー',
            'errors' => $errors,
        ], 422);
    }

    /**
     * 認証エラーレスポンスを返す
     *
     * @param string $message
     * @return JsonResponse
     */
    public function respondAuthError(string $message): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], 401);
    }

    /**
     * サーバーエラーレスポンスを返す
     *
     * @return JsonResponse
     */
    public function respondServerError(): JsonResponse
    {
        return response()->json([
            'message' => 'サインイン処理中にエラーが発生しました',
        ], 500);
    }
}
