<template>
    <div
        class="container mx-auto w-screen h-screen flex flex-col items-center justify-center"
    >
        <h1 class="text-2xl mb-3">Login</h1>
        <form class="flex flex-col justify-center" @submit.prevent="login">
            <div class="relative mb-4">
                <label for="email" class="leading-7 text-sm text-gray-600"
                    >Email</label
                >
                <input
                    type="email"
                    id="email"
                    name="email"
                    v-model="credentials.email"
                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                />
            </div>
            <div class="relative mb-4">
                <label for="password" class="leading-7 text-sm text-gray-600"
                    >Password</label
                >
                <input
                    type="password"
                    id="password"
                    name="password"
                    v-model="credentials.password"
                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                />
            </div>
            <button
                class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg"
            >
                Button
            </button>
        </form>
    </div>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
    name: "Login",
    data() {
        return {
            credentials: {
                email: null,
                password: null,
            },
        };
    },
    methods: {
        login() {
            this.$store.dispatch("login", this.credentials).then((response) => {
                this.$router.push({ name: "home" });
            });
        },
    },
});
</script>

<style></style>
