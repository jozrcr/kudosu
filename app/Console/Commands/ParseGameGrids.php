<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\SudokuProblem;

class ParseGameGrids extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:parse-grids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse pre-generated sudoku game grids and create corresponding database entries';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = Storage::disk('local')->files('generated_grids');

        foreach($files as $file) {
            $contents = Storage::disk('local')->get($file);
            $uniqueHash = crc32($contents);
            $maxValue = $this->getMaxValueFromEncoded($contents);

            try {
                $problem = SudokuProblem::create([
                    'problem' => $contents,
                    'unique_hash' => $uniqueHash,
                    'max_value' => $maxValue,
                    'date' => null,
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->errorInfo[1] == 1062) {

                    // Duplicate entry error
                    // The unique_hash value is already taken
                    // Continue to the next iteration of the loop

                    error_log("!!! Game problem was already saved, continuing parsing !!!");

                    continue;
                } else {
                    // Other error occurred
                    throw $e;
                }
            }
        }

        $this->info('Game grids parsed successfully.');
    }

    public function getMaxValueFromEncoded($encodedString){
        $rows = explode("\n", $encodedString);
        $maxValue = count($rows);

        return $maxValue;
    }
}
