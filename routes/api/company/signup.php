<?php

use App\Presentation\Api\CompanySignUp\CompanySignUpController;
use Illuminate\Support\Facades\Route;

Route::post('companies/signup', CompanySignUpController::class);
