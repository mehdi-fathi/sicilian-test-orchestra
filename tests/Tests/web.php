<?php

use Illuminate\Support\Facades\Route;

Route::get('/sample', [\Tests\Tests\Controller\SampleController::class, 'index']);

Route::post('/save', [\Tests\Tests\Controller\SampleController::class, 'save']);
