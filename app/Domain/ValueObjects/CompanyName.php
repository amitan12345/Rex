<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

/**
 * 企業名を表すバリューオブジェクト
 */
final class CompanyName
{
    /**
     * @var string
     */
    private string $value;

    /**
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        $trimmedValue = trim($value);

        if (empty($trimmedValue)) {
            throw new InvalidArgumentException('Company name cannot be empty');
        }

        if (mb_strlen($trimmedValue) > 255) {
            throw new InvalidArgumentException('Company name cannot exceed 255 characters');
        }

        $this->value = $trimmedValue;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @param CompanyName $other
     * @return bool
     */
    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
