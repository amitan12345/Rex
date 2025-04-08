<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

/**
 * 企業IDを表すバリューオブジェクト
 */
final class CompanyId
{
    /**
     * @var int
     */
    private int $value;

    /**
     * @param int $value
     * @throws InvalidArgumentException
     */
    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Company ID must be a positive integer');
        }

        $this->value = $value;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }

    /**
     * @param CompanyId $other
     * @return bool
     */
    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
