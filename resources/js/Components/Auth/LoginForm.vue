now<template>
  <div>
    <h2 class="text-3xl font-bold mb-6 text-purple-400">Login</h2>
    <form @submit.prevent="login" class="space-y-4">
      <div>
        <label for="email" class="block text-sm font-medium mb-1 text-gray-300">Email</label>
        <input type="email" id="email" v-model="form.email"
               class="w-full px-3 py-2 bg-gray-800 rounded-md border border-gray-700 focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300"
               required>
        <p v-if="form.errors.email" class="mt-1 text-sm text-red-500">{{ form.errors.email }}</p>
      </div>
      <div>
        <label for="password" class="block text-sm font-medium mb-1 text-gray-300">Password</label>
        <input type="password" id="password" v-model="form.password"
               class="w-full px-3 py-2 bg-gray-800 rounded-md border border-gray-700 focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300"
               required>
        <p v-if="form.errors.password" class="mt-1 text-sm text-red-500">{{ form.errors.password }}</p>
      </div>
      <div class="flex items-center">
        <input type="checkbox" id="remember" v-model="form.remember" class="mr-2">
        <label for="remember" class="text-sm text-gray-300">Remember me</label>
      </div>
      <p v-if="form.errors.auth" class="text-sm text-red-500">{{ form.errors.auth }}</p>
      <Button type="submit" class="w-full py-2 text-lg" :disabled="form.processing">
        {{ form.processing ? 'Logging in...' : 'Login' }}
      </Button>
    </form>
    <div class="mt-4 text-center">
      <a href="#" @click.prevent="$emit('showForgotPassword')" class="text-sm text-purple-400 hover:text-purple-300">Forgot your password?</a>
    </div>
    <div class="mt-4">
      <Button @click="loginWithGoogle" class="w-full py-2 text-lg bg-white text-black hover:text-white hover:bg-gray-100 border border-gray-300">
        <div class="flex items-center justify-center">
          <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
          </svg>
          Login with Google
        </div>
      </Button>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const login = () => {
  form.post(route('login'), {
    onSuccess: () => {
      // Redirect or perform actions on successful login
    },
    onError: (errors) => {
      if (errors.email || errors.password) {
        // Handle specific field errors
      } else {
        // Handle general authentication error
        form.setError('auth', 'Invalid credentials. Please try again.');
      }
    },
    onFinish: () => {
      form.reset('password');
    },
  });
};

const loginWithGoogle = () => {
  window.location.href = route('auth.google');
};

defineEmits(['showForgotPassword']);
</script>
