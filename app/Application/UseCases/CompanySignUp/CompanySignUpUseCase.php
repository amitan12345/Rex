<?php

namespace App\Application\UseCases\CompanySignUp;

use App\Domain\Entities\Company;
use App\Domain\RepositoryInterfaces\CompanyRepositoryInterface;
use App\Domain\ValueObjects\CompanyName;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;
use InvalidArgumentException;

/**
 * 企業サインアップユースケース
 */
class CompanySignUpUseCase
{
    /**
     * @var CompanyRepositoryInterface
     */
    private CompanyRepositoryInterface $companyRepository;

    /**
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * 企業サインアップを実行する
     *
     * @param CompanySignUpUseCaseInput $input
     * @return CompanySignUpUseCaseOutput
     * @throws InvalidArgumentException
     */
    public function execute(CompanySignUpUseCaseInput $input): CompanySignUpUseCaseOutput
    {
        // バリューオブジェクトの作成
        $email = new Email($input->email());
        $name = new CompanyName($input->name());
        $password = new Password($input->password());

        // メールアドレスの重複チェック
        if ($this->companyRepository->existsByEmail($email)) {
            throw new InvalidArgumentException('Email is already in use');
        }

        // 企業エンティティの作成
        $company = new Company(
            null,
            $name,
            $email,
            $password
        );

        // 企業の保存
        $savedCompany = $this->companyRepository->save($company);

        // 出力の作成
        $id = $savedCompany->id();
        if ($id === null) {
            throw new \RuntimeException('Failed to save company: ID is null');
        }

        return new CompanySignUpUseCaseOutput(
            $id->value(),
            $savedCompany->name()->value(),
            $savedCompany->email()->value()
        );
    }
}
