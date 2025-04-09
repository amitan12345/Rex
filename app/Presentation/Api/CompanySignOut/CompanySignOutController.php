<?php

declare(strict_types=1);

namespace App\Presentation\Api\CompanySignOut;

use App\Application\UseCases\CompanySignOut\CompanySignOutUseCase;
use App\Application\UseCases\CompanySignOut\CompanySignOutUseCaseInput;
use App\Framework\Http\Controllers\Controller;
use App\Infrastructure\Models\CompanyModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

/**
 * 企業サインアウトコントローラー
 */
class CompanySignOutController extends Controller
{
    /**
     * @param CompanySignOutUseCase $useCase
     * @param CompanySignOutResponder $responder
     */
    public function __construct(
        private readonly CompanySignOutUseCase $useCase,
        private readonly CompanySignOutResponder $responder,
    ) {
    }

    /**
     * 企業サインアウト処理
     *
     * @param CompanySignOutRequest $request
     * @return JsonResponse
     */
    public function __invoke(CompanySignOutRequest $request): JsonResponse
    {
        try {
            // 認証済みユーザーのIDを取得
            /** @var CompanyModel $user */
            $user = $request->user();
            $companyId = $user->id;

            // ユースケース入力を作成
            $input = new CompanySignOutUseCaseInput($companyId);

            // ユースケースを実行
            $output = $this->useCase->execute($input);

            // 成功レスポンスを返す
            return $this->responder->respond($output);
        } catch (RuntimeException $e) {
            // エラーレスポンスを返す
            return $this->responder->respondError($e->getMessage());
        }
    }
}
