<template>
    <div v-if="loaded" class="container mx-auto px-4 sm:px-6 lg:px-4 xl:px-6 pt-4 pb-4 sm:pb-6 lg:pb-4 xl:pb-6 space-y-4">
        <div class="flex flex-col items-start justify-start mb-10">
            <h2 class="text-lg leading-6 font-medium text-black">Friend invitations</h2>
            <table class="table-auto w-full text-left whitespace-no-wrap mt-3">
                <thead>
                <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">Username</th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">Email</th>
                    <th class="w-10 title-font text-center tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">Actions</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(invitation, idx) in friendInvitations" :key="idx">
                        <td class="px-4 py-3">{{ invitation.username }}</td>
                        <td class="px-4 py-3">{{ invitation.email }}</td>
                        <td class="w-40 text-center">
                            <button @click="acceptFriend(invitation.id)" class="rounded bg-green-500 text-white p-1">Accept</button>
                            <button @click="denyFriend(invitation.id)" class="ml-2 rounded bg-red-500 text-white p-1">Deny</button>
                        </td>
                    </tr>

                </tbody>
            </table>
            <div v-if="!friendInvitations.length" class="w-full bg-indigo-100 border border-indigo-500 text-indigo-700 px-4 py-3 rounded relative"
                 role="alert">
                <strong class="font-bold"><span class="block sm:inline">No invitations found 💁‍.</span></strong>
            </div>
        </div>
        <div class="flex flex-col items-start justify-start mt-6">
            <h2 class="text-lg leading-6 font-medium text-black">Todolist invitations</h2>
            <table class="table-auto w-full text-left whitespace-no-wrap mt-3">
                <thead>
                <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">Name</th>
                    <th class="w-10 title-font text-center tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(invitation, idx) in todolistsInvitations" :key="idx">
                    <td class="px-4 py-3">{{ invitation.name }}</td>
                    <td class="w-40 text-center">
                        <button @click="acceptTodolist(invitation.id)" class="rounded bg-green-500 text-white p-1">Accept</button>
                        <button @click="denyTodolist(invitation.id)" class="ml-2 rounded bg-red-500 text-white p-1">Deny</button>
                    </td>
                </tr>

                </tbody>
            </table>
            <div v-if="!todolistsInvitations.length" class="w-full bg-indigo-100 border border-indigo-500 text-indigo-700 px-4 py-3 rounded relative"
                 role="alert">
                <strong class="font-bold"><span class="block sm:inline">No invitations found 😈.</span></strong>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
    name: "Home",
    data() {
        return {
            friendInvitations: [],
            todolistsInvitations: [],
            loadedFriends: false,
            loadedTodolists: false
        }
    },
    computed: {
        loaded() {
            return (this.loadedFriends && this.loadedTodolists);
        }
    },
    methods: {
        getAllFriendsInvitations() {
            this.$store.dispatch('getAllFriendsInvitations').then(response => {
                this.friendInvitations = response.data.data;
                this.loadedFriends = true;
            })
        },
        getAllTodolistsInvitations() {
            this.$store.dispatch('getAllTodolistsInvitations').then(response => {
                this.todolistsInvitations = response.data.data;
                this.loadedTodolists = true;
            })
        },
        acceptFriend(id) {
            axios.post(`/api/friends/${id}/accept`).then(response => {
                window.notification(response.data.message, 'success');
                this.getAllFriendsInvitations();
            })
        },
        denyFriend(id) {
            axios.post(`/api/friends/${id}/deny`).then(response => {
                window.notification(response.data.message, 'success');
                this.getAllFriendsInvitations();
            })
        },
        acceptTodolist(id) {
            axios.post(`/api/todolists/${id}/accept`).then(response => {
                window.notification(response.data.message, 'success');
                this.getAllTodolistsInvitations();
            })
        },
        denyTodolist(id) {
            axios.post(`/api/todolists/${id}/deny`).then(response => {
                window.notification(response.data.message, 'success');
                this.getAllTodolistsInvitations();
            })
        }
    },
    mounted() {
        this.getAllFriendsInvitations();
        this.getAllTodolistsInvitations();
    }
});
</script>

<style></style>
