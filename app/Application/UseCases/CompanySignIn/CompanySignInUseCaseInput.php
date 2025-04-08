<?php

declare(strict_types=1);

namespace App\Application\UseCases\CompanySignIn;

/**
 * 企業サインインユースケースの入力値オブジェクト
 */
readonly class CompanySignInUseCaseInput
{
    /**
     * @param string $email 企業のメールアドレス
     * @param string $password 企業のパスワード
     * @param bool $remember リメンバーミー機能を使用するかどうか
     */
    public function __construct(
        public string $email,
        public string $password,
        public bool $remember = false,
    ) {
    }
}
