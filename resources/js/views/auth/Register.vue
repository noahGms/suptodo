<template>
    <div>
        <form @submit.prevent="register">
            <input
                type="email"
                name="email"
                v-model="credentials.email"
                class="border-2"
            />
            <input
                type="text"
                name="username"
                v-model="credentials.username"
                class="border-2"
            />
            <input
                type="password"
                name="password"
                v-model="credentials.password"
                class="border-2"
            />
            <input
                type="password"
                name="password_confirmation"
                v-model="credentials.password_confirmation"
                class="border-2"
            />
            <button type:submit>Register</button>
        </form>
    </div>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
    name: "Register",
    data() {
        return {
            credentials: {
                email: "",
                username: "",
                password: "",
                password_confirmation: "",
            },
        };
    },
    methods: {
        register() {
            this.$store
                .dispatch("register", this.credentials)
                .then((response) => {
                    console.log(response);
                    this.$router.push({ name: "home" });
                });
        },
    },
});
</script>

<style></style>
