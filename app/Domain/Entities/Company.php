<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\CompanyId;
use App\Domain\ValueObjects\CompanyName;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;

/**
 * 企業エンティティ
 */
class Company
{
    /**
     * @var CompanyId|null
     */
    private ?CompanyId $id;

    /**
     * @var CompanyName
     */
    private CompanyName $name;

    /**
     * @var Email
     */
    private Email $email;

    /**
     * @var Password
     */
    private Password $password;

    /**
     * @var string|null
     */
    private ?string $rememberToken;

    /**
     * @param CompanyId|null $id
     * @param CompanyName $name
     * @param Email $email
     * @param Password $password
     * @param string|null $rememberToken
     */
    public function __construct(
        ?CompanyId $id,
        CompanyName $name,
        Email $email,
        Password $password,
        ?string $rememberToken = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->rememberToken = $rememberToken;
    }

    /**
     * @return CompanyId|null
     */
    public function id(): ?CompanyId
    {
        return $this->id;
    }

    /**
     * @return CompanyName
     */
    public function name(): CompanyName
    {
        return $this->name;
    }

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * @return Password
     */
    public function password(): Password
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function rememberToken(): ?string
    {
        return $this->rememberToken;
    }

    /**
     * @param CompanyName $name
     * @return void
     */
    public function changeName(CompanyName $name): void
    {
        $this->name = $name;
    }

    /**
     * @param Password $password
     * @return void
     */
    public function changePassword(Password $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string|null $token
     * @return void
     */
    public function setRememberToken(?string $token): void
    {
        $this->rememberToken = $token;
    }

    /**
     * @param string $plainPassword
     * @return bool
     */
    public function verifyPassword(string $plainPassword): bool
    {
        return $this->password->verify($plainPassword);
    }
}
