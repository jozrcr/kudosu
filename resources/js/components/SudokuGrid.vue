<template>
  <ul
    class="bg-gray-600/50 p-1 min-w-80 rounded-lg max-w-7xl w-fit h-fit grid justify-items-center gap-[0.1rem]  md:gap-1 sudoku"
    :style="maxValueStyle"
  >
    <li
      v-for="(row, rowIndex) in initialBoard"
      :key="rowIndex"
      class="row grid gap-[0.1rem] md:gap-1 sudoku-grid place-content-center justify-items-center"
      :class="[(rowIndex + 1) % boxWidth === 0 ? 'pb-[0.125rem] md:pb-1' : '', ((rowIndex + 1) % boxWidth) === 1 ? 'pt-[0.125rem] md:pt-1' : '']"
      :style="maxValueStyle"
    >
      <SudokuCell
        v-for="(cell, colIndex) in row"
        :key="colIndex"
        :base-value="cell"
        :current-value="board[rowIndex][colIndex]"
        :is-error="errorBoard[rowIndex][colIndex]"
        :class="[(colIndex + 1) % boxWidth === 0 ? 'mr-[0.125rem] md:mr-1' : '', ((colIndex + 1) % boxWidth) === 1 ? 'ml-[0.125rem] md:ml-1' : '']"
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
const maxValue = ref(4)

const boxWidth =  computed(() => {

    return parseInt(Math.sqrt(maxValue.value));
});

/* Value used in css to dynamically change the number of columns/rows needed to display the proper grid */
const maxValueStyle = computed(() => {

    return {
        '--max-value': maxValue.value,
        '--box-size': boxWidth.value,
    };
});


/*Array that stores the initial game state*/
const initialBoard = [
    [1, 3, 0, 0 ],
    [2, 0, 0, 1 ],
    [0, 1, 2, 0 ],
    [3, 0, 0, 0 ],
]

/*Array that stores the ongoing game board */
const board = ref([
    [1, 3, 0, 0 ],
    [2, 0, 0, 1 ],
    [0, 1, 2, 0 ],
    [3, 0, 0, 0 ],
])

/*Array that stores the current errors game board */
const errorBoard = ref([
    [false, false, false, false],
    [false, false, false, false],
    [false, false, false, false],
    [false, false, false, false],
])

const updateCell = (rowIndex, colIndex, value) => {
    board.value[rowIndex][colIndex] = value;

    errorBoard.value = validateSudoku();
    
    console.log(serializeGrid());
}

/* Returns an array that contains all detected errors in the grid */
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

    const boxSize = boxWidth.value;
    //Define which box we are validating
    const row = Math.trunc(rowIndex / boxSize) * boxSize;
    const col = Math.trunc(colIndex / boxSize) * boxSize;

    for (let i = 0; i < boxSize; i++){
        for (let j = 0; j < boxSize; j++){
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
