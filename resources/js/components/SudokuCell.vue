<template>

    <div :class="cellClasses" @click.self="showSelectionWheel" v-click-away="onClickAway">
        {{ displayValue }}

        <SelectionWheel v-if="showWheel" :maxValue="maxValue" @select="handleNumberSelect" @hide="showSelectionWheel" />
    </div>

</template>

<script setup>
import { ref, computed, watch } from 'vue'

import SelectionWheel from './SelectionWheel.vue';

const props = defineProps({
    baseValue: {
        type: Number,
        default: 0,
    },
    currentValue: {
        type: Number
    },
    maxValue: {
        type: Number,
        required: true,
        default: 9
    }
})

const emit = defineEmits(['input']);

const showWheel = ref(false);

const displayValue = computed(() => {
     return props.baseValue || props.currentValue || '';
});

const cellClasses = computed(() => {
    return props.baseValue > 0
                ? 'select-none w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 lg:h-14 lg:w-14 xl:w-16 xl:h-16 2xl:w-20 2xl:h-20 aspect-square rounded-sm bg-white relative text-black text-lg lg:text-xl 2xl:text-2xl flex items-center justify-center'
                : 'select-none w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 lg:h-14 lg:w-14 xl:w-16 xl:h-16 2xl:w-20 2xl:h-20 aspect-square rounded-sm bg-white relative hover:bg-gray-100 ease-in-out duration-200 transition-all cursor-pointer text-gray-500 text-lg lg:text-xl 2xl:text-2xl  flex items-center justify-center'
});

const showSelectionWheel = () => {
    if( props.baseValue == 0) {
        showWheel.value = !showWheel.value;
    }
}

const handleNumberSelect = (number) => {
    emit('input', number);
    showWheel.value = false;
};

/*Uses vue3-click-away Node Package*/
const onClickAway = (event) => {
    showWheel.value = false;
}


</script>