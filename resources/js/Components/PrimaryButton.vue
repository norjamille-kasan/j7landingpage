<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-[10.5px] text-sm uppercase font-medium text-white bg-indigo-500 rounded-md hover:bg-indigo-600"
    >
        <slot />
    </button>
</template>
