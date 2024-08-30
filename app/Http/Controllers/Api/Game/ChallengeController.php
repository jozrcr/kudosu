<?php

namespace App\Http\Controllers\Api\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SudokuProblem;

class ChallengeController extends Controller
{
    public function index($type = 'daily')
    {
        $query = SudokuProblem::query();

        if ($type == 'daily') {
            $query->where('is_daily', true)
                ->whereNull('date')
                ->orderBy('created_at', 'ASC');
        }
        else{
            $query->where('is_daily', false)
            ->orderBy('created_at', 'ASC');
        }

        $challenges = $query->get();
        return response()->json($challenges);
    }

    public function daily($id)
    {
        $challenge = SudokuProblem::where('is_daily', true)
            ->whereNull('date')
            ->findOrFail($id);

        return response()->json($challenge);
    }

    public function random($id)
    {
        
        $challenge = SudokuProblem::where('is_daily', false)
            ->findOrFail($id);

        return response()->json($challenge);
    }

}
