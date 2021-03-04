<template>
    <div>
        <HeaderComponent />
        <div class="container mx-auto">
            <router-view />
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import HeaderComponent from "./components/layouts/HeaderComponent";

export default defineComponent({
    name: "App",
    methods: {},
    components: {
        HeaderComponent,
    },
});
</script>

<style></style>
