<?php

declare(strict_types=1);

namespace Tests\Unit\Application\UseCases\CompanySignOut;

use App\Application\UseCases\CompanySignOut\CompanySignOutUseCase;
use App\Application\UseCases\CompanySignOut\CompanySignOutUseCaseInput;
use App\Domain\Entities\Company;
use App\Domain\RepositoryInterfaces\CompanyRepositoryInterface;
use App\Domain\ValueObjects\CompanyId;
use App\Domain\ValueObjects\CompanyName;
use App\Domain\ValueObjects\Email;
// use App\Domain\ValueObjects\Password;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * 企業サインアウトユースケーステスト
 */
class CompanySignOutUseCaseTest extends TestCase
{
    /**
     * 正常系: サインアウトが成功する
     */
    public function testExecuteSuccess(): void
    {
        // モックの準備
        $companyId = new CompanyId(1);
        $company = $this->createMock(Company::class);
        $company->method('id')->willReturn($companyId);

        $companyRepository = $this->createMock(CompanyRepositoryInterface::class);
        $companyRepository->method('findById')->with($companyId)->willReturn($company);
        $companyRepository->method('revokeAuthTokens')->with($companyId)->willReturn(true);

        // ユースケースの実行
        $useCase = new CompanySignOutUseCase($companyRepository);
        $input = new CompanySignOutUseCaseInput(1);
        $output = $useCase->execute($input);

        // 検証
        $this->assertTrue($output->success);
    }

    /**
     * 異常系: 企業が見つからない
     */
    public function testExecuteCompanyNotFound(): void
    {
        // モックの準備
        $companyId = new CompanyId(999);

        $companyRepository = $this->createMock(CompanyRepositoryInterface::class);
        $companyRepository->method('findById')->with($companyId)->willReturn(null);

        // ユースケースの実行と例外の検証
        $useCase = new CompanySignOutUseCase($companyRepository);
        $input = new CompanySignOutUseCaseInput(999);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('企業が見つかりません');

        $useCase->execute($input);
    }

    /**
     * 異常系: トークン無効化に失敗
     */
    public function testExecuteRevokeTokensFailed(): void
    {
        // モックの準備
        $companyId = new CompanyId(1);
        $company = $this->createMock(Company::class);
        $company->method('id')->willReturn($companyId);

        $companyRepository = $this->createMock(CompanyRepositoryInterface::class);
        $companyRepository->method('findById')->with($companyId)->willReturn($company);
        $companyRepository->method('revokeAuthTokens')->with($companyId)->willReturn(false);

        // ユースケースの実行
        $useCase = new CompanySignOutUseCase($companyRepository);
        $input = new CompanySignOutUseCaseInput(1);
        $output = $useCase->execute($input);

        // 検証
        $this->assertFalse($output->success);
    }
}
