<?php

namespace Tests\Unit\Domain\ValueObjects;

use App\Domain\ValueObjects\Password;
use InvalidArgumentException;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    /**
     * 有効なパスワードでインスタンスを作成できることをテスト
     */
    public function test_can_create_with_valid_password(): void
    {
        $password = new Password('password123');
        $this->assertNotEmpty($password->value());
    }

    /**
     * 短すぎるパスワードで例外がスローされることをテスト
     */
    public function test_throws_exception_with_short_password(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Password('short');
    }

    /**
     * ハッシュ化されたパスワードからインスタンスを作成できることをテスト
     */
    public function test_can_create_from_hash(): void
    {
        $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
        $password = Password::fromHash($hashedPassword);
        $this->assertEquals($hashedPassword, $password->value());
    }

    /**
     * パスワードの検証が正しく機能することをテスト
     */
    public function test_verify_returns_true_for_correct_password(): void
    {
        $password = new Password('password123');
        $this->assertTrue($password->verify('password123'));
    }

    /**
     * パスワードの検証が誤ったパスワードに対してfalseを返すことをテスト
     */
    public function test_verify_returns_false_for_incorrect_password(): void
    {
        $password = new Password('password123');
        $this->assertFalse($password->verify('wrongpassword'));
    }
}
