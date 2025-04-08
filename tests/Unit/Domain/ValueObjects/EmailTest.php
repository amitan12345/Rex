<?php

namespace Tests\Unit\Domain\ValueObjects;

use App\Domain\ValueObjects\Email;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    /**
     * 有効なメールアドレスでインスタンスを作成できることをテスト
     */
    public function test_can_create_with_valid_email(): void
    {
        $email = new Email('test@example.com');
        $this->assertEquals('test@example.com', $email->value());
        $this->assertEquals('test@example.com', (string) $email);
    }

    /**
     * 無効なメールアドレスで例外がスローされることをテスト
     */
    public function test_throws_exception_with_invalid_email(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('invalid-email');
    }

    /**
     * 空のメールアドレスで例外がスローされることをテスト
     */
    public function test_throws_exception_with_empty_email(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('');
    }

    /**
     * 同じ値を持つEmailオブジェクトが等しいことをテスト
     */
    public function test_equals_returns_true_for_same_value(): void
    {
        $email1 = new Email('test@example.com');
        $email2 = new Email('test@example.com');
        $this->assertTrue($email1->equals($email2));
    }

    /**
     * 異なる値を持つEmailオブジェクトが等しくないことをテスト
     */
    public function test_equals_returns_false_for_different_value(): void
    {
        $email1 = new Email('test1@example.com');
        $email2 = new Email('test2@example.com');
        $this->assertFalse($email1->equals($email2));
    }
}
