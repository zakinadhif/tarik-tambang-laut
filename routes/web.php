<?php

use App\Models\Question;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/game');
});

Route::get('/game', function () {
    $questions = Question::all(['question', 'answer']);
    return view('game', compact('questions'));
});

Route::get('/api/questions', function () {
    return Question::all(['question', 'answer']);
});

Route::resource('questions', App\Http\Controllers\QuestionController::class);