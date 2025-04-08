<?php

namespace Tests\Unit\Application\UseCases\CompanySignIn;

use App\Application\UseCases\CompanySignIn\CompanySignInUseCase;
use App\Application\UseCases\CompanySignIn\CompanySignInUseCaseInput;
use App\Domain\Entities\Company;
use App\Domain\RepositoryInterfaces\CompanyRepositoryInterface;
use App\Domain\ValueObjects\CompanyId;
use App\Domain\ValueObjects\CompanyName;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;
use App\Infrastructure\Models\CompanyModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Mockery;
use Tests\TestCase;

class CompanySignInUseCaseTest extends TestCase
{
    use RefreshDatabase;

    private CompanyRepositoryInterface $companyRepository;
    private CompanySignInUseCase $useCase;
    private Company $company;

    protected function setUp(): void
    {
        parent::setUp();

        // リポジトリのモックを設定
        $this->companyRepository = Mockery::mock(CompanyRepositoryInterface::class);
        $this->useCase = new CompanySignInUseCase($this->companyRepository);

        // テスト用の企業エンティティを作成
        $this->company = new Company(
            new CompanyId(1),
            new CompanyName('Test Company'),
            new Email('test@example.com'),
            Password::fromHash(bcrypt('password123'))
        );

        // テスト用のCompanyModelを作成（トークン生成のために必要）
        CompanyModel::create([
            'id' => 1,
            'name' => 'Test Company',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
    }

    /**
     * 正常にサインインできることをテスト
     */
    public function test_can_sign_in_with_valid_credentials(): void
    {
        // リポジトリのモックを設定
        $this->companyRepository->shouldReceive('findByEmail')
            ->once()
            ->with(Mockery::type(Email::class))
            ->andReturn($this->company);

        // 認証トークン生成のモックを設定
        $this->companyRepository->shouldReceive('generateAuthToken')
            ->once()
            ->with(Mockery::type(CompanyId::class))
            ->andReturn('test-token');

        // 入力値を作成
        $input = new CompanySignInUseCaseInput(
            'test@example.com',
            'password123',
            false
        );

        // ユースケースを実行
        $output = $this->useCase->execute($input);

        // 出力を検証
        $this->assertEquals(1, $output->id);
        $this->assertEquals('Test Company', $output->name);
        $this->assertEquals('test@example.com', $output->email);
        $this->assertNotEmpty($output->token);
    }

    /**
     * 存在しないメールアドレスでサインインできないことをテスト
     */
    public function test_cannot_sign_in_with_non_existent_email(): void
    {
        // リポジトリのモックを設定
        $this->companyRepository->shouldReceive('findByEmail')
            ->once()
            ->with(Mockery::type(Email::class))
            ->andReturn(null);

        // 入力値を作成
        $input = new CompanySignInUseCaseInput(
            'nonexistent@example.com',
            'password123',
            false
        );

        // 例外が発生することを検証
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('メールアドレスまたはパスワードが正しくありません');

        // ユースケースを実行
        $this->useCase->execute($input);
    }

    /**
     * 不正なパスワードでサインインできないことをテスト
     */
    public function test_cannot_sign_in_with_invalid_password(): void
    {
        // 不正なパスワードでテスト用の企業エンティティを作成
        $company = new Company(
            new CompanyId(1),
            new CompanyName('Test Company'),
            new Email('test@example.com'),
            Password::fromHash(bcrypt('different_password'))
        );

        // リポジトリのモックを設定
        $this->companyRepository->shouldReceive('findByEmail')
            ->once()
            ->with(Mockery::type(Email::class))
            ->andReturn($company);

        // 入力値を作成
        $input = new CompanySignInUseCaseInput(
            'test@example.com',
            'wrong_password',
            false
        );

        // 例外が発生することを検証
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('メールアドレスまたはパスワードが正しくありません');

        // ユースケースを実行
        $this->useCase->execute($input);
    }

    /**
     * リメンバーミー機能を使用してサインインできることをテスト
     */
    public function test_can_sign_in_with_remember_me(): void
    {
        // リポジトリのモックを設定
        $this->companyRepository->shouldReceive('findByEmail')
            ->once()
            ->with(Mockery::type(Email::class))
            ->andReturn($this->company);

        // リポジトリの保存メソッドのモックを設定
        $this->companyRepository->shouldReceive('save')
            ->once()
            ->andReturnUsing(function (Company $company) {
                // リメンバートークンが設定されていることを確認
                $this->assertNotNull($company->rememberToken());
                return $company;
            });

        // 認証トークン生成のモックを設定
        $this->companyRepository->shouldReceive('generateAuthToken')
            ->once()
            ->with(Mockery::type(CompanyId::class))
            ->andReturn('test-token');

        // 入力値を作成
        $input = new CompanySignInUseCaseInput(
            'test@example.com',
            'password123',
            true
        );

        // ユースケースを実行
        $output = $this->useCase->execute($input);

        // 出力を検証
        $this->assertEquals(1, $output->id);
        $this->assertEquals('Test Company', $output->name);
        $this->assertEquals('test@example.com', $output->email);
        $this->assertNotEmpty($output->token);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
