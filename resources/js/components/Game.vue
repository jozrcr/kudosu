<template>
    <h1 class="text-black text-4xl">Kudosu Game</h1>
    <div class="bg-gradient-to-br from-blue-700 via-70% via-red-300 to-orange-400 w-screen h-screen flex flex-col items-center justify-center">
      <SudokuGrid />

    </div>
  </template>
  <script setup>

  import SudokuGrid from './SudokuGrid.vue';
  </script>