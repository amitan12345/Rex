<?php

namespace Tests\Unit\Domain\ValueObjects;

use App\Domain\ValueObjects\CompanyName;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CompanyNameTest extends TestCase
{
    /**
     * 有効な企業名でインスタンスを作成できることをテスト
     */
    public function test_can_create_with_valid_name(): void
    {
        $name = new CompanyName('Test Company');
        $this->assertEquals('Test Company', $name->value());
        $this->assertEquals('Test Company', (string) $name);
    }

    /**
     * 空の企業名で例外がスローされることをテスト
     */
    public function test_throws_exception_with_empty_name(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CompanyName('');
    }

    /**
     * 空白のみの企業名で例外がスローされることをテスト
     */
    public function test_throws_exception_with_whitespace_only_name(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CompanyName('   ');
    }

    /**
     * 長すぎる企業名で例外がスローされることをテスト
     */
    public function test_throws_exception_with_too_long_name(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CompanyName(str_repeat('a', 256));
    }

    /**
     * 前後の空白が削除されることをテスト
     */
    public function test_trims_whitespace(): void
    {
        $name = new CompanyName('  Test Company  ');
        $this->assertEquals('Test Company', $name->value());
    }

    /**
     * 同じ値を持つCompanyNameオブジェクトが等しいことをテスト
     */
    public function test_equals_returns_true_for_same_value(): void
    {
        $name1 = new CompanyName('Test Company');
        $name2 = new CompanyName('Test Company');
        $this->assertTrue($name1->equals($name2));
    }

    /**
     * 異なる値を持つCompanyNameオブジェクトが等しくないことをテスト
     */
    public function test_equals_returns_false_for_different_value(): void
    {
        $name1 = new CompanyName('Test Company 1');
        $name2 = new CompanyName('Test Company 2');
        $this->assertFalse($name1->equals($name2));
    }
}
