<template>
    <div class="container mx-auto" v-if="loading">My Profile {{user.username}}</div>
</template>

<script>
import {defineComponent} from "vue";
import {mapGetters} from "vuex";

export default defineComponent({
    name: "Profile",
    data() {
        return {
            loading: false
        }
    },
    computed: {
        ...mapGetters(['user'])
    },
    mounted() {
        this.$store.dispatch('whoami').then(response => this.loading = true);
    }
});
</script>

<style scoped>

</style>
