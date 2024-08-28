<template>

    <div class="absolute z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 ">
        <div class="w-[6.5rem] md:w-32 lg:w-40 h-32 lg:h-40 rounded-full  custom-circle relative flex items-center justify-center" ref="wheel" @click="hideWheel()">
            <div v-for="number in numbers" :key="number"  class="select-none number-button absolute w-8 h-8 md:w-10 md:h-10 lg:w-12 lg:h-12 text-sm sm:text-base bg-white border border-gray-100 rounded-full cursor-pointer hover:bg-gray-200 ease-in-out duration-100 transition-all text-black flex items-center justify-center drop-shadow-sm shadow-md" @click="selectNumber(number)">
                {{ number }}
            </div>
        </div>
    </div>

</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

const props = defineProps({
    maxValue: {
        type: Number,
        required: true,
        default: 9
    }
})

const emit = defineEmits(['select', 'hide']);

/* Could be used to translate to another dictionary */
const numbers = computed(() => {
  return Array.from({ length: props.maxValue }, (_, i) => i + 1);
});

const hideWheel = () => {
    emit('hide');
}

const selectNumber = (number) => {
    emit('select', number);
}

const wheel = ref(null);


const calculateWheelRadius = () => {
    const baseRadius = wheel.value.offsetWidth / 2; // Radius of the circle where buttons will be placed
    const numButtons = props.maxValue; // Number of buttons

    // Calculate the radius based on the number of buttons
    const additionalRadiusPerButton = 10; // Additional radius for each button beyond 9
    const radius = baseRadius + (numButtons > 9 ? (numButtons - 9) * additionalRadiusPerButton : 0);

    const startAngle = -Math.PI / 2; // Start angle to rotate the wheel

    const buttons = wheel.value.querySelectorAll('.number-button');
    buttons.forEach((button, i) => {
        const angle = startAngle + (i / numButtons) * 2 * Math.PI;
        const x = Math.cos(angle) * radius;
        const y = Math.sin(angle) * radius;

        button.style.left = `calc(50% + ${x}px)`;
        button.style.top = `calc(50% + ${y}px)`;
        button.style.transform = 'translate(-50%, -50%)';
    });
}

onMounted(() => {
    calculateWheelRadius();
    
});



   
</script>
