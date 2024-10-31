import { defineStore } from "pinia";
import { useAuthStore } from "./auth";

export const useTasksStore = defineStore("tasksStore", {
    state: () => {
        return {
            errors: {},
        };
    },
    actions: {
        /******************* Get all tasks *******************/
        async getAllTasks() {
            const token = localStorage.getItem("token");

            if (!token) {
                this.errors = { message: "User is not authenticated" };
                return;
            }

            const res = await fetch("/api/tasks", {
                headers: {
                    Authorization: `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
            });
            const data = await res.json();

            if (!res.ok) {
                this.errors = data.errors || { message: "Failed to fetch tasks" };
                throw new Error('Failed to fetch tasks');
            }

            return data;
        },

        /******************* Get a task *******************/
        async getTask(task) {
            const token = localStorage.getItem("token");

            if (!token) {
                this.errors = { message: "User is not authenticated" };
                return;
            }

            const res = await fetch(`/api/tasks/${task}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
            });
            const data = await res.json();

            if (!res.ok) {
                this.errors = data.errors || { message: "Failed to fetch task" };
                throw new Error('Failed to fetch task');
            }

            return data;
        },

        /******************* Create a task *******************/
        async createTask(formData) {
            const token = localStorage.getItem("token");

            if (!token) {
                this.errors = { message: "User is not authenticated" };
                return;
            }

            const res = await fetch("/api/tasks", {
                method: "post",
                headers: {
                    Authorization: `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
            });

            const data = await res.json();

            if (!res.ok) {
                this.errors = data.errors || { message: "Failed to create task" };
            } else {
                this.router.push({ name: "home" });
                this.errors = {};
            }
        },

        /******************* Delete a task *******************/
        async deleteTask(task) {
            const authStore = useAuthStore();
            const token = localStorage.getItem("token");

            if (!token) {
                this.errors = { message: "User is not authenticated" };
                return;
            }

            if (authStore.user.id === task.user_id) {
                const res = await fetch(`/api/tasks/${task.id}`, {
                    method: "delete",
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });

                const data = await res.json();
                if (res.ok) {
                    this.router.push({ name: "home" });
                } else {
                    this.errors = data.errors || { message: "Failed to delete task" };
                }
                // console.log(data);
            }
        },

        /******************* Update a task *******************/
        async updateTask(task, formData) {
            const authStore = useAuthStore();
            const token = localStorage.getItem("token");

            if (!token) {
                this.errors = { message: "User is not authenticated" };
                return;
            }

            if (authStore.user.id === task.user_id) {
                const res = await fetch(`/api/tasks/${task.id}`, {
                    method: "put",
                    headers: {
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData),
                });

                const data = await res.json();
                if (!res.ok) {
                    this.errors = data.errors || { message: "Failed to update task" };
                } else {
                    this.router.push({ name: "home" });
                    this.errors = {};
                }
            }
        },
    },
});
