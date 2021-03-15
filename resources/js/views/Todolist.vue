<template>
    <div
        class="px-4 sm:px-6 lg:px-4 xl:px-6 pt-4 pb-4 sm:pb-6 lg:pb-4 xl:pb-6 space-y-4"
    >
        <TodolistFormComponent
            v-if="showForm"
            :todolist="todolist"
            @getAllTodolist="getAllTodolist"
            @closeForm="closeForm"
        ></TodolistFormComponent>
        <header class="flex items-center justify-between">
            <h2 class="text-lg leading-6 font-medium text-black">Todolists</h2>
            <button
                @click="openForm"
                class="hover:bg-indigo-200 hover:text-indigo-800 group flex items-center rounded-md bg-indigo-100 text-indigo-600 text-sm font-medium px-4 py-2"
            >
                <svg
                    class="group-hover:text-indigo-600 text-indigo-500 mr-2"
                    width="12"
                    height="20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M6 5a1 1 0 011 1v3h3a1 1 0 110 2H7v3a1 1 0 11-2 0v-3H2a1 1 0 110-2h3V6a1 1 0 011-1z"
                    />
                </svg>
                New
            </button>
        </header>
        <form class="relative">
            <svg
                width="20"
                height="20"
                fill="currentColor"
                class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
            >
                <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                />
            </svg>
            <input
                class="focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none w-full text-sm text-black placeholder-gray-500 border border-gray-200 rounded-md py-2 pl-10"
                type="text"
                aria-label="Filter projects"
                placeholder="Search todolist"
            />
        </form>
        <ul
            class="grid grid-cols-1 md:grid-cols-2 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2 gap-4"
        >
            <li v-for="(item, idx) in todolists" :key="idx" @click="$router.push({name: 'todo', params: {id: item.id}})">
                <a
                    class="hover:bg-indigo-500 hover:border-transparent hover:shadow-lg group block rounded-lg p-4 border border-gray-200"
                >
                    <dl
                        class="grid sm:block lg:grid xl:block grid-cols-2 grid-rows-2 items-center"
                    >
                        <div>
                            <dt class="sr-only">Title</dt>
                            <dd
                                class="group-hover:text-white leading-6 font-medium text-black"
                            >
                                {{ item.name }}
                            </dd>
                        </div>
                    </dl>
                </a>
            </li>
            <li class="hover:shadow-lg flex rounded-lg">
                <button
                    @click="openForm"
                    class="hover:border-transparent hover:shadow-xs w-full flex items-center justify-center rounded-lg border-2 border-dashed border-gray-200 text-sm font-medium py-4"
                >
                    New todolist
                </button>
            </li>
        </ul>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import TodolistFormComponent from "../components/todolist/TodolistFormComponent";
export default defineComponent({
    name: "Todolist",
    data() {
        return {
            showForm: false,
            todolist: null,
        };
    },
    computed: {
        todolists() {
            return this.$store.getters.getTodolists;
        },
    },
    methods: {
        getAllTodolist() {
            this.$store.dispatch("getAllTodolists");
        },
        openForm() {
            this.showForm = true;
            this.todolist = { name: "" };
        },
        closeForm() {
            this.showForm = false;
            this.todolist = null;
        },
    },
    created() {
        this.getAllTodolist();
    },
    components: {
        TodolistFormComponent,
    },
});
</script>

<style scoped></style>