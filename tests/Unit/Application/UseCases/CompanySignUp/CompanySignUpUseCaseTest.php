<?php

namespace Tests\Unit\Application\UseCases\CompanySignUp;

use App\Application\UseCases\CompanySignUp\CompanySignUpUseCase;
use App\Application\UseCases\CompanySignUp\CompanySignUpUseCaseInput;
use App\Domain\Entities\Company;
use App\Domain\RepositoryInterfaces\CompanyRepositoryInterface;
use App\Domain\ValueObjects\CompanyId;
use App\Domain\ValueObjects\CompanyName;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;
use InvalidArgumentException;
use Mockery;
use Tests\TestCase;

class CompanySignUpUseCaseTest extends TestCase
{
    private $companyRepository;
    private CompanySignUpUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyRepository = Mockery::mock(CompanyRepositoryInterface::class);
        $this->useCase = new CompanySignUpUseCase($this->companyRepository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * 企業サインアップが成功することをテスト
     */
    public function test_execute_returns_output_on_success(): void
    {
        // 入力データ
        $input = new CompanySignUpUseCaseInput(
            'Test Company',
            'test@example.com',
            'password123'
        );

        // メールアドレスの重複チェック
        $this->companyRepository->shouldReceive('existsByEmail')
            ->once()
            ->andReturn(false);

        // 保存された企業エンティティ
        $savedCompany = new Company(
            new CompanyId(1),
            new CompanyName('Test Company'),
            new Email('test@example.com'),
            new Password('password123')
        );

        // 保存メソッドの期待値
        $this->companyRepository->shouldReceive('save')
            ->once()
            ->andReturn($savedCompany);

        // ユースケースを実行
        $output = $this->useCase->execute($input);

        // 出力を検証
        $this->assertEquals(1, $output->id());
        $this->assertEquals('Test Company', $output->name());
        $this->assertEquals('test@example.com', $output->email());
    }

    /**
     * メールアドレスが既に使用されている場合に例外がスローされることをテスト
     */
    public function test_execute_throws_exception_when_email_already_exists(): void
    {
        // 入力データ
        $input = new CompanySignUpUseCaseInput(
            'Test Company',
            'test@example.com',
            'password123'
        );

        // メールアドレスの重複チェック
        $this->companyRepository->shouldReceive('existsByEmail')
            ->once()
            ->andReturn(true);

        // 保存メソッドは呼ばれないことを期待
        $this->companyRepository->shouldReceive('save')
            ->never();

        // 例外がスローされることを期待
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email is already in use');

        // ユースケースを実行
        $this->useCase->execute($input);
    }
}
