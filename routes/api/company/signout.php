<?php

use App\Presentation\Api\CompanySignOut\CompanySignOutController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->post('/company/signout', CompanySignOutController::class);
