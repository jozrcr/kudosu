<template>
  <div
    v-click-away="onClickAway"
    :class="cellClasses"
    @click.self="showSelectionWheel"
    @contextmenu.prevent="emptyCell"
  >
    {{ displayValue }}

    <Transition name="fade">
      <SelectionWheel
        v-if="showWheel"
        :max-value="maxValue"
        @select="handleNumberSelect"
        @hide="showSelectionWheel"
        @empty="emptyCell"
      />
    </Transition>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

import SelectionWheel from './SelectionWheel.vue'

const props = defineProps({
    baseValue: {
        type: Number,
        default: 0,
    },
    currentValue: {
        type: Number,
        default: 0,
    },
    isBoardComplete: {
        type: Boolean,
        default: false
    },
    isError: {
        type: Boolean,
        default: false
    },
    maxValue: {
        type: Number,
        required: true,
        default: 9,
    },
})



const emit = defineEmits(['input', 'empty'])

const showWheel = ref(false)

const displayValue = computed(() => {
    return props.baseValue || props.currentValue || ''
})

const cellClasses = computed(() => {
    let classes = 'select-none aspect-square rounded-sm relative text-base sm:text-lg md:text-xl lg:text-2xl 2xl:text-3xl flex items-center justify-center';
    if (props.isBoardComplete && props.baseValue == 0){
        classes += ' bg-green-200 text-green-900 relative  ease-in-out duration-200 transition-colors'
    }
    else {
        if (!props.isError){
            classes += props.baseValue > 0
                ? ' bg-white text-black'
                : ' bg-white relative hover:bg-gray-100 ease-in-out duration-200 transition-colors cursor-pointer text-gray-500';
        }
        else {
            classes += props.baseValue > 0
                ? ' bg-white text-black'
                : ' bg-red-200 text-red-700 relative hover:bg-red-300 ease-in-out duration-200 transition-colors cursor-pointer';
        }
    }
    if(props.maxValue > 9) classes += ' sudoku-cell';
    else classes += ' w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 lg:h-14 lg:w-14 xl:w-16 xl:h-16 2xl:w-20 2xl:h-20';
    
    
    return classes;
})

const showSelectionWheel = () => {
    if (props.baseValue == 0 && !props.isBoardComplete) {
        showWheel.value = !showWheel.value
    }
}

const emptyCell = () => {
    if (props.baseValue == 0 && props.currentValue > 0) {
        emit('empty')
    }
}


const handleNumberSelect = (number) => {
    emit('input', number)
    showWheel.value = false
}

/*Uses vue3-click-away Node Package*/
const onClickAway = () => {
    showWheel.value = false
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease-in-out;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.sudoku-cell{
        width: 100%;
        height: 100%;
        padding: 0.1rem;
        min-width:1.35rem;
        min-height:1.35rem;
    }

@media only screen and (min-width: 640px) {
    .sudoku-cell{
        padding: 0.25rem;
        min-width:2rem;
    }
}

@media only screen and (min-width: 768px) {
    .sudoku-cell{
        padding: 0.25rem;
        min-width:2.5rem;
        min-height:2.5rem;
    }
}

@media only screen and (min-width: 1024px) {
    .sudoku-cell{
        min-width:3rem;
        min-height:3rem;
    }
}

@media only screen and (min-width: 1280px) {

}

@media only screen and (min-width: 1536px) {
    .sudoku-cell{
        padding: 0.25rem;
        min-width:3.3rem;
        min-height:3.3rem;
    }

}


</style>
