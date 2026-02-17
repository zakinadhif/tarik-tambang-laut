<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/game');
});

Route::get('/game', function () {
    return response()->file(public_path('game/index.html'));
});
Route::resource('questions', App\Http\Controllers\QuestionController::class);