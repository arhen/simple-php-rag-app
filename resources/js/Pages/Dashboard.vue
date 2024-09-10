<template>
  <MainLayout>
    <div class="min-h-screen bg-black text-white">
      <div class="container mx-auto px-4 py-16">
        <header class="text-center mb-16">
          <h1 class="text-5xl font-bold mb-4 animate-fade-in-down">Admin Dashboard</h1>
          <p class="text-xl text-gray-400 max-w-2xl mx-auto animate-fade-in-up">
            Manage your RAG Chat application and view important statistics.
          </p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
          <Card v-for="stat in stats" :key="stat.title" :title="stat.title">
            <template #icon>
              <component :is="stat.icon" class="w-8 h-8 text-purple-500 mb-4" />
            </template>
            <template #content>
              <p class="text-3xl font-bold text-purple-400">{{ stat.value }}</p>
              <p class="text-gray-400">{{ stat.description }}</p>
            </template>
          </Card>
        </div>

        <div class="bg-gray-900 rounded-lg shadow-lg p-6">
          <h2 class="text-2xl font-bold mb-4">Recent Activity</h2>
          <div class="overflow-x-auto">
            <table class="w-full text-left">
              <thead>
                <tr>
                  <th class="pb-4 font-semibold text-gray-400">User</th>
                  <th class="pb-4 font-semibold text-gray-400">Action</th>
                  <th class="pb-4 font-semibold text-gray-400">Date</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="activity in recentActivity" :key="activity.id" class="border-t border-gray-800">
                  <td class="py-4">{{ activity.user }}</td>
                  <td class="py-4">{{ activity.action }}</td>
                  <td class="py-4">{{ activity.date }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import Card from '@/Components/Card.vue';
import { UsersIcon, ChatBubbleBottomCenterTextIcon, ClockIcon } from '@heroicons/vue/24/outline';

const stats = ref([
  { title: 'Total Users', value: '1,234', icon: UsersIcon, description: 'Registered users' },
  { title: 'Total Chats', value: '5,678', icon: ChatBubbleBottomCenterTextIcon, description: 'Conversations started' },
  { title: 'Avg. Response Time', value: '1.5s', icon: ClockIcon, description: 'Average AI response time' },
]);

const recentActivity = ref([
  { id: 1, user: 'John Doe', action: 'Started a new chat', date: '2023-05-01 14:30' },
  { id: 2, user: 'Jane Smith', action: 'Updated profile', date: '2023-05-01 13:45' },
  { id: 3, user: 'Bob Johnson', action: 'Logged in', date: '2023-05-01 12:15' },
  // Add more activity items as needed
]);
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
