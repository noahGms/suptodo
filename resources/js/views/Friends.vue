<template>
    <div v-if="loaded" class="container mx-auto px-4 sm:px-6 lg:px-4 xl:px-6 pt-4 pb-4 sm:pb-6 lg:pb-4 xl:pb-6 space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg leading-6 font-medium text-black">Friends</h2>
            <button
                @click="openForm"
                class="hover:bg-indigo-200 hover:text-indigo-800 group flex items-center rounded-md bg-indigo-100 text-indigo-600 text-sm font-medium px-4 py-2"
            >
                <i class="fas fa-plus group-hover:text-indigo-600 text-indigo-500 mr-2"></i>
                Add
            </button>
        </div>
        <form class="relative" @submit.prevent="handleSearch">
            <i style="height: 20px; width: 20px;" class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input
                class="focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none w-full text-sm text-black placeholder-gray-500 border border-gray-200 rounded-md py-2 pl-10"
                type="text"
                aria-label="Filter projects"
                placeholder="Search friend"
                v-model="searchQuery"
                @change="handleSearch"
            />
            <button type="button" v-if="searchQuery" @click="clearSearch">
                <i style="height: 20px; width: 20px;" class="fas fa-times absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </button>
        </form>
        <div v-if="friends.length">
            <div class="flex flex-wrap -m-4">
                <div class="p-4 lg:w-1/3 w-full" v-for="(friend, idx) in friends" :key="idx">
                    <div class="flex rounded-lg h-full bg-gray-100 p-8 flex-col">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 mr-3 inline-flex items-center justify-center rounded-full bg-indigo-500 text-white flex-shrink-0">
                                <img v-if="friend.profile_pic" class="inline object-cover w-8 h-8 rounded-full m-1" :src="'../storage/' + friend.profile_pic" alt="Profile image"/>
                            </div>
                            <h2 class="text-gray-900 text-lg title-font font-medium">{{friend.username}}</h2>
                        </div>
                        <div class="flex items-center flex-wrap justify-between mt-3">
                            <div>
                                <span :class="friendStatus(friend).class">{{friendStatus(friend).name}}</span>
                            </div>
                            <div>
                                <button class="hover:bg-red-200 hover:text-red-800 group flex items-center rounded-md bg-red-100 text-red-600 text-sm font-medium px-4 py-2" @click="deleteFriend(friend)">Remove <i class="ml-2 fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="bg-indigo-100 border border-indigo-500 text-indigo-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold"><span class="block sm:inline">No friends 😟.</span></strong>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import {formatQuery} from "../helpers/routes";

export default defineComponent({
    name: 'Friends',
    data() {
        return {
            loaded: false,
            searchQuery: ""
        }
    },
    methods: {
        getAllFriends(query = {}) {
            this.loaded = false;
            this.$store.dispatch('getAllFriends', query).then(response => {
                this.loaded = true;
                this.$router.replace(formatQuery(query)).catch(() => {});
            });
        },
        handleSearch() {
            this.getAllFriends({search: this.searchQuery});
        },
        clearSearch() {
            this.searchQuery = '';
            this.getAllFriends();
        },
        friendStatus(friend) {
            if (friend.accepted === 1) {
                return {
                    class: 'inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-indigo-100 bg-green-700 rounded',
                    name: 'Accepted'
                };
            } else if (friend.accepted === 0) {
                return {
                    class: 'inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-700 rounded',
                    name: 'No accepted'
                };
            } else {
                return {
                    class: 'inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-gray-100 bg-gray-700 rounded',
                    name: 'Pending'
                };
            }
        },
        deleteFriend(friend) {
            if (confirm('Are you sure ?')) {
                this.$store.dispatch('deleteOneFriend', friend).then(_ => {
                    this.getAllFriends();
                });
            }
        }
    },
    computed: {
        friends() {
            return this.$store.getters.friends;
        }
    },
    created() {
        this.getAllFriends();
    }
})
</script>

<style scoped>

</style>
