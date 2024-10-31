<script setup>
import {useAuthStore} from "@/stores/auth";
import {useTasksStore} from "@/stores/tasks";
import {storeToRefs} from "pinia";
import {onMounted, reactive, ref} from "vue";
import {useRoute, useRouter} from "vue-router";

const router = useRouter();
const route = useRoute();
const {user} = storeToRefs(useAuthStore());
const {errors} = storeToRefs(useTasksStore());
const {getTask, updateTask} = useTasksStore();

const task = ref(null);

const formData = reactive({
  title: "",
  text: "",
});
// console.log(task)
onMounted(async () => {
  const response = await getTask(route.params.id);
  task.value = response.task;
  if (task.value && task.value.user_id !== user.value.id) {
    router.push({name: "home"});
  } else {
    formData.title = task.value.title || "";
    formData.text = task.value.text || "";
  }
});

</script>

<template>
  <main>
    <h1 class="title">Изменить задачу</h1>

    <form
        @submit.prevent="updateTask(task, formData)"
        class="w-1/2 mx-auto space-y-6"
    >
      <div>
        <input
            type="text"
            placeholder="Задача"
            v-model="formData.title"
        />
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

      <button class="primary-btn">Изменить</button>
    </form>
  </main>
</template>
