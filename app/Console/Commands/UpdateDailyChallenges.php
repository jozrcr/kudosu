<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SudokuProblem;

class UpdateDailyChallenges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:daily-challenges';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select the daily challenges and assign current date to their date field';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dailyChallenges;
        
        // Check if there are already challenges with the current date and the desired max_value values, fill an array with missing ones
        $missingChallenges = [];
        foreach ([4, 9, 16] as $maxValue) {
            $existingChallenge = SudokuProblem::where('is_daily', true)
                ->whereDate('date', now()->toDateString())
                ->where('max_value', $maxValue)
                ->first();
            if (!$existingChallenge) {
                $missingChallenges[] = $maxValue;
            }
        }


        // If there are any missing daily challenges, fetch new challenges for the missing max_value values
        if (!empty($missingChallenges)) {
            foreach($missingChallenges as $maxValue){
                $newChallenge = SudokuProblem::where('is_daily', true)
                    ->whereNull('date')
                    ->where('max_value', $maxValue)
                    ->orderBy('created_at', 'ASC')
                    ->first();

                if ($newChallenge) {
                    $newChallenge->date = now()->toDateString();
                    $newChallenge->save();

                }
            }
        }
        
       
        $this->info('Daily challenges updated successfully.');
    }
}
