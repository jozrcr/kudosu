<template>
  <ul
    class="bg-gray-500/50 p-1 min-w-80 rounded-lg max-w-7xl w-fit h-fit grid grid-rows-9 gap-[0.1rem] md:gap-1 h-"
  >
    <li
      v-for="(row, rowIndex) in initialBoard"
      :key="rowIndex"
      class="row grid grid-cols-9 gap-[0.1rem] md:gap-1 sudoku-grid place-content-center justify-items-center"
    >
      <SudokuCell
        v-for="(cell, colIndex) in row"
        :key="colIndex"
        :base-value="cell"
        :current-value="board[rowIndex][colIndex]"
        :is-error="errorBoard[rowIndex][colIndex]"
        :max-value="maxValue"
        @input="updateCell(rowIndex, colIndex, $event)"
        @empty="emptyCell(rowIndex, colIndex)"
      />
    </li>
  </ul>
</template>

<script setup>
import { ref } from 'vue'

import SudokuCell from './SudokuCell.vue'

/* Default to 9 for a standard 9x9 Sudoku grid, goal is to be able to select a different difficulty */
const maxValue = ref(9)

/*Array that stores the initial game state*/
const initialBoard = [
    [5, 3, 0, 0, 7, 0, 0, 0, 0],
    [6, 0, 0, 1, 9, 5, 0, 0, 0],
    [0, 9, 8, 0, 0, 0, 0, 6, 0],
    [8, 0, 0, 0, 6, 0, 0, 0, 3],
    [4, 0, 0, 8, 0, 3, 0, 0, 1],
    [7, 0, 0, 0, 2, 0, 0, 0, 6],
    [0, 6, 0, 0, 0, 0, 2, 8, 0],
    [0, 0, 0, 4, 1, 9, 0, 0, 5],
    [0, 0, 0, 0, 8, 0, 0, 7, 9],
]

/*Array that stores the ongoing game board */
const board = ref([
    [5, 3, 0, 0, 7, 0, 0, 0, 0],
    [6, 0, 0, 1, 9, 5, 0, 0, 0],
    [0, 9, 8, 0, 0, 0, 0, 6, 0],
    [8, 0, 0, 0, 6, 0, 0, 0, 3],
    [4, 0, 0, 8, 0, 3, 0, 0, 1],
    [7, 0, 0, 0, 2, 0, 0, 0, 6],
    [0, 6, 0, 0, 0, 0, 2, 8, 0],
    [0, 0, 0, 4, 1, 9, 0, 0, 5],
    [0, 0, 0, 0, 8, 0, 0, 7, 9],
])

/*Array that stores the current errors game board */
const errorBoard = ref([
    [false, false, false, false, false, false, false, false, false],
    [false, false, false, false, false, false, false, false, false],
    [false, false, false, false, false, false, false, false, false],
    [false, false, false, false, false, false, false, false, false],
    [false, false, false, false, false, false, false, false, false],
    [false, false, false, false, false, false, false, false, false],
    [false, false, false, false, false, false, false, false, false],
    [false, false, false, false, false, false, false, false, false],
    [false, false, false, false, false, false, false, false, false],
])

const updateCell = (rowIndex, colIndex, value) => {
    board.value[rowIndex][colIndex] = value;

    errorBoard.value = validateSudoku();
}

const validateSudoku = () => {
    let temp_board = [
        [false, false, false, false, false, false, false, false, false],
        [false, false, false, false, false, false, false, false, false],
        [false, false, false, false, false, false, false, false, false],
        [false, false, false, false, false, false, false, false, false],
        [false, false, false, false, false, false, false, false, false],
        [false, false, false, false, false, false, false, false, false],
        [false, false, false, false, false, false, false, false, false],
        [false, false, false, false, false, false, false, false, false],
        [false, false, false, false, false, false, false, false, false],
    ];
    for( let i = 0; i < maxValue.value; i++){
        for( let j = 0; j < maxValue.value; j++) {
            const cellValue = board.value[i][j];
            
            if (cellValue != 0){
                if(!isValidCellRow(i, j, cellValue) || !isValidCellCol(i, j, cellValue) || !isValidCellBox(i, j, cellValue)){
                    temp_board[i][j] = true;
                }
            }
        }
    }

    return temp_board;
}

//Function to check if a cell is duplicate in a row
const isValidCellRow = (rowIndex, colIndex, cellValue) => {
    for(let i = 0; i < maxValue.value; i++) {
        if( board.value[rowIndex][i] === cellValue && colIndex !== i ){
            return false;
        }
    }
    return true;
} 

//Function to check if a cell is duplicate in a col
const isValidCellCol = (rowIndex, colIndex, cellValue) => {
    for(let i = 0; i < maxValue.value; i++) {
        if( board.value[i][colIndex] == cellValue && rowIndex !== i ){
            return false;
        }
    }
    return true;
} 

//Function to check if a cell is duplicate in a box
const isValidCellBox = (rowIndex, colIndex, cellValue) => {

    const boxWidth = Math.sqrt(maxValue.value);
    //Define which box we are validating
    const row = rowIndex - (rowIndex % boxWidth);
    const col = colIndex - (colIndex % boxWidth);

    for (let i = 0; i < row + boxWidth; i++){
        for (let j = 0; j < col + boxWidth; j++){
            if( board.value[i][j] === cellValue && i != rowIndex && j !== colIndex){
                return false;
            }
        }
    }
    return true;
} 


const emptyCell = (rowIndex, colIndex) => {
    board.value[rowIndex][colIndex] = 0;
}

</script>

<style scoped>
.sudoku-grid:nth-child(3n) {
    padding-bottom: 0.25rem;
}

.sudoku-grid:nth-child(3n + 1) {
    padding-top: 0.25rem;
}

.sudoku-grid > div:nth-child(3n) {
    margin-right: 0.25rem;
}

.sudoku-grid > div:nth-child(3n + 1) {
    margin-left: 0.25rem;
}
@media only screen and (max-width: 600px) {
    .sudoku-grid:nth-child(3n) {
        padding-bottom: 0.1rem;
    }

    .sudoku-grid:nth-child(3n + 1) {
        padding-top: 0.1rem;
    }

    .sudoku-grid > div:nth-child(3n) {
        margin-right: 0.1rem;
    }

    .sudoku-grid > div:nth-child(3n + 1) {
        margin-left: 0.1rem;
    }
}
</style>
