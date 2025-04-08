<?php

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\Company;
use App\Domain\ValueObjects\CompanyId;
use App\Domain\ValueObjects\CompanyName;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    private CompanyId $id;
    private CompanyName $name;
    private Email $email;
    private Password $password;
    private string $rememberToken;

    protected function setUp(): void
    {
        parent::setUp();
        $this->id = new CompanyId(1);
        $this->name = new CompanyName('Test Company');
        $this->email = new Email('test@example.com');
        $this->password = Password::fromHash('hashed_password');
        $this->rememberToken = 'remember_token';
    }

    /**
     * 企業エンティティを作成できることをテスト
     */
    public function test_can_create_company(): void
    {
        $company = new Company(
            $this->id,
            $this->name,
            $this->email,
            $this->password,
            $this->rememberToken
        );

        $this->assertSame($this->id, $company->id());
        $this->assertSame($this->name, $company->name());
        $this->assertSame($this->email, $company->email());
        $this->assertSame($this->password, $company->password());
        $this->assertSame($this->rememberToken, $company->rememberToken());
    }

    /**
     * IDなしで企業エンティティを作成できることをテスト
     */
    public function test_can_create_company_without_id(): void
    {
        $company = new Company(
            null,
            $this->name,
            $this->email,
            $this->password
        );

        $this->assertNull($company->id());
        $this->assertSame($this->name, $company->name());
        $this->assertSame($this->email, $company->email());
        $this->assertSame($this->password, $company->password());
        $this->assertNull($company->rememberToken());
    }

    /**
     * 企業名を変更できることをテスト
     */
    public function test_can_change_name(): void
    {
        $company = new Company(
            $this->id,
            $this->name,
            $this->email,
            $this->password
        );

        $newName = new CompanyName('New Company Name');
        $company->changeName($newName);

        $this->assertSame($newName, $company->name());
    }

    /**
     * パスワードを変更できることをテスト
     */
    public function test_can_change_password(): void
    {
        $company = new Company(
            $this->id,
            $this->name,
            $this->email,
            $this->password
        );

        $newPassword = new Password('new_password');
        $company->changePassword($newPassword);

        $this->assertSame($newPassword, $company->password());
    }

    /**
     * リメンバートークンを設定できることをテスト
     */
    public function test_can_set_remember_token(): void
    {
        $company = new Company(
            $this->id,
            $this->name,
            $this->email,
            $this->password
        );

        $this->assertNull($company->rememberToken());

        $company->setRememberToken('new_token');
        $this->assertEquals('new_token', $company->rememberToken());
    }

    /**
     * パスワードを検証できることをテスト
     */
    public function test_can_verify_password(): void
    {
        // 実際のパスワードオブジェクトを使用
        $password = new Password('correct_password');

        $company = new Company(
            $this->id,
            $this->name,
            $this->email,
            $password
        );

        $this->assertTrue($company->verifyPassword('correct_password'));
        $this->assertFalse($company->verifyPassword('wrong_password'));
    }
}
