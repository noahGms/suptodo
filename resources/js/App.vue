<template>
    <div>
        <HeaderComponent />
        <div :class="retrieveClass()">
            <router-view />
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import HeaderComponent from "./components/layouts/HeaderComponent";
import {useRoute} from "vue-router"

export default defineComponent({
    name: "App",
    components: {
        HeaderComponent,
    },
    methods: {
        retrieveClass() {
            if (!this.$route.name) return;
            if (this.$route.name.includes('login') || this.$route.name.includes('register')) {
                return;
            } else {
                return 'custom-position';
            }
        }
    },
    mounted() {
        if(this.$store.getters.isLoggedIn) {
            this.$store.dispatch('whoami');
        }
    }
});
</script>

<style scoped>
.custom-position {
    position: relative;
    top: 72px;
}
</style>
