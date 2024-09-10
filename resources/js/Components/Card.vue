<template>
  <div class="border border-gray-800 rounded-lg p-6 transition-all duration-300 hover:border-purple-500">
    <slot name="icon"></slot>
    <h3 class="text-xl font-semibold mb-2">{{ title }}</h3>
    <slot name="content"></slot>
  </div>
</template>

<script setup>
defineProps({
  title: String,
});
</script>
