<?php

declare(strict_types=1);

namespace App\Application\UseCases\CompanySignIn;

use App\Domain\RepositoryInterfaces\CompanyRepositoryInterface;
use App\Domain\ValueObjects\Email;
use InvalidArgumentException;

/**
 * 企業サインインユースケース
 */
class CompanySignInUseCase
{
    /**
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository,
    ) {
    }

    /**
     * 企業サインインを実行する
     *
     * @param CompanySignInUseCaseInput $input
     * @return CompanySignInUseCaseOutput
     * @throws InvalidArgumentException メールアドレスまたはパスワードが正しくない場合
     */
    public function execute(CompanySignInUseCaseInput $input): CompanySignInUseCaseOutput
    {
        // メールアドレスで企業を検索
        $email = new Email($input->email);
        $company = $this->companyRepository->findByEmail($email);

        if ($company === null) {
            throw new InvalidArgumentException('メールアドレスまたはパスワードが正しくありません');
        }

        // パスワードを検証
        if (!$company->verifyPassword($input->password)) {
            throw new InvalidArgumentException('メールアドレスまたはパスワードが正しくありません');
        }

        // リメンバートークンを設定（必要な場合）
        if ($input->remember) {
            $rememberToken = bin2hex(random_bytes(32));
            $company->setRememberToken($rememberToken);
            $this->companyRepository->save($company);
        }

        // 認証トークンを生成
        $token = $this->generateToken($company->id()->value());

        // 出力オブジェクトを返す
        return new CompanySignInUseCaseOutput(
            $company->id()->value(),
            $company->name()->value(),
            $company->email()->value(),
            $token,
        );
    }

    /**
     * 認証トークンを生成する
     *
     * @param int $companyId
     * @return string
     * @throws \RuntimeException 企業が見つからない場合
     */
    private function generateToken(int $companyId): string
    {
        // Sanctumを使用してトークンを生成
        $company = \App\Infrastructure\Models\CompanyModel::query()->find($companyId);

        if ($company === null) {
            throw new \RuntimeException('企業が見つかりません');
        }

        return $company->createToken('auth-token')->plainTextToken;
    }
}
