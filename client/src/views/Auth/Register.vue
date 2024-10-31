<script setup>
import { useAuthStore } from "@/stores/auth";
import { storeToRefs } from "pinia";
import { onMounted, reactive } from "vue";

const { errors } = storeToRefs(useAuthStore());
const { authenticate } = useAuthStore();

const formData = reactive({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

onMounted(() => (errors.value = {}));
// console.log(errors.name)
</script>

<template>
  <main>
    <h1 class="title">Регистрация пользователя</h1>

    <form
        @submit.prevent="authenticate('register', formData)"
        class="w-1/2 mx-auto space-y-6"
    >
      <div>
        <input type="text" placeholder="ФИО" v-model="formData.name" />
        <p v-if="errors.name" class="error">{{ errors.name[0] }}</p>
      </div>

      <div>
        <input type="text" placeholder="Эл.почта" v-model="formData.email" />
        <p v-if="errors.email" class="error">{{ errors.email[0] }}</p>
      </div>

      <div>
        <input
            type="password"
            placeholder="Пароль"
            v-model="formData.password"
        />
        <p v-if="errors.password" class="error">{{ errors.password[0] }}</p>
      </div>

      <div>
        <input
            type="password"
            placeholder="Повторите пароль"
            v-model="formData.password_confirmation"
        />
      </div>

      <button class>Зарегистрироваться</button>
    </form>
  </main>
</template>