# Kudosu - Daily Sudoku Puzzles
Kudosu is a simple web app that allows users to solve Sudoku puzzles daily.
This project was built on Laravel - VueJS using TailwindCSS for most of the CSS.
The goal was to learn how to use VueJS and how to use it alongside Laravel.

## How it works
Basically, the web app has a command "game:parse-grids" that will open all the files located in "storage/app/daily_grids" and store them in the database as SudokuProblem entities.

These entities will hold the following data :
 - The problem as an encoded string
 - A unique_hash calculated with crc32()
 - A max value that represents the size of the grid (which can be 4x4, 9x9 or 16x16)
 - A 'is_daily' boolean that allows to filter daily and random challenges
 - A date field which allows to filter daily challenges that have already been used

Once a day, a scheduled command "update:daily-challenges" will be executed to add the current date to 3 new challenges (One for each difficulty), which will allow us to have new puzzles daily.

The Vue components then use API Endpoints to retrieve the challenge of the day in the selected difficulty.

Every time the user selects a number, a function is ran to check for Errors and logic conflicts, if an error is logged, the cell and the affected ones will turn red to show the user that the move was impossible. At the same time, the sudoku grid is encoded and stored in a unique cookie, which allows to save the state of the game.

When the grid is complete and no error has been detected, the initially empty cells turn green and can't be modified anymore. (I have yet to implement a win screen)

