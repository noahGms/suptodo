<template>
    <div
        class="container mx-auto w-screen custom-height flex flex-col items-center justify-center"
    >
        <h1 class="text-2xl mb-3">Register</h1>
        <form
            class="flex flex-col justify-center w-5/12"
            @submit.prevent="register"
        >
            <div class="relative mb-4">
                <label for="email" class="leading-7 text-sm text-gray-600"
                    >Email</label
                >
                <input
                    type="email"
                    id="email"
                    name="email"
                    v-model="user.email"
                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                />
            </div>
            <div class="relative mb-4">
                <label for="email" class="leading-7 text-sm text-gray-600"
                    >Username</label
                >
                <input
                    type="username"
                    id="username"
                    name="username"
                    v-model="user.username"
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
                    v-model="user.password"
                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                />
            </div>
            <div class="relative mb-4">
                <label for="password" class="leading-7 text-sm text-gray-600"
                    >Password</label
                >
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    v-model="user.password_confirmation"
                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                />
            </div>
            <div class="relative mb-4">
                <label for="profile_pic" class="leading-7 text-sm text-gray-600"
                    >Profile picture</label
                >
                <input
                    type="file"
                    id="profile_pic"
                    name="profile_pic"
                    @change="handleFile"
                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                />
            </div>
            <button
                class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg"
            >
                Register
            </button>
        </form>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import {uploadFile} from "../../helpers/requests";
export default defineComponent({
    name: "Register",
    data() {
        return {
            user: {
                email: "",
                username: "",
                password: "",
                password_confirmation: "",
                profile_pic: null
            },
        };
    },
    methods: {
        handleFile(e) {
            uploadFile(e.target.files[0]).then(response => {
                this.user.profile_pic = response.data.path;
            })
        },
        register() {
            this.$store.dispatch("register", this.user).then((response) => {
                window.notification(response.data.message, 'success');
                this.$router.push({ name: "login" });
            });
        },
    },
});
</script>

<style scoped>
.custom-height {
    height: 100vh;
}
</style>
