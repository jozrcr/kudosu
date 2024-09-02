<?php

use App\Http\Controllers\Api\Game\ChallengeController;

Route::get('/challenges/daily/{maxValue}', [ChallengeController::class, 'daily']);
Route::get('/challenges/random/{maxValue}', [ChallengeController::class, 'random']);