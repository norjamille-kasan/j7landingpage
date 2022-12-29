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
    class="inline-flex items-center px-4 py-[10.5px] border border-gray-300 uppercase text-sm font-medium text-gray-700 bg-white rounded-md hover:bg-gray-50">
  <slot />
  </Link>
</template>
