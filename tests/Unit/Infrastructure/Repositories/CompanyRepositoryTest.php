<?php

namespace Tests\Unit\Infrastructure\Repositories;

use App\Domain\Entities\Company;
use App\Domain\ValueObjects\CompanyId;
use App\Domain\ValueObjects\CompanyName;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;
use App\Infrastructure\Models\CompanyModel;
use App\Infrastructure\Repositories\CompanyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private CompanyRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CompanyRepository($this->app->make(CompanyModel::class));
    }

    /**
     * 企業を保存できることをテスト
     */
    public function test_can_save_company(): void
    {
        // 企業エンティティを作成
        $company = new Company(
            null,
            new CompanyName('Test Company'),
            new Email('test@example.com'),
            new Password('password123')
        );

        // 企業を保存
        $savedCompany = $this->repository->save($company);

        // 保存された企業を検証
        $this->assertNotNull($savedCompany->id());
        $this->assertEquals('Test Company', $savedCompany->name()->value());
        $this->assertEquals('test@example.com', $savedCompany->email()->value());

        // データベースに保存されたことを確認
        $this->assertDatabaseHas('companies', [
            'id' => $savedCompany->id()->value(),
            'name' => 'Test Company',
            'email' => 'test@example.com',
        ]);
    }

    /**
     * 企業を更新できることをテスト
     */
    public function test_can_update_company(): void
    {
        // 企業モデルを作成
        $model = CompanyModel::create([
            'name' => 'Original Company',
            'email' => 'original@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 企業エンティティを作成
        $company = new Company(
            new CompanyId($model->id),
            new CompanyName('Updated Company'),
            new Email('updated@example.com'),
            Password::fromHash($model->password)
        );

        // 企業を更新
        $updatedCompany = $this->repository->save($company);

        // 更新された企業を検証
        $this->assertEquals($model->id, $updatedCompany->id()->value());
        $this->assertEquals('Updated Company', $updatedCompany->name()->value());
        $this->assertEquals('updated@example.com', $updatedCompany->email()->value());

        // データベースが更新されたことを確認
        $this->assertDatabaseHas('companies', [
            'id' => $model->id,
            'name' => 'Updated Company',
            'email' => 'updated@example.com',
        ]);
    }

    /**
     * IDで企業を検索できることをテスト
     */
    public function test_can_find_company_by_id(): void
    {
        // 企業モデルを作成
        $model = CompanyModel::create([
            'name' => 'Test Company',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // IDで企業を検索
        $company = $this->repository->findById(new CompanyId($model->id));

        // 検索結果を検証
        $this->assertNotNull($company);
        $this->assertEquals($model->id, $company->id()->value());
        $this->assertEquals('Test Company', $company->name()->value());
        $this->assertEquals('test@example.com', $company->email()->value());
    }

    /**
     * 存在しないIDで企業を検索するとnullが返ることをテスト
     */
    public function test_find_by_id_returns_null_for_nonexistent_id(): void
    {
        $company = $this->repository->findById(new CompanyId(999));
        $this->assertNull($company);
    }

    /**
     * メールアドレスで企業を検索できることをテスト
     */
    public function test_can_find_company_by_email(): void
    {
        // 企業モデルを作成
        $model = CompanyModel::create([
            'name' => 'Test Company',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // メールアドレスで企業を検索
        $company = $this->repository->findByEmail(new Email('test@example.com'));

        // 検索結果を検証
        $this->assertNotNull($company);
        $this->assertEquals($model->id, $company->id()->value());
        $this->assertEquals('Test Company', $company->name()->value());
        $this->assertEquals('test@example.com', $company->email()->value());
    }

    /**
     * 存在しないメールアドレスで企業を検索するとnullが返ることをテスト
     */
    public function test_find_by_email_returns_null_for_nonexistent_email(): void
    {
        $company = $this->repository->findByEmail(new Email('nonexistent@example.com'));
        $this->assertNull($company);
    }

    /**
     * メールアドレスの存在チェックができることをテスト
     */
    public function test_can_check_if_email_exists(): void
    {
        // 企業モデルを作成
        CompanyModel::create([
            'name' => 'Test Company',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // メールアドレスの存在チェック
        $this->assertTrue($this->repository->existsByEmail(new Email('test@example.com')));
        $this->assertFalse($this->repository->existsByEmail(new Email('nonexistent@example.com')));
    }

    /**
     * 企業を削除できることをテスト
     */
    public function test_can_delete_company(): void
    {
        // 企業モデルを作成
        $model = CompanyModel::create([
            'name' => 'Test Company',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 企業を削除
        $this->repository->delete(new CompanyId($model->id));

        // データベースから削除されたことを確認
        $this->assertDatabaseMissing('companies', [
            'id' => $model->id,
        ]);
    }
}
