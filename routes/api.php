<?php

use App\Http\Controllers\Api\Game\ChallengeController;


Route::get('/challenges/daily', [ChallengeController::class, 'index']);
Route::get('/challenges/random', [ChallengeController::class, 'index']);

Route::get('/challenges/daily/{id}', [ChallengeController::class, 'daily']);
Route::get('/challenges/random/{id}', [ChallengeController::class, 'random']);