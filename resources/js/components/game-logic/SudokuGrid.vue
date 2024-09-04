<template>
  <ul
    class="bg-gray-600/50 p-[0.125rem] sm:p-1 min-w-80 rounded-lg max-w-7xl 2xl:max-w-[100rem] w-fit h-fit grid justify-items-center gap-[0.1rem]  md:gap-1 sudoku"
    :style="maxValueStyle"
  >
    <li
      v-for="(row, rowIndex) in initialBoard"
      :key="rowIndex"
      class="row grid gap-[0.2rem] sm:gap-1 sudoku-grid place-content-center justify-items-center"
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
import { ref, computed, onBeforeMount } from 'vue'

import SudokuCell from './SudokuCell.vue'

const props = defineProps({
    maxValue: {
        type: Number,
        default: 9,
    },
    initialBoard: {
        type: Array,

    }
})

/*Array that stores the ongoing game board */
const board = ref([])

/*Array that stores the current errors game board */
const errorBoard = ref([])

const initializeGameBoard = () => {
    let temp_board = [];
    let temp_error_board = [];

    for(let i = 0; i < props.maxValue; i++) {
        let temp_board_line = [];
        let temp_error_line = [];

        for(let j = 0; j < props.maxValue; j++) {
            temp_board_line.push(props.initialBoard[i][j])
            temp_error_line.push(false)
        }
        temp_board.push(temp_board_line)
        temp_error_board.push(temp_error_line)

    }
    board.value = temp_board;
    errorBoard.value = temp_error_board;
}

const boxWidth =  computed(() => {

    return parseInt(Math.sqrt(props.maxValue));
});

/* Value used in css to dynamically change the number of columns/rows needed to display the proper grid */
const maxValueStyle = computed(() => {

    return {
        '--max-value': props.maxValue,
        '--box-size': boxWidth.value,
    };
});



const updateCell = (rowIndex, colIndex, value) => {
    board.value[rowIndex][colIndex] = value;

    errorBoard.value = validateSudoku();
    
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
    for( let i = 0; i < props.maxValue; i++){
        for( let j = 0; j < props.maxValue; j++) {
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
    for(let i = 0; i < props.maxValue; i++) {
        if( board.value[rowIndex][i] === cellValue && colIndex != i ){
            return false;
        }
    }
    return true;
} 

//Function to check if a cell is duplicate in a col
const isValidCellCol = (rowIndex, colIndex, cellValue) => {
    for(let i = 0; i < props.maxValue; i++) {
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

/* const serializeGrid = () =>{
    let serializedGrid = [];

    for (let i = 0; i < props.maxValue; i++){
        serializedGrid.push(board.value[i].join(''));
    }

    return serializedGrid.join("\n");
} */

onBeforeMount(() => {
    initializeGameBoard();
});

</script>

<style scoped>

.sudoku {
    grid-template-rows: repeat(var(--max-value), minmax(0, 1fr))
}

.sudoku  li {
    grid-template-columns: repeat(var(--max-value), minmax(0, 1fr))
}


</style>
