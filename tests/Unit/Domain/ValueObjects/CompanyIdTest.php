<?php

namespace Tests\Unit\Domain\ValueObjects;

use App\Domain\ValueObjects\CompanyId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CompanyIdTest extends TestCase
{
    /**
     * 有効なIDでインスタンスを作成できることをテスト
     */
    public function test_can_create_with_valid_id(): void
    {
        $id = new CompanyId(1);
        $this->assertEquals(1, $id->value());
        $this->assertEquals('1', (string) $id);
    }

    /**
     * ゼロのIDで例外がスローされることをテスト
     */
    public function test_throws_exception_with_zero_id(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CompanyId(0);
    }

    /**
     * 負のIDで例外がスローされることをテスト
     */
    public function test_throws_exception_with_negative_id(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CompanyId(-1);
    }

    /**
     * 同じ値を持つCompanyIdオブジェクトが等しいことをテスト
     */
    public function test_equals_returns_true_for_same_value(): void
    {
        $id1 = new CompanyId(1);
        $id2 = new CompanyId(1);
        $this->assertTrue($id1->equals($id2));
    }

    /**
     * 異なる値を持つCompanyIdオブジェクトが等しくないことをテスト
     */
    public function test_equals_returns_false_for_different_value(): void
    {
        $id1 = new CompanyId(1);
        $id2 = new CompanyId(2);
        $this->assertFalse($id1->equals($id2));
    }
}
