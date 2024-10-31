<script setup>
import { useTasksStore } from "@/stores/tasks.js";
import { onMounted, ref } from "vue";
import { RouterLink } from "vue-router";

const { getAllTasks} = useTasksStore();
const tasks = ref([]);

onMounted(async () => (tasks.value = await getAllTasks()));
</script>

<template>
  <main>
    <h1 class="title">Задачи</h1>

    <div v-if="tasks.length > 0">
      <div
          v-for="task in tasks"
          :key="task.id"
          class="border-l-4 border-blue-500 pl-4 mb-12"
      >
        <h2 class="font-bold text-3xl">{{ task.title }}</h2>
        <p class="text-xs text-slate-600 mb-4">
          Создатель {{ task.user.name }}
        </p>
        <p>
          {{ task.text }}
          <RouterLink
              :to="{ name: 'show', params: { id: task.id } }"
              class="text-blue-500 font-bold underline"
          >Подробнее...</RouterLink
          >
        </p>
      </div>
    </div>
    <div v-else>
      <h2 class="title">Нет задач</h2>
    </div>
  </main>
</template>
