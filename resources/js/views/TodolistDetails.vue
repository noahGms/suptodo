<template>
    <div>
        todolist {{$route.params.id}}
    </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    name: 'TodolistDetails',
    data() {
        return {
            todolist: null
        }
    },
    methods: {
        getTodolist() {
            this.$store.dispatch('getOneTodolist', this.$route.params.id).then(response => {
                this.todolist = response.data.data;
            }).catch(error => this.$router.push({name: 'todos'}))
        }
    },
    created() {
        this.getTodolist();
    }
})
</script>

<style scoped>

</style>
