<script setup>

let props = defineProps({
  title: {
    type: String,
    required: true,
  },
});

</script>
<template>
  <Teleport to="#pageTitle">
    <h1 class="text-2xl font-semibold text-gray-900">
      {{ title }}
    </h1>
  </Teleport>
</template>