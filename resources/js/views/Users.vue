<template>
    <div v-if="loaded" class="container mx-auto px-4 sm:px-6 lg:px-4 xl:px-6 pt-4 pb-4 sm:pb-6 lg:pb-4 xl:pb-6 space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg leading-6 font-medium text-black">Users</h2>
        </div>
        <form class="relative" @submit.prevent="handleSearch">
            <i style="height: 20px; width: 20px;" class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input
                class="focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none w-full text-sm text-black placeholder-gray-500 border border-gray-200 rounded-md py-2 pl-10"
                type="text"
                aria-label="Filter projects"
                placeholder="Search user"
                v-model="searchQuery"
                @change="handleSearch"
            />
            <button type="button" v-if="searchQuery" @click="clearSearch">
                <i style="height: 20px; width: 20px;" class="fas fa-times absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </button>
        </form>
        <div v-if="users.length">
            <div class="flex flex-wrap -m-4">
                <div class="p-4 lg:w-1/3 w-full" v-for="(user, idx) in users" :key="idx">
                    <div class="flex rounded-lg h-full bg-gray-100 p-8 flex-col">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 mr-3 inline-flex items-center justify-center rounded-full bg-indigo-500 text-white flex-shrink-0">
                                <img v-if="user.profile_pic" class="inline object-cover w-8 h-8 rounded-full m-1" :src="'../storage/' + user.profile_pic" alt="Profile image"/>
                            </div>
                            <h2 class="text-gray-900 text-lg title-font font-medium">{{user.username}}</h2>
                        </div>
                        <div class="flex items-center flex-wrap justify-between mt-3" v-if="showAddButton(user)">
                            <div>
                                <button class="hover:bg-indigo-200 hover:text-indigo-800 group flex items-center rounded-md bg-indigo-100 text-indigo-600 text-sm font-medium px-4 py-2" @click="addFriend(user)">Add as friend <i class="ml-2 fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="flex items-center flex-wrap justify-between mt-3" v-else>
                            <div>
                                <button class="group flex items-center rounded-md bg-gray-500 text-gray-200 text-sm font-medium px-4 py-2">Already in friend</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="bg-indigo-100 border border-indigo-500 text-indigo-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold"><span class="block sm:inline">No users found 🧐.</span></strong>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import {formatQuery} from "../helpers/routes";

export default defineComponent({
    name: 'Users',
    data() {
        return {
            loaded: false,
            searchQuery: ""
        }
    },
    computed: {
        users() {
            return this.$store.getters.users;
        },
        friends() {
            return this.$store.getters.friends;
        }
    },
    methods: {
        handleSearch() {
            this.getAllUsers({search: this.searchQuery});
        },
        clearSearch() {
            this.searchQuery = "";
            this.getAllUsers();
        },
        getAllUsers(query = {}) {
           this.$store.dispatch('getAllUsers', query).then(response => {
               this.$store.dispatch('getAllFriends', {}).then(response => {
                   this.loaded = true;
                   this.$router.replace(formatQuery(query)).catch(() => {});
               })
           })
        },
        addFriend(user) {
            this.$store.dispatch('addOneFriend', user).then(response => {
                window.notification(response.data.message, 'success');
                this.getAllUsers();
            })
        },
        showAddButton(user) {
            let friendIds = [];
            this.friends.forEach(friend => friendIds.push(friend.id));
            if (friendIds.includes(user.id)) return false;
            return true;
        }
    },
    created() {
        this.getAllUsers();
    }
})
</script>

<style scoped>

</style>
