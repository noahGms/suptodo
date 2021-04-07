<template>
    <div class="w-screen">
        <HeaderComponent />
        <div :class="retrieveClass()">
            <router-view />
        </div>
        <NotificationComponent v-if="notification" :status="statusNotification" :message="messageNotification" @hideNotification="hideNotification" />
    </div>
</template>

<script>
import { defineComponent } from "vue";
import HeaderComponent from "./components/layouts/HeaderComponent";
import NotificationComponent from "./components/layouts/NotificationComponent";

export default defineComponent({
    name: "App",
    data() {
        return {
            notification: false,
            statusNotification: null,
            messageNotification: null
        }
    },
    components: {
        HeaderComponent,
        NotificationComponent
    },
    methods: {
        retrieveClass() {
            if (!this.$route.name) return;
            if (this.$route.name.includes('login') || this.$route.name.includes('register')) {
                return;
            } else {
                return 'custom-position mb-36';
            }
        },
        showNotification(message, status) {
            this.notification = true;
            this.statusNotification = status;
            this.messageNotification = message;
            setTimeout(() => {
                this.hideNotification();
            }, 3000);
        },
        hideNotification() {
            this.notification = false;
            this.statusNotification = null;
            this.messageNotification = null;
        }
    },
    mounted() {
        if(this.$store.getters.isLoggedIn) {
            this.$store.dispatch('whoami');
        }
    },
    created() {
        window.notification = ((message, status) => {
            this.showNotification(message, status);
        })
    }
});
</script>

<style scoped>
.custom-position {
    position: relative;
    top: 72px;
}
</style>
