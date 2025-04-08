<?php

namespace Tests\Feature\Presentation\Api\CompanySignIn;

use App\Application\UseCases\CompanySignIn\CompanySignInUseCase;
use App\Application\UseCases\CompanySignIn\CompanySignInUseCaseOutput;
use InvalidArgumentException;
use Mockery;
use Tests\TestCase;

class CompanySignInControllerTest extends TestCase
{
    /**
     * 企業サインインが成功することをテスト
     */
    public function test_company_signin_returns_success_response(): void
    {
        // ユースケースのモック
        $useCase = Mockery::mock(CompanySignInUseCase::class);
        $output = new CompanySignInUseCaseOutput(1, 'Test Company', 'test@example.com', 'test-token');
        $useCase->shouldReceive('execute')->once()->andReturn($output);

        // サービスコンテナにモックを登録
        $this->app->instance(CompanySignInUseCase::class, $useCase);

        // APIリクエストを送信
        $response = $this->postJson('/api/companies/signin', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'remember' => true,
        ]);

        // レスポンスを検証
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'サインインに成功しました',
                'data' => [
                    'id' => 1,
                    'name' => 'Test Company',
                    'email' => 'test@example.com',
                ],
                'token' => 'test-token',
            ]);
    }

    /**
     * バリデーションエラーが発生した場合のテスト
     */
    public function test_company_signin_returns_validation_error(): void
    {
        // APIリクエストを送信（必須フィールドを省略）
        $response = $this->postJson('/api/companies/signin', [
            'email' => 'invalid-email',
        ]);

        // レスポンスを検証
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    /**
     * 認証エラーが発生した場合のテスト
     */
    public function test_company_signin_returns_error_when_credentials_invalid(): void
    {
        // ユースケースのモック
        $useCase = Mockery::mock(CompanySignInUseCase::class);
        $useCase->shouldReceive('execute')
            ->once()
            ->andThrow(new InvalidArgumentException('メールアドレスまたはパスワードが正しくありません'));

        // サービスコンテナにモックを登録
        $this->app->instance(CompanySignInUseCase::class, $useCase);

        // APIリクエストを送信
        $response = $this->postJson('/api/companies/signin', [
            'email' => 'test@example.com',
            'password' => 'wrong_password',
        ]);

        // レスポンスを検証
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'メールアドレスまたはパスワードが正しくありません',
            ]);
    }

    /**
     * サーバーエラーが発生した場合のテスト
     */
    public function test_company_signin_returns_error_on_server_error(): void
    {
        // ユースケースのモック
        $useCase = Mockery::mock(CompanySignInUseCase::class);
        $useCase->shouldReceive('execute')
            ->once()
            ->andThrow(new \Exception('Server error'));

        // サービスコンテナにモックを登録
        $this->app->instance(CompanySignInUseCase::class, $useCase);

        // APIリクエストを送信
        $response = $this->postJson('/api/companies/signin', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // レスポンスを検証
        $response->assertStatus(500)
            ->assertJson([
                'message' => 'サインイン処理中にエラーが発生しました',
            ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
