<template>
    <div>
        <HeaderComponent />
        <div class="mt-3">
            <router-view />
        </div>
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
