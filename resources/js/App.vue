<template>
    <div>
        <HeaderComponent />
        <router-view />
    </div>
</template>

<script>
import { defineComponent } from "vue";
import HeaderComponent from "./components/layouts/HeaderComponent";

export default defineComponent({
    name: "App",
    components: {
        HeaderComponent,
    },
});
</script>

<style></style>
