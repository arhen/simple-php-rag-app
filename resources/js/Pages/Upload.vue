<template>
  <MainLayout>
    <div class="min-h-screen bg-black text-white">
      <div class="container mx-auto px-4 py-16">
        <header class="text-center mb-16">
          <h1 class="text-5xl font-bold mb-4 animate-fade-in-down">Upload Document</h1>
          <p class="text-xl text-gray-400 max-w-2xl mx-auto animate-fade-in-up">
            Upload your PDF documents to enhance the RAG Chat experience.
          </p>
        </header>

        <div class="max-w-2xl mx-auto bg-gray-900 rounded-lg shadow-lg p-6">
          <form @submit.prevent="uploadDocument" class="space-y-6">
            <div>
              <label for="document" class="block text-sm font-medium text-gray-400 mb-2">Select PDF Document</label>
              <input
                type="file"
                id="document"
                ref="fileInput"
                @change="handleFileChange"
                accept="application/pdf"
                class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-500 file:text-white hover:file:bg-purple-600"
              />
            </div>
            <p v-if="flashMessage" :class="{'text-green-500': flashType === 'success', 'text-red-500': flashType === 'error'}" class="text-sm">
              {{ flashMessage }}
            </p>
            <Button type="submit" class="w-full" :disabled="!selectedFile || form.processing">
              {{ form.processing ? 'Uploading...' : 'Upload Document' }}
            </Button>
          </form>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import Button from '@/Components/Button.vue';

const fileInput = ref(null);
const selectedFile = ref(null);
const flashMessage = ref('');
const flashType = ref('');

const form = useForm({
  document: null,
});

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file && file.type === 'application/pdf') {
    selectedFile.value = file;
    form.document = file;
    form.clearErrors('document');
    flashMessage.value = '';
    flashType.value = '';
  } else {
    selectedFile.value = null;
    form.document = null;
    form.setError('document', 'Please select a valid PDF file.');
  }
};

const uploadDocument = () => {
  if (!selectedFile.value) {
    form.setError('document', 'Please select a PDF file to upload.');
    return;
  }

  form.post(route('upload.store'), {
    preserveScroll: true,
    onSuccess: (page) => {
      selectedFile.value = null;
      if (fileInput.value) {
        fileInput.value.value = '';
      }
      form.reset();
      if (page.props.flash.success) {
        flashMessage.value = page.props.flash.success;
        flashType.value = 'success';
      }
    },
    onError: (errors) => {
      flashMessage.value = errors.document || 'An error occurred during upload';
      flashType.value = 'error';
    },
  });
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
