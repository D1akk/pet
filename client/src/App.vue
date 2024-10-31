<script setup>
import {RouterLink, RouterView} from 'vue-router'
import {useAuthStore} from "@/stores/auth.js";
import {onMounted} from "vue";

const authStore = useAuthStore()
onMounted(()=>{authStore.getUser()})
// console.log(authStore)
</script>

<template>
  <header>
    <nav>
      <RouterLink :to="{ name: 'home' }" class="nav-link">Главное</RouterLink>

      <div v-if="authStore.user" class="flex items-center space-x-6">
        <p class="text-sm text-slate-300">
          Приветствую, {{ authStore.user.name }}
        </p>
        <RouterLink :to="{ name: 'create' }" class="nav-link">
          Добавить задачу
        </RouterLink>
        <form @submit.prevent="authStore.logout">
          <button class="nav-link">Выйти</button>
        </form>
      </div>

      <div v-else class="space-x-6">
        <RouterLink :to="{ name: 'register' }" class="nav-link">
          Регистрация
        </RouterLink>
        <RouterLink :to="{ name: 'login' }" class="nav-link">
          Войти
        </RouterLink>
      </div>
    </nav>

  </header>

  <RouterView/>
</template>