<?php

namespace App\Domain\RepositoryInterfaces;

use App\Domain\Entities\Company;
use App\Domain\ValueObjects\CompanyId;
use App\Domain\ValueObjects\Email;

/**
 * 企業リポジトリインターフェース
 */
interface CompanyRepositoryInterface
{
    /**
     * 企業を保存する
     *
     * @param Company $company
     * @return Company 保存された企業（IDが設定される）
     */
    public function save(Company $company): Company;

    /**
     * IDで企業を検索する
     *
     * @param CompanyId $id
     * @return Company|null
     */
    public function findById(CompanyId $id): ?Company;

    /**
     * メールアドレスで企業を検索する
     *
     * @param Email $email
     * @return Company|null
     */
    public function findByEmail(Email $email): ?Company;

    /**
     * メールアドレスが既に存在するかチェックする
     *
     * @param Email $email
     * @return bool
     */
    public function existsByEmail(Email $email): bool;

    /**
     * 企業を削除する
     *
     * @param CompanyId $id
     * @return void
     */
    public function delete(CompanyId $id): void;

    /**
     * 認証トークンを生成する
     *
     * @param CompanyId $id
     * @return string
     * @throws \RuntimeException 企業が見つからない場合
     */
    public function generateAuthToken(CompanyId $id): string;

    /**
     * 企業の認証トークンを無効化する
     *
     * @param CompanyId $id
     * @return bool 成功した場合はtrue、失敗した場合はfalse
     * @throws \RuntimeException 企業が見つからない場合
     */
    public function revokeAuthTokens(CompanyId $id): bool;
}
