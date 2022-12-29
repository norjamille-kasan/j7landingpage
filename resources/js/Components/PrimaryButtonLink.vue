<script setup>
import { Link } from '@inertiajs/inertia-vue3';
defineProps({
  type: {
    type: String,
    default: 'submit',
  },
  href: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <Link :href="href" :type="type"
    class="inline-flex items-center uppercase px-4 py-[10.5px] text-sm font-medium text-white bg-indigo-500 rounded-md hover:bg-indigo-600">
  <slot />
  </Link>
</template>
