<?php

declare(strict_types=1);

namespace Tests\Feature\Presentation\Api\CompanySignOut;

use App\Domain\Entities\Company;
use App\Domain\ValueObjects\CompanyId;
use App\Domain\ValueObjects\CompanyName;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;
use App\Infrastructure\Models\CompanyModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * 企業サインアウトコントローラーテスト
 */
class CompanySignOutControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 正常系: サインアウトが成功する
     */
    public function testSignOutSuccess(): void
    {
        // テスト用の企業を作成
        $company = CompanyModel::create([
            'name' => 'テスト企業',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 認証済みユーザーとしてリクエスト
        Sanctum::actingAs($company);

        // トークンを作成
        $company->createToken('auth-token');

        // APIリクエスト
        $response = $this->postJson('/api/company/signout');

        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'サインアウトしました',
            ]);

        // トークンが削除されたことを確認
        $this->assertCount(0, $company->tokens);
    }

    /**
     * 異常系: 未認証ユーザーはアクセスできない
     */
    public function testSignOutUnauthenticated(): void
    {
        // 未認証ユーザーとしてリクエスト
        $response = $this->postJson('/api/company/signout');

        // レスポンスの検証
        $response->assertStatus(401);
    }
}
