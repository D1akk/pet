import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue'
import RegisterView from "../views/Auth/Register.vue";
import LoginView from "@/views/Auth/Login.vue";
import CreateView from "@/views/Tasks/Create.vue";
import ShowView from "@/views/Tasks/Show.vue";
import UpdateView from "@/views/Tasks/Update.vue";
import {useAuthStore} from "@/stores/auth.js";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/register',
            name: 'register',
            component: RegisterView,
            meta: {guest: true}
        },
        {
            path: '/login',
            name: 'login',
            component: LoginView,
            meta: {guest: true}
        },
        {
            path: "/create",
            name: "create",
            component: CreateView,
            meta: { auth: true },
        },
        {
            path: "/tasks/:id",
            name: "show",
            component: ShowView,
        },
        {
            path: "/tasks/update/:id",
            name: "update",
            component: UpdateView,
            meta: { auth: true },
        },
    ]
});

router.beforeEach(async (to, from) => {
    const authStore = useAuthStore();
    await authStore.getUser();

    if (authStore.user && to.meta.guest) {
        return { name: "home" };
    }

    if (!authStore.user && to.meta.auth) {
        return { name: "login" };
    }
});

export default router;
