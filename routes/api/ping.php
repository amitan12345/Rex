<?php

use App\Presentation\Api\Ping\PingController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', PingController::class);
