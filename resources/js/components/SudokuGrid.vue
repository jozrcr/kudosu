<template>
  <ul
    class="bg-gray-600/50 p-1 min-w-80 rounded-lg max-w-7xl w-fit h-fit grid justify-items-center gap-[0.1rem]  md:gap-1 sudoku"
    :style="maxValueStyle"
  >
    <li
      v-for="(row, rowIndex) in initialBoard"
      :key="rowIndex"
      class="row grid gap-[0.1rem] md:gap-1 sudoku-grid place-content-center justify-items-center"
      :class="[(rowIndex + 1) % boxSize === 0 ? 'pb-[0.125rem] md:pb-1' : '', ((rowIndex + 1) % boxSize) === 1 ? 'pt-[0.125rem] md:pt-1' : '']"
      :style="maxValueStyle"
    >
      <SudokuCell
        v-for="(cell, colIndex) in row"
        :key="colIndex"
        :base-value="cell"
        :current-value="board[rowIndex][colIndex]"
        :is-error="errorBoard[rowIndex][colIndex]"
        :class="[(colIndex + 1) % boxSize === 0 ? 'mr-[0.125rem] md:mr-1' : '', ((colIndex + 1) % boxSize) === 1 ? 'ml-[0.125rem] md:ml-1' : '']"
        :max-value="maxValue"
        @input="updateCell(rowIndex, colIndex, $event)"
        @empty="emptyCell(rowIndex, colIndex)"
      />
    </li>
  </ul>
</template>

<script setup>
import { ref, computed } from 'vue'

import SudokuCell from './SudokuCell.vue'

/* Default to 9 for a standard 9x9 Sudoku grid, goal is to be able to select a different difficulty */
const maxValue = ref(9)

const boxSize = computed(() => parseInt(Math.sqrt(maxValue.value)));

const maxValueStyle = computed(() => {
    return {
        '--max-value': maxValue.value,
        '--box-size': boxSize.value,
    };
});


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

    console.log(serializeGrid());
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
        if( board.value[rowIndex][i] === cellValue && colIndex != i ){
            return false;
        }
    }
    return true;
} 

//Function to check if a cell is duplicate in a col
const isValidCellCol = (rowIndex, colIndex, cellValue) => {
    for(let i = 0; i < maxValue.value; i++) {
        if( board.value[i][colIndex] == cellValue && rowIndex != i ){
            return false;
        }
    }
    return true;
} 

//Function to check if a cell is duplicate in a box
const isValidCellBox = (rowIndex, colIndex, cellValue) => {

    const boxWidth = boxWidth.value;
    //Define which box we are validating
    const row = Math.trunc(rowIndex / boxWidth) * boxWidth;
    const col = Math.trunc(colIndex / boxWidth) * boxWidth;

    for (let i = 0; i < boxWidth; i++){
        for (let j = 0; j < boxWidth; j++){
            const newRow =  row + i;
            const newCol = col + j;
            if(  ( board.value[newRow][newCol] === cellValue ) && newRow != rowIndex && newCol != colIndex ){
                return false;
            }
        }
    }
    return true;
} 

const emptyCell = (rowIndex, colIndex) => {
    board.value[rowIndex][colIndex] = 0;

    errorBoard.value = validateSudoku();
}

const serializeGrid = () =>{
    let serializedGrid = [];

    for (let i = 0; i < maxValue.value; i++){
        serializedGrid.push(board.value[i].join(''));
    }

    return serializedGrid.join("\n");
}

</script>

<style scoped>

.sudoku {
    grid-template-rows: repeat(var(--max-value), minmax(0, 1fr))
}

.sudoku  li {
    grid-template-columns: repeat(var(--max-value), minmax(0, 1fr))
}

</style>
