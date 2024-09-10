<template>
  <div class="min-h-screen bg-gray-100 hide-scrollbar">
    <header
      class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
      :class="[
        isScrolled ? 'bg-gray-900 bg-opacity-90 shadow-md' : 'bg-transparent',
        isScrolled ? 'py-2' : 'py-4'
      ]"
    >
      <div class="container mx-auto px-4">
        <div
          class="flex justify-between items-center transition-all duration-300"
          :class="{ 'border-gradient': !isScrolled }"
        >
          <Link :href="route('welcome')" class="text-2xl font-bold text-purple-500 transition-all duration-300"
               :class="{ 'text-xl': isScrolled }">
            RAG Chat
          </Link>
          <nav>
            <ul class="flex space-x-6">
              <li>
                <Link :href="route('welcome')" class="text-gray-300 hover:text-purple-400 transition-colors">Home</Link>
              </li>
              <template v-if="$page.props.auth.user">
                <template v-if="$page.props.auth.user.role === 'admin'">
                  <li>
                    <Link :href="route('dashboard')" class="text-gray-300 hover:text-purple-400 transition-colors">Dashboard</Link>
                  </li>
                </template>
                <template v-else>
                  <li>
                    <Link :href="route('upload.index')" class="text-gray-300 hover:text-purple-400 transition-colors">Upload</Link>
                  </li>
                  <li>
                    <Link :href="route('chat.index')" class="text-gray-300 hover:text-purple-400 transition-colors">Chat</Link>
                  </li>
                </template>
                <li>
                  <Link :href="route('logout')" method="post" as="button" class="text-gray-300 hover:text-purple-400 transition-colors">
                    Logout
                  </Link>
                </li>
              </template>
              <li v-else>
                <button @click="showAuthModal = true" class="text-gray-300 hover:text-purple-400 transition-colors">
                  Login
                </button>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </header>

    <main>
      <slot></slot>
    </main>

    <!-- Auth Modal -->
    <Transition name="modal">
      <div v-if="showAuthModal"
           class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-gray-900 p-8 rounded-2xl shadow-lg w-96 max-w-[90%] transform transition-all duration-300 relative"
             :class="{ 'scale-100 opacity-100': showAuthModal, 'scale-95 opacity-0': !showAuthModal }">

          <!-- Close button -->
          <button @click="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors duration-300 focus:outline-none">
            <span class="sr-only">Close</span>
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>

          <LoginForm v-if="currentAuthView === 'login'" @showForgotPassword="currentAuthView = 'forgotPassword'" />
          <ForgotPasswordForm v-if="currentAuthView === 'forgotPassword'" @showLogin="currentAuthView = 'login'" />
          <ResetPasswordForm v-if="currentAuthView === 'resetPassword'" />
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import LoginForm from '@/Components/Auth/LoginForm.vue';
import ForgotPasswordForm from '@/Components/Auth/ForgotPasswordForm.vue';
import ResetPasswordForm from '@/Components/Auth/ResetPasswordForm.vue';

const showAuthModal = ref(false);
const currentAuthView = ref('login');
const isScrolled = ref(false);

const closeModal = () => {
  showAuthModal.value = false;
  currentAuthView.value = 'login';
};

const handleScroll = () => {
  isScrolled.value = window.scrollY > 20;
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>

<style scoped>
.border-gradient {
  position: relative;
  padding-bottom: 4px;
}

.border-gradient::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  width: 100%;
  height: 1px;
  background: linear-gradient(to right, transparent, rgba(107, 114, 128, 0.3), transparent);
}

.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

button:focus-visible {
  outline: 2px solid theme('colors.purple.500');
  outline-offset: 2px;
}

button svg {
  transition: transform 0.3s ease;
}

button:hover svg {
  transform: rotate(90deg);
}
</style>

<style>
/* Global styles */
html, body {
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* Internet Explorer 10+ */
}

html::-webkit-scrollbar,
body::-webkit-scrollbar {
  width: 0;
  height: 0;
  display: none; /* Chrome, Safari, and Opera */
}

.hide-scrollbar {
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* Internet Explorer 10+ */
}

.hide-scrollbar::-webkit-scrollbar {
  width: 0;
  height: 0;
  display: none; /* Chrome, Safari, and Opera */
}
</style>
