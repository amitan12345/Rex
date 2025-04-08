<?php

declare(strict_types=1);

namespace App\Presentation\Api\CompanySignIn;

use App\Application\UseCases\CompanySignIn\CompanySignInUseCase;
use App\Application\UseCases\CompanySignIn\CompanySignInUseCaseInput;
use App\Framework\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

/**
 * 企業サインインコントローラー
 */
class CompanySignInController extends Controller
{
    /**
     * @param CompanySignInUseCase $useCase
     * @param CompanySignInResponder $responder
     */
    public function __construct(
        private readonly CompanySignInUseCase $useCase,
        private readonly CompanySignInResponder $responder,
    ) {
    }

    /**
     * 企業サインイン処理
     *
     * @param CompanySignInRequest $request
     * @return JsonResponse
     */
    public function __invoke(CompanySignInRequest $request): JsonResponse
    {
        try {
            // リクエストからユースケース入力を作成
            $validated = $request->validated();
            $input = new CompanySignInUseCaseInput(
                $validated['email'],
                $validated['password'],
                $validated['remember'] ?? false,
            );

            // ユースケースを実行
            $output = $this->useCase->execute($input);

            // 成功レスポンスを返す
            return $this->responder->respond($output);
        } catch (InvalidArgumentException $e) {
            // 認証エラーレスポンスを返す
            return $this->responder->respondAuthError($e->getMessage());
        } catch (\Exception $e) {
            // サーバーエラーレスポンスを返す
            return $this->responder->respondServerError();
        }
    }
}
