<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Include API route files
require __DIR__ . '/api/ping.php';
require __DIR__ . '/api/company/signup.php';
require __DIR__ . '/api/company/signin.php';
require __DIR__ . '/api/company/signout.php';
