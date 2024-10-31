<script setup>
import {useTasksStore} from "@/stores/tasks.js";
import { storeToRefs } from "pinia";
import { reactive } from "vue";


const { errors } = storeToRefs(useTasksStore());
const { createTask } = useTasksStore();

const formData = reactive({
  title: "",
  text: "",
});
</script>

<template>
  <main>
    <h1 class="title">Создать задачу</h1>

    <form
        @submit.prevent="createTask(formData)"
        class="w-1/2 mx-auto space-y-6"
    >
      <div>
        <input type="text" placeholder="Задача" v-model="formData.title" />
        <p v-if="errors.title" class="error">{{ errors.title[0] }}</p>
      </div>

      <div>
        <textarea
            rows="6"
            placeholder="Опишите задачу"
            v-model="formData.text"
        ></textarea>
        <p v-if="errors.text" class="error">{{ errors.text[0] }}</p>
      </div>

      <button class="primary-btn">Создать</button>
    </form>
  </main>
</template>
