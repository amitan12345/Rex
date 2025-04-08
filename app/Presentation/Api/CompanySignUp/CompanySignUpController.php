<?php

namespace App\Presentation\Api\CompanySignUp;

use App\Application\UseCases\CompanySignUp\CompanySignUpUseCase;
use App\Application\UseCases\CompanySignUp\CompanySignUpUseCaseInput;
use App\Framework\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

/**
 * 企業サインアップコントローラー
 */
class CompanySignUpController extends Controller
{
    /**
     * @var CompanySignUpUseCase
     */
    private CompanySignUpUseCase $companySignUpUseCase;

    /**
     * @var CompanySignUpResponder
     */
    private CompanySignUpResponder $responder;

    /**
     * @param CompanySignUpUseCase $companySignUpUseCase
     * @param CompanySignUpResponder $responder
     */
    public function __construct(
        CompanySignUpUseCase $companySignUpUseCase,
        CompanySignUpResponder $responder
    ) {
        $this->companySignUpUseCase = $companySignUpUseCase;
        $this->responder = $responder;
    }

    /**
     * 企業サインアップを処理する
     *
     * @param CompanySignUpRequest $request
     * @return JsonResponse
     */
    public function __invoke(CompanySignUpRequest $request): JsonResponse
    {
        try {
            // リクエストからユースケース入力を作成
            $validated = $request->validated();
            $input = new CompanySignUpUseCaseInput(
                $validated['name'],
                $validated['email'],
                $validated['password']
            );

            // ユースケースを実行
            $output = $this->companySignUpUseCase->execute($input);

            // 成功レスポンスを返す
            return $this->responder->response($output);
        } catch (InvalidArgumentException $e) {
            // バリデーションエラーレスポンスを返す
            return $this->responder->error($e->getMessage());
        } catch (\Exception $e) {
            // サーバーエラーレスポンスを返す
            return $this->responder->error('An error occurred during registration', 500);
        }
    }
}
