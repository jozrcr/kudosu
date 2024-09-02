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
  <div v-if="dataFetched">
    <SudokuGrid 
      :max-value="maxValue" 
      :initial-board="initialBoard"
    />
  </div>
  <div v-else>
    Loading
  </div>
</template>
<script setup>
import SudokuGrid from './SudokuGrid.vue'
import {  computed, onMounted, ref } from 'vue'
import axios from 'axios';

const props = defineProps({
    challengeType: {
        type: String,
        required: true,
    },

    difficulty: {
        type: String,
        required: true,
    }
})

const dataFetched = ref(false);

const challenge = ref([]);
const initialBoard = ref([]);

const maxValue = computed( () => {
    switch (props.difficulty) {
    case 'easy': return 4;
    case 'classic': return 9;
    case 'hard': return 16;
    default:
        return 9;
    }
});

const loadFromServer = () => {
    axios.get('/api/challenges/' + props.challengeType + '/' + maxValue.value)
        .then((res) =>  {
            challenge.value = res.data.data;
            console.log(challenge.value);
            decodeProblem();
            dataFetched.value = true;
        })
        .catch((error) => {
            console.error(error);
        });
}

const decodeProblem = () => {
    let encodedProblem = challenge.value['problem'];
    encodedProblem = encodedProblem.split("\n");

    let encodedArrayProblem = [];

    encodedProblem.forEach(line => {
        encodedArrayProblem.push(line.split(''))
    });

    decodeArray(encodedArrayProblem);

}

const decodeArray = (array) => {
    for (let i = 0; i < array.length; i++){
        for (let j=0; j < array.length; j++){
            array[i][j] = parseInt(array[i][j].charCodeAt(0) - 48);
        }
    }
    initialBoard.value = array;
}

onMounted(() => {
    loadFromServer();
});

</script>
