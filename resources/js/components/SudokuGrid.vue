<template>

    <ul class=" bg-gray-500/50 p-1  rounded-lg max-w-7xl w-fit  h-fit grid grid-rows-9  gap-[0.1rem] md:gap-1 ">
        <li v-for="(row, rowIndex) in initialBoard" :key="rowIndex"  class="row grid grid-cols-9 gap-[0.1rem] md:gap-1 sudoku-grid place-content-center justify-items-center">
            <SudokuCell
                v-for="(cell, colIndex) in row"
                :key="colIndex"
                :baseValue="cell"
                :currentValue="board[rowIndex][colIndex]"
                :maxValue="maxValue"
                @input="updateCell(rowIndex, colIndex, $event)"
            />
        </li>
    </ul>

</template>

<script setup>
import { ref, computed } from 'vue'

import SudokuCell from './SudokuCell.vue';

/* Default to 9 for a standard 9x9 Sudoku grid, goal is to be able to select a different difficulty */
const maxValue = ref(9);

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
  [0, 0, 0, 0, 8, 0, 0, 7, 9]
];

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
  [0, 0, 0, 0, 8, 0, 0, 7, 9]
]);

const updateCell = (rowIndex, colIndex, value) => {
  board.value[rowIndex][colIndex] = value;
};

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

.sudoku-grid > div:nth-child(3n+1) {
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

.sudoku-grid > div:nth-child(3n+1) {
margin-left: 0.1rem;

}
} 



</style>