<?php

declare(strict_types=1);

namespace App\Application\UseCases\CompanySignOut;

final readonly class CompanySignOutUseCaseInput
{
    public function __construct(
        public int $companyId,
    ) {
    }
}
