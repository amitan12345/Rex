<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Company;
use App\Domain\RepositoryInterfaces\CompanyRepositoryInterface;
use App\Domain\ValueObjects\CompanyId;
use App\Domain\ValueObjects\CompanyName;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;
use App\Infrastructure\Models\CompanyModel;
use RuntimeException;

/**
 * 企業リポジトリの実装
 */
class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @var CompanyModel
     */
    private CompanyModel $companyModel;

    /**
     * @param CompanyModel $companyModel
     */
    public function __construct(CompanyModel $companyModel)
    {
        $this->companyModel = $companyModel;
    }

    /**
     * 企業を保存する
     *
     * @param Company $company
     * @return Company
     */
    public function save(Company $company): Company
    {
        if ($company->id() === null) {
            // 新規作成
            $model = new CompanyModel();
        } else {
            // 更新
            $model = $this->companyModel->findOrFail($company->id()->value());
        }

        $model->name = $company->name()->value();
        $model->email = $company->email()->value();

        // パスワードが変更された場合のみ更新
        if ($company->id() === null || $model->password !== $company->password()->value()) {
            $model->password = $company->password()->value();
        }

        if ($company->rememberToken() !== null) {
            $model->remember_token = $company->rememberToken();
        }

        $model->save();

        // 保存されたエンティティを返す
        return new Company(
            new CompanyId($model->id),
            new CompanyName($model->name),
            new Email($model->email),
            Password::fromHash($model->password),
            $model->remember_token
        );
    }

    /**
     * IDで企業を検索する
     *
     * @param CompanyId $id
     * @return Company|null
     */
    public function findById(CompanyId $id): ?Company
    {
        $model = $this->companyModel->find($id->value());

        if ($model === null) {
            return null;
        }

        return $this->toEntity($model);
    }

    /**
     * メールアドレスで企業を検索する
     *
     * @param Email $email
     * @return Company|null
     */
    public function findByEmail(Email $email): ?Company
    {
        $model = $this->companyModel->where('email', $email->value())->first();

        if ($model === null) {
            return null;
        }

        return $this->toEntity($model);
    }

    /**
     * メールアドレスが既に存在するかチェックする
     *
     * @param Email $email
     * @return bool
     */
    public function existsByEmail(Email $email): bool
    {
        return $this->companyModel->where('email', $email->value())->exists();
    }

    /**
     * 企業を削除する
     *
     * @param CompanyId $id
     * @return void
     */
    public function delete(CompanyId $id): void
    {
        $this->companyModel->destroy($id->value());
    }

    /**
     * モデルからエンティティに変換する
     *
     * @param CompanyModel $model
     * @return Company
     */
    private function toEntity(CompanyModel $model): Company
    {
        return new Company(
            new CompanyId($model->id),
            new CompanyName($model->name),
            new Email($model->email),
            Password::fromHash($model->password),
            $model->remember_token
        );
    }

    /**
     * 認証トークンを生成する
     *
     * @param CompanyId $id
     * @return string
     * @throws RuntimeException 企業が見つからない場合
     */
    public function generateAuthToken(CompanyId $id): string
    {
        $company = $this->companyModel->find($id->value());

        if ($company === null) {
            throw new RuntimeException('企業が見つかりません');
        }

        return $company->createToken('auth-token')->plainTextToken;
    }

    /**
     * 企業の認証トークンを無効化する
     *
     * @param CompanyId $id
     * @return bool
     * @throws RuntimeException 企業が見つからない場合
     */
    public function revokeAuthTokens(CompanyId $id): bool
    {
        $company = $this->companyModel->find($id->value());

        if ($company === null) {
            throw new RuntimeException('企業が見つかりません');
        }

        // すべてのトークンを削除
        $company->tokens()->delete();

        return true;
    }
}
