<template>
  <MainLayout>
    <div class="min-h-screen bg-black text-white">
      <div class="container mx-auto px-4 py-16">
        <header class="text-center mb-16">
          <h1 class="text-5xl font-bold mb-4 animate-fade-in-down">RAG Chat</h1>
          <p class="text-xl text-gray-400 max-w-2xl mx-auto animate-fade-in-up">
            Experience intelligent conversations powered by Retrieval-Augmented Generation.
          </p>
        </header>

        <div class="max-w-4xl mx-auto bg-gray-900 rounded-lg shadow-lg p-6">
          <div class="h-96 overflow-y-auto mb-6 space-y-4 scroll-smooth hide-scrollbar" ref="chatContainer">
            <TransitionGroup name="fade-slide">
              <div v-for="(message, index) in messages" :key="index"
                   :class="['p-3 rounded-lg',
                     message.isUser ? 'bg-purple-700 ml-auto fade-slide-right' :
                     message.isError ? 'bg-red-900 border border-red-500 fade-slide-left text-sm' :
                     'bg-gray-800 fade-slide-left']"
                   :style="{ maxWidth: message.isError ? '60%' : '80%' }">
                <template v-if="message.isLoading">
                  <div class="flex items-center space-x-1">
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                  </div>
                </template>
                <template v-else>
                  <div v-for="(line, lineIndex) in splitMessageContent(message.content)" :key="lineIndex">
                    {{ line }}
                  </div>
                </template>
              </div>
            </TransitionGroup>
          </div>

          <div v-if="errorMessage" class="text-red-500 text-sm mb-4">
            {{ errorMessage }}
          </div>

          <form @submit.prevent="sendMessage" class="flex items-center space-x-2">
            <input
              v-model="userInput"
              type="text"
              placeholder="Type your message..."
              class="flex-grow bg-gray-800 text-white rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
              :disabled="isWaitingForResponse"
            />
            <Button type="submit" class="px-3 py-2 flex-shrink-0 bg-purple-600 hover:bg-purple-700 focus:ring-purple-500" :disabled="isWaitingForResponse">
              <i class="pi pi-send"></i>
            </Button>
            <Button @click="clearChat" type="button" class="px-3 py-2 flex-shrink-0 bg-gray-600 hover:bg-gray-700 focus:ring-gray-500" :disabled="isWaitingForResponse">
              <i class="pi pi-trash"></i>
            </Button>
          </form>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import Button from '@/Components/Button.vue';
import { router } from '@inertiajs/vue3';
import 'primeicons/primeicons.css';

const userInput = ref('');
const messages = ref([
  { content: "Welcome to RAG Chat! How can I assist you today?", isUser: false, role: 'assistant' },
]);
const chatContainer = ref(null);
const isWaitingForResponse = ref(false);
const errorMessage = ref('');

const sendMessage = async () => {
  if (userInput.value.trim() === '' || isWaitingForResponse.value) return;

  const userMessage = userInput.value;
  messages.value.push({ content: userMessage, isUser: true, role: 'user' });
  userInput.value = '';
  isWaitingForResponse.value = true;

  scrollToBottom();

  // Wait 200ms before showing the thinking indicator
  await new Promise(resolve => setTimeout(resolve, 200));

  // Show thinking indicator immediately
  messages.value.push({ isLoading: true, isUser: false, role: 'assistant' });
  scrollToBottom();

  // Wait 500ms before sending the request
  await new Promise(resolve => setTimeout(resolve, 500));

  // Reset error message before sending a new message
  errorMessage.value = '';

  // Prepare the chat history
  const chatHistory = messages.value
    .filter(msg => !msg.isLoading && !msg.isError)
    .map(msg => ({ role: msg.role, content: msg.content }));

  // Send the request using Inertia
  router.post('/chat', { chat: chatHistory }, {
    preserveState: true,
    preserveScroll: true,
    onSuccess: (response) => {
        console.log(response);
      // Remove the loading indicator
      messages.value.pop();
      // Add the AI response to the messages
      messages.value.push({ content: response.props.response, isUser: false, role: 'assistant' });
      isWaitingForResponse.value = false;
      scrollToBottom();
    },
    onError: (errors) => {
      // Remove the loading indicator
      messages.value.pop();
      // Add the error message as a smaller red bubble
      messages.value.push({
        content: "An error occurred. Please try again later.",
        isUser: false,
        isError: true,
        role: 'assistant'
      });
      isWaitingForResponse.value = false;
      scrollToBottom();
      console.error(errors);
    }
  });
};

const scrollToBottom = () => {
  nextTick(() => {
    if (chatContainer.value) {
      chatContainer.value.scrollTo({
        top: chatContainer.value.scrollHeight,
        behavior: 'smooth'
      });
    }
  });
};

const clearChat = () => {
  messages.value = [
    { content: "Welcome to RAG Chat! How can I assist you today?", isUser: false, role: 'assistant' },
  ];
  errorMessage.value = '';
  scrollToBottom();
};

const splitMessageContent = (content) => {
  return content.split('\n').filter(line => line.trim() !== '');
};

onMounted(() => {
  scrollToBottom();
});
</script>

<style scoped>
@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in-down {
  animation: fadeInDown 0.8s ease-out;
}

.animate-fade-in-up {
  animation: fadeInUp 0.8s ease-out;
}

.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease;
}

.fade-slide-enter-from.fade-slide-left,
.fade-slide-leave-to.fade-slide-left {
  opacity: 0;
  transform: translateX(-20px);
}

.fade-slide-enter-from.fade-slide-right,
.fade-slide-leave-to.fade-slide-right {
  opacity: 0;
  transform: translateX(20px);
}

.fade-slide-enter-to,
.fade-slide-leave-from {
  opacity: 1;
  transform: translateX(0);
}

/* Add this new style for proper spacing between lines */
.fade-slide-left > div,
.fade-slide-right > div {
  margin-bottom: 0.5rem;
}

.fade-slide-left > div:last-child,
.fade-slide-right > div:last-child {
  margin-bottom: 0;
}

.scroll-smooth {
  scroll-behavior: smooth;
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
