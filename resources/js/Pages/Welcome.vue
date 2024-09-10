<template>
    <MainLayout>
        <div class="min-h-screen bg-black text-white">
            <div class="container mx-auto px-4 py-16">
                <header class="text-center mb-16">
                    <h1 class="text-5xl font-bold mb-4 animate-fade-in-down">Welcome to RAG Chat</h1>
                    <p class="text-xl text-gray-400 max-w-2xl mx-auto animate-fade-in-up">
                        Experience the power of Retrieval-Augmented Generation for more accurate and informative conversations.
                    </p>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
                    <div class="animate-slide-in-left">
                        <h2 class="text-3xl font-bold mb-4">What is RAG?</h2>
                        <p class="text-gray-400 mb-6">
                            RAG (Retrieval-Augmented Generation) is an AI framework that enhances language models by combining them with external knowledge retrieval. This approach allows the model to access and utilize up-to-date information, improving the accuracy and relevance of its responses.
                        </p>
                        <Button @click="startChat" class="text-lg py-2 px-6 group">Start Chatting</Button>
                    </div>
                    <div class="bg-gradient-to-br from-purple-500 to-pink-500 p-1 rounded-lg animate-slide-in-right">
                        <img src="/images/rag.webp" alt="RAG Diagram" class="w-full rounded-lg">
                    </div>
                </div>

                <TransitionGroup
                    name="feature-list"
                    tag="div"
                    class="grid grid-cols-1 md:grid-cols-3 gap-8"
                >
                    <Card
                        v-for="(feature, index) in features"
                        :key="feature.title"
                        :title="feature.title"
                        class="feature-item"
                        :style="{ animationDelay: `${index * 150}ms` }"
                    >
                        <template #icon>
                            <component :is="feature.icon" class="w-8 h-8 text-purple-500 mb-4" />
                        </template>
                        <template #content>
                            <p class="text-gray-400">{{ feature.content }}</p>
                        </template>
                    </Card>
                </TransitionGroup>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import Card from '@/Components/Card.vue';
import Button from '@/Components/Button.vue';
import { BookOpenIcon, ChatBubbleBottomCenterTextIcon, LightBulbIcon } from '@heroicons/vue/24/outline';
import { TransitionGroup } from 'vue';

const form = useForm({});

const features = ref([
    {
        title: 'Knowledge Retrieval',
        icon: BookOpenIcon,
        content: 'Access and utilize external information to enhance responses.',
    },
    {
        title: 'Improved Accuracy',
        icon: LightBulbIcon,
        content: 'Provide more precise and up-to-date answers by combining retrieved information.',
    },
    {
        title: 'Enhanced Conversations',
        icon: ChatBubbleBottomCenterTextIcon,
        content: 'Experience more engaging and informative AI-powered chats.',
    },
]);

const startChat = () => {
    router.visit(route('chat.index'));
};
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

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.animate-fade-in-down {
    animation: fadeInDown 0.8s ease-out;
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out;
}

.animate-slide-in-left {
    animation: slideInLeft 0.8s ease-out;
}

.animate-slide-in-right {
    animation: slideInRight 0.8s ease-out;
}

.feature-list-enter-active,
.feature-list-leave-active {
    transition: all 0.5s ease;
}

.feature-list-enter-from,
.feature-list-leave-to {
    opacity: 0;
    transform: translateY(30px);
}

.feature-item {
    animation: fadeInUp 0.8s ease-out forwards;
    opacity: 0;
}
</style>
