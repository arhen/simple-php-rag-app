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
      <div id="googleButton"></div>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import { onMounted } from 'vue';

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

const handleCredentialResponse = (response) => {
  // Send the ID token to your server
  window.axios.post(route('auth.google'), {
    id_token: response.credential
  }).then(() => {
    window.location.href = route('upload.index');
  }).catch((error) => {
    console.error('Error during Google login:', error);
  });
};

onMounted(() => {
  // Load the Google Identity Services script
  const script = document.createElement('script');
  script.src = "https://accounts.google.com/gsi/client";
  script.async = true;
  script.defer = true;
  document.head.appendChild(script);

  script.onload = () => {
    window.google.accounts.id.initialize({
      client_id: import.meta.env.VITE_GOOGLE_CLIENT_ID,
      callback: handleCredentialResponse
    });
    window.google.accounts.id.renderButton(
      document.getElementById("googleButton"),
      { theme: "outline", size: "large" }
    );
  };
});

defineEmits(['showForgotPassword']);
</script>
