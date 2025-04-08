<?php

use App\Presentation\Api\CompanySignIn\CompanySignInController;
use Illuminate\Support\Facades\Route;

Route::post('companies/signin', CompanySignInController::class);
