<template>
    <div v-if="loaded" class="container mx-auto w-full mt-4 flex flex-col items-center">
        <div class="text-2xl uppercase">{{ todolist.name }}</div>
        <form class="flex mt-6 mb-6 w-full justify-center" @submit.prevent="addItem">
            <div class="relative w-2/3 text-gray-700">
                <input v-model="nameInput"
                       class="w-full h-10 pl-3 pr-8 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                       type="text" placeholder="Description"/>
                <button type="submit"
                        class="absolute inset-y-0 right-0 flex items-center px-4 font-bold text-white bg-indigo-500 rounded-r-lg hover:bg-indigo-500 focus:bg-indigo-700">
                    Add
                </button>
            </div>
        </form>
        <div v-if="todolist.items.length" class="lg:w-2/3 w-full mx-auto overflow-auto">
            <div class="mb-6 flex justify-center mx-auto flex-wrap">
                <button class="rounded p-2 text-white bg-indigo-500 mb-2" @click="showCompleted = !showCompleted">{{showCompleted ? 'Hide' : 'Show'}} completed</button>
                <button class="rounded p-2 text-white bg-indigo-500 ml-3 mb-2" @click="showIncompleted = !showIncompleted">{{showIncompleted ? 'Hide' : 'Show'}} incompleted</button>
                <button class="rounded p-2 text-white bg-indigo-500 ml-3 mb-2" @click="completeAll">Complete all item</button>
                <button class="rounded p-2 text-white bg-indigo-500 ml-3 mb-2" @click="incompleteAll">Incomplete all item</button>
                <button class="rounded p-2 text-white bg-indigo-500 ml-3 mb-2" @click="removeAllCompleted">Remove all item completed</button>
            </div>
            <table class="table-auto w-full whitespace-no-wrap">
                <thead>
                    <tr>
                        <th class="px-4 py-3 title-font text-left tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl">Description</th>
                        <th class="px-4 py-3 title-font text-center text-left tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">Completed</th>
                        <th colspan="2" class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="showIncompleted" class="mt-2 mb-2 text-2xl w-full text-center text-gray-900 bg-gray-100">
                        <td colspan="4">Incomplete</td>
                    </tr>
                    <tr v-if="showIncompleted" v-for="(item, idx) in todolist.items.filter(todolist => todolist.completed === 0)" :key="idx" class="hover:bg-gray-50 cursor-pointer" @click="changeStatus(item)">
                        <td class="px-4 py-3 text-lg text-gray-900">{{item.description}}</td>
                        <td class="px-4 py-3 text-lg text-center text-gray-900">
                            <span v-if="item.completed" class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-green-100 bg-green-600 rounded-full">
                                <i class="fas fa-check"></i>
                            </span>
                            <span v-else class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-gray-100 bg-gray-600 rounded-full">
                                <i class="fas fa-times"></i>
                            </span>
                        </td>
                        <td class="w-10 text-center ml-3">
                            <button @click.prevent.stop="updateItem(item)" class="p-2 text-indigo-500"><i class="fas fa-pencil-alt"></i></button>
                        </td>
                        <td class="w-10 text-center ml-3">
                            <button @click.prevent.stop="deleteItem(item)" class="p-2 text-red-500"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr v-if="showCompleted" class="mt-2 mb-2 text-2xl w-full text-center text-gray-900 bg-gray-100">
                        <td colspan="4">Complete</td>
                    </tr>
                    <tr v-if="showCompleted" v-for="(item, idx) in todolist.items.filter(item => item.completed === 1)" :key="idx" class="hover:bg-gray-50 cursor-pointer" @click="changeStatus(item)">
                        <td class="px-4 py-3 text-lg text-gray-900">{{item.description}}</td>
                        <td class="px-4 py-3 text-lg text-center text-gray-900">
                            <span v-if="item.completed" class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-green-100 bg-green-600 rounded-full">
                                <i class="fas fa-check"></i>
                            </span>
                            <span v-else class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-gray-100 bg-gray-600 rounded-full">
                                <i class="fas fa-times"></i>
                            </span>
                        </td>
                        <td class="w-10 text-center ml-3">
                            <button @click.prevent.stop="updateItem(item)" class="p-2 text-indigo-500"><i class="fas fa-pencil-alt"></i></button>
                        </td>
                        <td class="w-10 text-center ml-3">
                            <button @click.prevent.stop="deleteItem(item)" class="p-2 text-red-500"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="bg-indigo-100 w-2/3 border border-indigo-500 text-indigo-700 px-4 py-3 rounded relative"
             role="alert">
            <strong class="font-bold"><span class="block sm:inline">No item found 🤔.</span></strong>
        </div>
        <EditTodoItemComponent
            v-if="showEditTodoItemComponent"
            @close="closeEditTodoItemComponent"
            :item="item"
            :todolist="todolist"
            @getTodolist="getTodolist"
        ></EditTodoItemComponent>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import EditTodoItemComponent from "../components/todolist/EditTodoItemComponent";

export default defineComponent({
    name: 'TodolistDetails',
    data() {
        return {
            todolist: null,
            loaded: false,
            nameInput: "",
            showCompleted: true,
            showIncompleted: true,
            showEditTodoItemComponent: false,
            item: {}
        }
    },
    computed: {
        user() {
            return this.$store.getters.user;
        }
    },
    methods: {
        getTodolist() {
            this.loaded = false;
            this.$store.dispatch('getOneTodolist', this.$route.params.id).then(response => {
                this.todolist = response.data.data;
                this.loaded = true;
            }).catch(error => this.$router.push({name: 'todos'}))
        },
        addItem() {
            axios.post(`/api/todolists/${this.todolist.id}/items`, {description: this.nameInput})
                .then(response => {
                    this.nameInput = "";
                    this.getTodolist();
                })
        },
        deleteItem(item) {
            if (!confirm('Are you sure?')) return;
            axios.delete(`/api/todolists/${this.todolist.id}/items/${item.id}`)
                .then(response => {
                    this.getTodolist();
                })
        },
        updateItem(item) {
            console.log('updating...');
            this.showEditTodoItemComponent = true;
            this.item = item;
        },
        closeEditTodoItemComponent() {
            this.showEditTodoItemComponent = false;
            this.item = {};
        },
        changeStatus(item) {
            axios.post(`/api/todolists/${this.todolist.id}/items/${item.id}/status`)
            .then(response => {
                this.getTodolist();
            })
        },
        completeAll() {
            axios.post(`/api/todolists/${this.todolist.id}/completeAll`)
            .then(response => {
                this.getTodolist();
            })
        },
        incompleteAll() {
            axios.post(`/api/todolists/${this.todolist.id}/incompleteAll`)
                .then(response => {
                    this.getTodolist();
                })
        },
        removeAllCompleted() {
            axios.post(`/api/todolists/${this.todolist.id}/removeAllCompleted`)
            .then(response => {
                this.getTodolist();
            })
        }
    },
    created() {
        this.getTodolist();
    },
    components: {
        EditTodoItemComponent
    }
})
</script>

<style scoped>
</style>
