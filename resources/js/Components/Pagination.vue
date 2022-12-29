<script setup>
import { Link } from '@inertiajs/inertia-vue3'

defineProps({
  firstUrl: String,
  prevUrl: String,
  nextUrl: String,
  from: Number,
  to: Number,
  total: Number,
})
</script>

<template>
  <nav class="flex items-center justify-between px-4 py-3sm:px-6" aria-label="Pagination">
    <div class="hidden sm:block">
      <p class="text-sm text-gray-700">
        Showing
        <span class="font-medium">
          {{ from }}
        </span>
        to
        <span class="font-medium">
          {{ to }}
        </span>
        of
        <span class="font-medium">
          {{ total }}
        </span>
        results
      </p>
    </div>
    <div class="flex justify-between flex-1 sm:justify-end">
      <Component :href="prevUrl"  :is="prevUrl ? Link : 'span'"
        class="relative inline-flex items-center px-4 py-2 space-x-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
      </svg>

      <span> Previous</span>
      </Component>
      <Component :href="nextUrl" :is="nextUrl ? Link : 'span'"
        class="relative inline-flex items-center px-4 py-2 ml-3 space-x-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
      <span>Next</span>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
      </svg>
      </Component>
    </div>
  </nav>
</template>