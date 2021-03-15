<template>
    <form
        class="container mx-auto flex flex-col justify-center mb-12"
        @submit.prevent="handleSubmit"
    >
        <div class="relative mb-4">
            <label for="name" class="leading-7 text-sm text-gray-600"
                >Name</label
            >
            <input
                type="text"
                id="name"
                name="name"
                v-model="todolist.name"
                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
            />
        </div>
        <button
            class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg"
        >
            Create
        </button>
    </form>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
    name: "TodolistFormComponent",
    data() {
        return {};
    },
    props: {
        todolist: {
            type: Object,
            required: true,
        },
        getAllTodolist: {
            type: Function,
            required: false,
        },
        closeForm: {
            type: Function,
            required: false,
        },
    },
    methods: {
        handleSubmit() {
            this.$store
                .dispatch("newTodolist", this.todolist)
                .then((response) => {
                    this.$emit("closeForm");
                    this.$emit("getAllTodolist");
                });
        },
    },
});
</script>

<style></style>
