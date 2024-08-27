<template>
    <li v-if="!baseValue" class="w-24 h-24 aspect-square bg-white border-gray-300 border hover:bg-gray-100 ease-in-out duration-200 transition-all" @click="pickNumber">
        {{ value || '' }}
    </li>

    <li v-else class="w-24 h-24 aspect-square bg-white border-gray-300 border">
        {{ baseValue || '' }}

    </li>
</template>

<script>
    export default {
        props : {
            baseValue: Number,
            value: {
                type: Number,
                default : 0
            },
        },
        methods: {
            pickNumber() {
                return
            }
        }
    }
</script>