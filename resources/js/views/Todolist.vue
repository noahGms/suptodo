<template>
    <div
        v-if="loaded"
        class="container mx-auto px-4 sm:px-6 lg:px-4 xl:px-6 pt-4 pb-4 sm:pb-6 lg:pb-4 xl:pb-6 space-y-4"
    >
        <TodolistFormComponent
            v-if="showForm"
            :todolist="todolist"
            @getAllTodolist="getAllTodolist"
            @closeForm="closeForm"
            :user="user"
        ></TodolistFormComponent>
        <div class="flex items-center justify-between">
            <h2 class="text-lg leading-6 font-medium text-black">Todolists</h2>
            <button
                @click="openForm"
                class="hover:bg-indigo-200 hover:text-indigo-800 group flex items-center rounded-md bg-indigo-100 text-indigo-600 text-sm font-medium px-4 py-2"
            >
                <i class="fas fa-plus group-hover:text-indigo-600 text-indigo-500 mr-2"></i>
                New
            </button>
        </div>
        <form class="relative" @submit.prevent="handleSearch">
            <i style="height: 20px; width: 20px;" class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input
                class="focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none w-full text-sm text-black placeholder-gray-500 border border-gray-200 rounded-md py-2 pl-10"
                type="text"
                aria-label="Filter projects"
                placeholder="Search todolist"
                v-model="searchQuery"
                @change="handleSearch"
            />
            <button type="button" v-if="searchQuery" @click="clearSearch">
                <i style="height: 20px; width: 20px;" class="fas fa-times absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </button>
        </form>
        <div v-if="todolists.length">
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
                        <div v-if="item.participants">
                            <img v-for="(participant, idx) in item.participants" class="inline object-cover w-8 h-8 rounded-full m-1" :src="'../storage/' + participant.profile_pic" alt="Profile image"/>
                        </div>
                    </a>
                </li>
                <!--<li class="hover:shadow-lg flex rounded-lg">
                    <button
                        @click="openForm"
                        class="hover:border-transparent hover:shadow-xs w-full flex items-center justify-center rounded-lg border-2 border-dashed border-gray-200 text-sm font-medium py-4"
                    >
                        New todolist
                    </button>
                </li>-->
            </ul>
        </div>
        <div v-else class="bg-indigo-100 border border-indigo-500 text-indigo-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold"><span class="block sm:inline">No todolists found.</span></strong>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import TodolistFormComponent from "../components/todolist/TodolistFormComponent";
import {formatQuery} from "../helpers/routes";
export default defineComponent({
    name: "Todolist",
    data() {
        return {
            showForm: false,
            todolist: null,
            searchQuery: '',
            loaded: false,
        };
    },
    computed: {
        todolists() {
            return this.$store.getters.getTodolists;
        },
        user() {
            return this.$store.getters.user;
        }
    },
    methods: {
        getAllTodolist(query = {}) {
            this.loaded = false;
            this.$store.dispatch('whoami');
            this.$store.dispatch("getAllTodolists", query).then(response => {
                this.loaded = true;
                this.$router.replace(formatQuery(query)).catch(() => {});
            });
        },
        openForm() {
            this.showForm = true;
            this.todolist = { name: "", participants: [] };
        },
        closeForm() {
            this.showForm = false;
            this.todolist = null;
        },
        handleSearch() {
            this.getAllTodolist({search: this.searchQuery});
        },
        clearSearch() {
            this.searchQuery = '';
            this.getAllTodolist();
        }
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
