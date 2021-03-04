<template>
  <div>
    <form @submit.prevent="register">
      <input
        type="email"
        name="email"
        v-model="user.email"
        placeholder="Email"
        class="border-2"
      />
      <input
        type="text"
        name="username"
        v-model="user.username"
        placeholder="Username"
        class="border-2"
      />
      <input
        type="password"
        name="password"
        v-model="user.password"
        placeholder="Password"
        class="border-2"
      />
      <input
        type="password"
        name="password_confirmation"
        v-model="user.password_confirmation"
        placeholder="Password confirmation"
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
      user: {
        email: "",
        username: "",
        password: "",
        password_confirmation: "",
      },
    };
  },
  methods: {
    register() {
      this.$store.dispatch("register", this.user).then((response) => {
        this.$router.push({ name: "login" });
      });
    },
  },
});
</script>

<style></style>
