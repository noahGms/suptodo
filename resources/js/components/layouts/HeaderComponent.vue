<template>
    <header class="text-gray-600 body-fontborder-b-2">
        <div
            class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center"
        >
            <router-link
                :to="{ name: 'home' }"
                class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"
                    ></path>
                </svg>
                <span class="ml-3 text-xl">Suptodo</span>
            </router-link>
            <template v-if="$store.getters.isLoggedIn">
                <nav
                    class="md:ml-auto flex flex-wrap items-center text-base justify-center"
                >
                    <router-link
                        :to="{ name: 'todos' }"
                        class="mr-5 hover:text-gray-900"
                        >Todo</router-link
                    >
                    <a class="mr-5 hover:text-gray-900">Friends</a>
                </nav>
                <button
                    class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0"
                    @click="logout"
                >
                    Logout
                    <svg
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        class="w-4 h-4 ml-1"
                        viewBox="0 0 24 24"
                    >
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </button>
            </template>
            <template v-else>
                <nav
                    class="md:ml-auto flex flex-wrap items-center text-base justify-center"
                >
                    <router-link
                        :to="{ name: 'login' }"
                        class="mr-5 hover:text-gray-900"
                        >Login</router-link
                    >
                    <router-link
                        :to="{ name: 'register' }"
                        class="mr-5 hover:text-gray-900"
                        >Register</router-link
                    >
                </nav>
            </template>
        </div>
    </header>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
    name: "HeaderComponent",
    data() {
        return {};
    },
    methods: {
        logout() {
            this.$store.dispatch("logout").then((response) => {
                this.$router.push({ name: "login" });
            });
        },
    },
});
</script>

<style></style>
