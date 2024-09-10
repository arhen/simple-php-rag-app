<template>
    <MainLayout>
        <div class="min-h-screen flex items-center justify-center bg-black">
            <div class="bg-gray-900 p-8 rounded-2xl shadow-lg max-w-md w-full">
                <h2 class="text-3xl font-bold mb-6 text-purple-400">Verify Your Email</h2>
                <p class="text-gray-300 mb-6">
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                </p>
                <div v-if="verificationLinkSent" class="mb-4 text-sm text-green-400">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
                <form @submit.prevent="submit">
                    <div class="flex items-center justify-between">
                        <Button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Resend Verification Email
                        </Button>
                        <Button type="button" @click="logout" class="ml-4">Log Out</Button>
                    </div>
                </form>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import Button from '@/Components/Button.vue';

const props = defineProps({
    status: String,
});

const form = useForm({});
const verificationLinkSent = computed(() => props.status === 'verification-link-sent');

const submit = () => {
    form.post(route('verification.send'));
};

const logout = () => {
    form.post(route('logout'));
};
</script>
