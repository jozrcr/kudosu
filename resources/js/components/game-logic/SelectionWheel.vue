<template>
  <div
    class="absolute z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"
  >
    <ul
      ref="wheel"
      class="w-[6.25rem] sm:w-[7rem] md:w-32 lg:w-40 h-32 lg:h-40 rounded-full custom-circle relative flex items-center justify-center"
      @click="hideWheel()"
    >
      <li
        v-for="number in numbers"
        :key="number"
        class="select-none number-button absolute w-8 h-8 md:w-10 md:h-10 lg:w-12 lg:h-12 text-sm sm:text-base bg-white border border-gray-100 rounded-full cursor-pointer hover:bg-gray-200 ease-in-out duration-100 transition-all text-black flex items-center justify-center drop-shadow-sm shadow-md"
        @click="selectNumber(number)"
      >
        {{ number }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

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

const calculateWheelRadius = () => {
    const baseRadius = wheel.value.offsetWidth / 2
    const numButtons = props.maxValue

    // Additional radius for each button beyond 9
    const additionalRadiusPerButton = 10
    const radius =
        baseRadius +
        (numButtons > 9 ? (numButtons - 9) * additionalRadiusPerButton : 0)

    //PI/2 anti-rotation to place 1 on top
    const startAngle = -Math.PI / 2

    const buttons = wheel.value.querySelectorAll('.number-button')

    buttons.forEach((button, i) => {
        // Initially position the buttons at the center of the wheel
        button.style.left = '50%'
        button.style.top = '50%'
        button.style.transform = 'translate(-50%, -50%)'
        button.style.opacity = 0

        // Animate the movement of the buttons to their designated coordinates
        setTimeout(() => {
            const angle = startAngle + (i / numButtons) * 2 * Math.PI
            const x = Math.cos(angle) * radius
            const y = Math.sin(angle) * radius

            button.style.left = `calc(50% + ${x}px)`
            button.style.top = `calc(50% + ${y}px)`
            button.style.opacity = 1

            button.style.transition =
                'left 0.2s ease-out, top 0.2s ease-out, opacity 0.2s ease-out, scale 0.2s'
        }, 15 * i)
    })
}

onMounted(() => {
    calculateWheelRadius()
})
</script>
