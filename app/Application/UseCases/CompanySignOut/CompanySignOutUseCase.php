<?php

declare(strict_types=1);

namespace App\Application\UseCases\CompanySignOut;

use App\Domain\RepositoryInterfaces\CompanyRepositoryInterface;
use App\Domain\ValueObjects\CompanyId;
use RuntimeException;

/**
 * 企業サインアウトユースケース
 */
class CompanySignOutUseCase
{
    /**
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository,
    ) {
    }

    /**
     * 企業サインアウトを実行する
     *
     * @param CompanySignOutUseCaseInput $input
     * @return CompanySignOutUseCaseOutput
     * @throws RuntimeException 企業が見つからない場合
     */
    public function execute(CompanySignOutUseCaseInput $input): CompanySignOutUseCaseOutput
    {
        // 企業IDを取得
        $companyId = new CompanyId($input->companyId);

        // 企業が存在するか確認
        $company = $this->companyRepository->findById($companyId);
        if ($company === null) {
            throw new RuntimeException('企業が見つかりません');
        }

        // 認証トークンを無効化
        $success = $this->companyRepository->revokeAuthTokens($companyId);

        // 出力オブジェクトを返す
        return new CompanySignOutUseCaseOutput($success);
    }
}
