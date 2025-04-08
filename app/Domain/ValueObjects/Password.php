<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;
use Illuminate\Support\Facades\Hash;

/**
 * パスワードを表すバリューオブジェクト
 */
final class Password
{
    /**
     * @var string
     */
    private string $value;

    /**
     * @param string $value
     * @param bool $isHashed
     * @throws InvalidArgumentException
     */
    public function __construct(string $value, bool $isHashed = false)
    {
        if (!$isHashed) {
            if (strlen($value) < 8) {
                throw new InvalidArgumentException('Password must be at least 8 characters');
            }
            $this->value = Hash::make($value);
        } else {
            $this->value = $value;
        }
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @param string $plainPassword
     * @return bool
     */
    public function verify(string $plainPassword): bool
    {
        return Hash::check($plainPassword, $this->value);
    }

    /**
     * ハッシュ化されたパスワードからインスタンスを作成
     *
     * @param string $hashedPassword
     * @return self
     */
    public static function fromHash(string $hashedPassword): self
    {
        return new self($hashedPassword, true);
    }
}
