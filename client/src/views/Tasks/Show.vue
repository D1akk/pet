<script setup>
import {useAuthStore} from "@/stores/auth";
import {useTasksStore} from "@/stores/tasks";
import {onMounted, ref} from "vue";
import {RouterLink, useRoute} from "vue-router";

const route = useRoute();
const {getTask, deleteTask} = useTasksStore();
const authStore = useAuthStore();
const task = ref(null);

onMounted(async () => {
  const response = await getTask(route.params.id);
  task.value = response.task;
});
console.log(task)
</script>

<template>
  <main>
    <div v-if="task">
      <div class="border-l-4 border-blue-500 pl-4 mt-12">
        <h2 class="font-bold text-3xl">{{ task.title }}</h2>
        <p class="text-xs text-slate-600 mb-4">
          Создатель {{ task.user.name }}
        </p>
        <p>
          {{ task.text }}
        </p>

        <div
            v-if="authStore.user && authStore.user.id === task.user_id"
            class="flex items-center gap-6 mt-6"
        >
          <form @submit.prevent="deleteTask(task)">
            <button
                class="text-red-500 font-bold px-2 py-1 border border-red-300"
            >
              Удалить
            </button>
          </form>

          <RouterLink
              :to="{ name: 'update', params: { id: task.id } }"
              class="text-green-500 font-bold px-2 py-1 border border-green-300"
          >Изменить
          </RouterLink
          >
        </div>
      </div>
    </div>
    <div v-else>
      <h2 class="title">Страница не найдена!</h2>
    </div>
  </main>
</template>
