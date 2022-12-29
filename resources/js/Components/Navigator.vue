<script setup>
import { Link } from '@inertiajs/inertia-vue3';


  let props = defineProps({
    href: {
      type: String,
      required: true,
    },
    active: {
      type: Boolean,
      default: false,
    },
    text: {
      type: String,
      required: true,
    },
  });
</script>


<template>
  <Link :href="href"
    :class="{
      'bg-indigo-600 bg-opacity-75 text-white': active,
      'text-gray-300  hover:bg-opacity-75': !active,
    }"
    class="flex items-center px-2 py-2 text-sm font-medium duration-75 transform rounded-md transition-y-6 group">
    <slot name="icon" />
   {{ text }}
  </Link>
</template>