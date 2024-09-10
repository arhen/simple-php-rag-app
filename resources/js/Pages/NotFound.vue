<template>
  <MainLayout>
    <div class="min-h-screen bg-black text-white flex items-center justify-center">
      <div class="text-center">
        <h1 class="text-6xl font-bold mb-4 text-purple-500 animate-fade-in-down">404</h1>
        <p class="text-2xl mb-8 animate-fade-in-up">Oops! Page not found</p>
        <p class="text-gray-400 mb-8 animate-fade-in-up">The page you are looking for doesn't exist or has been moved.</p>
        <Button @click="goHome" class="text-lg py-2 px-6">Go Home</Button>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import Button from '@/Components/Button.vue';

const goHome = () => {
  router.visit(route('welcome'));
};
</script>

<style scoped>
@keyframes fadeInDown {
  from { opacity: 0; transform: translateY(-20px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in-down {
  animation: fadeInDown 0.8s ease-out;
}

.animate-fade-in-up {
  animation: fadeInUp 0.8s ease-out;
}
</style>
