<template>
  <button
    class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-700 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-purple-700 text-white hover:bg-purple-800 h-10 px-4 py-2 relative overflow-hidden group"
    :class="$attrs.class"
  >
    <span class="relative z-10">
      <slot></slot>
    </span>
    <span class="absolute inset-0 bg-purple-800 transform translate-x-full transition-transform duration-300 ease-out group-hover:translate-x-0"></span>
  </button>
</template>

<style scoped>
button::before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 100%;
  background-color: rgba(88, 28, 135, 0.2); /* Darker purple overlay */
  transition: left 0.3s ease;
}

button:hover::before {
  left: 0;
}

button:not(:hover)::before {
  transition: left 0.3s ease, opacity 0.3s ease;
  opacity: 0;
}
</style>
