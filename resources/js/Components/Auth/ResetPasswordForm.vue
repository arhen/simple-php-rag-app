<template>
  <div>
    <h2 class="text-3xl font-bold mb-6 text-purple-400">Reset Password</h2>
    <form @submit.prevent="resetPassword" class="space-y-4">
      <div>
        <label for="email" class="block text-sm font-medium mb-1 text-gray-300">Email</label>
        <input type="email" id="email" v-model="form.email"
               class="w-full px-3 py-2 bg-gray-800 rounded-md border border-gray-700 focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300"
               required>
      </div>
      <div>
        <label for="password" class="block text-sm font-medium mb-1 text-gray-300">New Password</label>
        <input type="password" id="password" v-model="form.password"
               class="w-full px-3 py-2 bg-gray-800 rounded-md border border-gray-700 focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300"
               required>
      </div>
      <div>
        <label for="password_confirmation" class="block text-sm font-medium mb-1 text-gray-300">Confirm New Password</label>
        <input type="password" id="password_confirmation" v-model="form.password_confirmation"
               class="w-full px-3 py-2 bg-gray-800 rounded-md border border-gray-700 focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300"
               required>
      </div>
      <Button type="submit" class="w-full py-2 text-lg" :disabled="form.processing">Reset Password</Button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';

const form = useForm({
  email: '',
  password: '',
  password_confirmation: '',
  token: '',
});

const resetPassword = () => {
  form.post(route('password.update'), {
    onFinish: () => {
      form.reset('password', 'password_confirmation');
    },
  });
};
</script>
