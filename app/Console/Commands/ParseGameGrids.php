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
    protected $signature = 'game:parse-grids {--hide-solution}';

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
        $isDaily = true;
        $this->readFileAndCreateEntry('daily_grids', $isDaily);

        $this->readFileAndCreateEntry('random_grids', !$isDaily);
    }

    public function readFileAndCreateEntry($folder, $is_daily){

        $hideSolution = $this->option('hide-solution');

        $files = Storage::disk('local')->files($folder);

        foreach($files as $file) {
            $contents = Storage::disk('local')->get($file);

            if($hideSolution !== null){
                $contents = $this->hideSolution($contents);
            }

            // Allows to mathematically guarantee grid's uniqueness
            $uniqueHash = crc32($contents);
            $maxValue = $this->getMaxValueFromEncoded($contents);

            try {
                $problem = SudokuProblem::create([
                    'problem' => $contents,
                    'unique_hash' => $uniqueHash,
                    'max_value' => $maxValue,
                    'is_daily' => $is_daily,
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

    private function hideSolution(string $contents): string
    {
        $rows = explode("\n", $contents);
        $maxValue = count($rows);
        $minRandValue = (int) sqrt($maxValue) - 1;

        foreach ($rows as &$row) {
            $values = str_split($row);
            $numValuesToHide = rand($minRandValue, count($values) - 1);
            $valuesToHide = array_rand($values, $numValuesToHide);
            
            if (!is_array($valuesToHide)) {
                $valuesToHide = [$valuesToHide];
            }
            foreach ($valuesToHide as $index) {
                $values[$index] = 0;
            }
            $row = implode($values);
        }
        return implode("\n", $rows);
    }
}
