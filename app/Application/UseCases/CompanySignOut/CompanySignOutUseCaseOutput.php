<?php

declare(strict_types=1);

namespace App\Application\UseCases\CompanySignOut;

final readonly class CompanySignOutUseCaseOutput
{
    public function __construct(
        public bool $success,
    ) {
    }
}
