<template>

    <div :class="cellClasses" @click.self="showSelectionWheel">
        {{ displayValue }}

        <SelectionWheel v-if="showWheel" :maxValue="maxValue" @select="handleNumberSelect" />
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
                ? 'w-24 h-24 aspect-square rounded-sm bg-white relative text-black text-lg lg:text-xl 2xl:text-2xl flex items-center justify-center'
                : 'w-24 h-24 aspect-square rounded-sm bg-white relative hover:bg-gray-100 ease-in-out duration-200 transition-all cursor-pointer text-black text-lg lg:text-xl 2xl:text-2xl  flex items-center justify-center'
});

const showSelectionWheel = () => {
    if( props.baseValue == 0) {
        showWheel.value = true;
    }
}

const handleNumberSelect = (number) => {
    emit('input', number);
    showWheel.value = false;
};


</script>