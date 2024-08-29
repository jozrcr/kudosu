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
    return props.baseValue > 0
        ? 'select-none w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 lg:h-14 lg:w-14 xl:w-16 xl:h-16 2xl:w-20 2xl:h-20 aspect-square rounded-sm bg-white relative text-black text-lg md:text-xl lg:text-2xl 2xl:text-3xl flex items-center justify-center'
        : 'select-none w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 lg:h-14 lg:w-14 xl:w-16 xl:h-16 2xl:w-20 2xl:h-20 aspect-square rounded-sm bg-white relative hover:bg-gray-100 ease-in-out duration-200 transition-colors cursor-pointer text-gray-500 text-lg md:text-xl lg:text-2xl 2xl:text-3xl  flex items-center justify-center'
})

const showSelectionWheel = () => {
    if (props.baseValue == 0) {
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
</style>
