<?php

namespace App\Http\Controllers\Api\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SudokuProblem;
use App\Http\Resources\SudokuProblemResource;

class ChallengeController extends Controller
{

    public function daily( $maxValue)
    {
        $challenge = SudokuProblem::where('is_daily', true)
            ->whereDate('date', now()->toDateString())
            ->where('max_value', $maxValue)
            ->orderBy('created_at', 'ASC')
            ->firstOrFail();

        return new SudokuProblemResource(
            resource: $challenge,
        );
    }

    // Fetches a list of all available random problems for a given maxValue (difficulty)
    public function random($maxValue)
    {
        $challenge = SudokuProblem::where('is_daily', false)
            ->where('maxValue', $maxValue);

        return response()->json($challenges);
    }

}
