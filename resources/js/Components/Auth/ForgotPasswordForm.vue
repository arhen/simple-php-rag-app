<template>
  <div>
    <h2 class="text-3xl font-bold mb-6 text-purple-400">Forgot Password</h2>
    <form @submit.prevent="forgotPassword" class="space-y-4">
      <div>
        <label for="email" class="block text-sm font-medium mb-1 text-gray-300">Email</label>
        <input type="email" id="email" v-model="form.email"
               class="w-full px-3 py-2 bg-gray-800 rounded-md border border-gray-700 focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300"
               required>
      </div>
      <Button type="submit" class="w-full py-2 text-lg" :disabled="form.processing">Send Reset Link</Button>
    </form>
    <div class="mt-4 text-center">
      <a href="#" @click.prevent="$emit('showLogin')" class="text-sm text-purple-400 hover:text-purple-300">Back to Login</a>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';

const form = useForm({
  email: '',
});

const forgotPassword = () => {
  form.post(route('password.email'), {
    onFinish: () => {
      form.reset('email');
    },
  });
};

defineEmits(['showLogin']);
</script>
