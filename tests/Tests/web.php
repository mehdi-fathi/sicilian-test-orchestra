<?php

use Illuminate\Support\Facades\Route;

Route::get('/sample', [\BlindFoldTest\Controller\SampleController::class, 'index']);
