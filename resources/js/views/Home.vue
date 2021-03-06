<template>
    <div class="mt-4">
        <h1>Home</h1>
        <button @click="$store.dispatch('whoami')">whoami</button>
        <p>{{ $store.getters.user }}</p>
    </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
    name: "Home",
});
</script>

<style></style>
