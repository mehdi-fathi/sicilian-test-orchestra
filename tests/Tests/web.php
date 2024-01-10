<?php

use Illuminate\Support\Facades\Route;

Route::get('/list', [\Tests\Tests\Controller\CommentController::class, 'list'])->name('list');
Route::get('/show/{id}', [\Tests\Tests\Controller\CommentController::class, 'show'])->name('show');

Route::post('/save', [\Tests\Tests\Controller\CommentController::class, 'save']);
