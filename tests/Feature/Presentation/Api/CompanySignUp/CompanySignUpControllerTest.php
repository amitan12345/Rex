<?php

namespace Tests\Feature\Presentation\Api\CompanySignUp;

use App\Application\UseCases\CompanySignUp\CompanySignUpUseCase;
use App\Application\UseCases\CompanySignUp\CompanySignUpUseCaseOutput;
use App\Presentation\Api\CompanySignUp\CompanySignUpResponder;
use InvalidArgumentException;
use Mockery;
use Tests\TestCase;

class CompanySignUpControllerTest extends TestCase
{
    /**
     * 企業サインアップが成功することをテスト
     */
    public function test_company_signup_returns_success_response(): void
    {
        // ユースケースのモック
        $useCase = Mockery::mock(CompanySignUpUseCase::class);
        $output = new CompanySignUpUseCaseOutput(1, 'Test Company', 'test@example.com');
        $useCase->shouldReceive('execute')->once()->andReturn($output);

        // サービスコンテナにモックを登録
        $this->app->instance(CompanySignUpUseCase::class, $useCase);

        // APIリクエストを送信
        $response = $this->postJson('/api/companies/signup', [
            'name' => 'Test Company',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // レスポンスを検証
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Company registered successfully',
                'data' => [
                    'id' => 1,
                    'name' => 'Test Company',
                    'email' => 'test@example.com',
                ],
            ]);
    }

    /**
     * バリデーションエラーが発生した場合のテスト
     */
    public function test_company_signup_returns_validation_error(): void
    {
        // APIリクエストを送信（必須フィールドを省略）
        $response = $this->postJson('/api/companies/signup', [
            'name' => 'Test Company',
            'email' => 'invalid-email',
        ]);

        // レスポンスを検証
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    /**
     * メールアドレスが既に使用されている場合のテスト
     */
    public function test_company_signup_returns_error_when_email_already_exists(): void
    {
        // ユースケースのモック
        $useCase = Mockery::mock(CompanySignUpUseCase::class);
        $useCase->shouldReceive('execute')
            ->once()
            ->andThrow(new InvalidArgumentException('Email is already in use'));

        // サービスコンテナにモックを登録
        $this->app->instance(CompanySignUpUseCase::class, $useCase);

        // APIリクエストを送信
        $response = $this->postJson('/api/companies/signup', [
            'name' => 'Test Company',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // レスポンスを検証
        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Email is already in use',
            ]);
    }

    /**
     * サーバーエラーが発生した場合のテスト
     */
    public function test_company_signup_returns_error_on_server_error(): void
    {
        // ユースケースのモック
        $useCase = Mockery::mock(CompanySignUpUseCase::class);
        $useCase->shouldReceive('execute')
            ->once()
            ->andThrow(new \Exception('Server error'));

        // サービスコンテナにモックを登録
        $this->app->instance(CompanySignUpUseCase::class, $useCase);

        // APIリクエストを送信
        $response = $this->postJson('/api/companies/signup', [
            'name' => 'Test Company',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // レスポンスを検証
        $response->assertStatus(500)
            ->assertJson([
                'message' => 'An error occurred during registration',
            ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
