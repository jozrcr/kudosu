<template>
  <picture>
    <source
      srcset='"/images/"+ image_src+ ".webp"'
      type="image/webp"
    >
    <source
      :srcset='"/images/"+ image_src+ ".png"'
      type="image/png"
    >
    <img
      class="w-48 sm:w-56 md:w-64 lg:w-72 2xl:w-96 h-auto object-contain pb-10 self-center"
      :alt="challengeType"
    >
  </picture>
  <p class="text-white lg:text-lg pb-6">
    Choose the game's difficulty
  </p>
  <ul class="grid grid-cols-1 gap-4 w-96 px-4 max-w-full">
    <li class="w-full flex items-center justify-center text-white font-bold text-xl lg:text-2xl bg-slate-600/50 hover:bg-slate-500/50 drop-shadow-md hover:shadow-md cursor-pointer transition-all duration-200 ease-in-out rounded-lg ">
      <router-link class="w-full h-full py-4 text-center" to="/play/daily/">
        Easy
      </router-link>
    </li>
    <li class="w-full flex items-center justify-center text-white font-bold text-xl lg:text-2xl bg-slate-600/50 hover:bg-slate-500/50 drop-shadow-md hover:shadow-md cursor-pointer transition-all duration-200 ease-in-out rounded-lg  ">
      <router-link class="w-full h-full py-4 text-center" to="/play/daily/">
        Classic
      </router-link>
    </li>
    <li class="w-full flex items-center justify-center text-white font-bold text-xl lg:text-2xl bg-slate-600/50 hover:bg-slate-500/50 drop-shadow-md hover:shadow-md cursor-pointer transition-all duration-200 ease-in-out rounded-lg ">
      <router-link class="w-full h-full py-4 text-center" to="/play/daily/">
        Hard
      </router-link>
    </li>
  </ul>
  <p class="text-white lg:text-lg pt-6  ">
    Easy = 4*4 grid<br>Classic = 9*9 grid<br>Hard = 16*16 grid
  </p>
</template>
  
<script setup>
  
import { computed, ref, onMounted } from 'vue'
import axios from 'axios';


const props = defineProps({
    challengeType: {
        type: String,
        required: true,
    },
})

const challenges = ref([]);

const image_src = computed(() => {
    if( props.challengeType == 'daily') return "daily-challenge-logo";

    return "random-challenges-logo";
});

const loadFromServer = () => {
    axios.get('/api/challenges/' + props.challengeType)
        .then((res) =>  {
            challenges.value = res.data;
            console.log(challenges.value)
        })
        .catch((error) => {
            console.error(error);
        });
}
onMounted(() => {
    loadFromServer();
});

</script>
  