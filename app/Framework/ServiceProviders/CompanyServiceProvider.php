<?php

namespace App\Framework\ServiceProviders;

use App\Application\UseCases\CompanySignUp\CompanySignUpUseCase;
use App\Domain\RepositoryInterfaces\CompanyRepositoryInterface;
use App\Infrastructure\Repositories\CompanyRepository;
use Illuminate\Support\ServiceProvider;

/**
 * 企業関連のサービスプロバイダー
 */
class CompanyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // リポジトリの登録
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);

        // ユースケースの登録
        $this->app->bind(CompanySignUpUseCase::class, function ($app) {
            return new CompanySignUpUseCase(
                $app->make(CompanyRepositoryInterface::class)
            );
        });

        $this->app->bind(\App\Application\UseCases\CompanySignIn\CompanySignInUseCase::class, function ($app) {
            return new \App\Application\UseCases\CompanySignIn\CompanySignInUseCase(
                $app->make(CompanyRepositoryInterface::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
