<template>
  <div
    class="fixed lg:absolute z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/50 w-screen lg:w-fit lg:h-fit h-screen p-1 lg:rounded-3xl backdrop-blur-sm flex items-center justify-center"
  >
    <button
      class="absolute  top-4 right-4 p-2 w-10 h-10 lg:hidden"
      aria-label="close modal"
      @click="hideWheel()"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        class="fill-white"
      ><path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z" /></svg>
    </button>
    <ul
      ref="wheel"
      class="w-40 h-40  rounded-full content-evenly justify-items-center gap-1 grid custom-selection"
      :style="maxValueStyle"
      @click="hideWheel()"
    >
      <li
        v-for="number in numbers"
        :key="number"
        class="select-none  w-8 h-8 md:w-10 md:h-10 text-sm sm:text-base bg-white border border-gray-100 rounded-full cursor-pointer hover:bg-gray-200 ease-in-out duration-100 transition-all text-black flex items-center justify-center drop-shadow-sm shadow-md"
        @click="selectNumber(number)"
      >
        {{ number }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    maxValue: {
        type: Number,
        required: true,
        default: 9,
    },
})

const emit = defineEmits(['select', 'hide'])

// Could be used to translate to another dictionary
const numbers = computed(() => {
    return Array.from({ length: props.maxValue }, (_, i) => i + 1)
})

const hideWheel = () => {
    emit('hide')
}

const selectNumber = (number) => {
    emit('select', number)
}

const wheel = ref(null)

/* Value used in css to dynamically change the number of columns/rows needed to display the proper grid */
const maxValueStyle = computed(() => {

    return {
        '--rows-number': parseInt(Math.sqrt(props.maxValue)),
    };
});


</script>

<style scoped>

.custom-selection  {
    grid-template-columns: repeat(var(--rows-number), minmax(0, 1fr))
}

@media only screen and (min-width: 1024px) {
    .custom-selection{
        width: calc(4rem + 2rem * var(--rows-number));
        height: calc(4rem + 2rem * var(--rows-number));
    }
}

</style>
