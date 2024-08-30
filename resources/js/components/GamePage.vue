<template>
  <picture>
    <source
      srcset="/images/kudosu_logo.webp"
      type="image/webp"
    >
    <source
      srcset="/images/kudosu_logo.png"
      type="image/png"
    >
    <img
      class="w-48 sm:w-56 md:w-64 lg:w-72 2xl:w-96 h-auto object-contain pb-10"
      alt="Kudosu logo"
    >
  </picture>
  <SudokuGrid />
</template>
<script setup>
import SudokuGrid from './SudokuGrid.vue'
</script>
