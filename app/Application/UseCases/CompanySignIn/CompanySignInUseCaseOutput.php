<?php

declare(strict_types=1);

namespace App\Application\UseCases\CompanySignIn;

/**
 * 企業サインインユースケースの出力値オブジェクト
 */
readonly class CompanySignInUseCaseOutput
{
    /**
     * @param int $id 企業ID
     * @param string $name 企業名
     * @param string $email 企業のメールアドレス
     * @param string $token 認証トークン
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $token,
    ) {
    }
}
