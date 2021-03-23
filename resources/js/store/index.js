import { createStore } from "vuex";
import AuthModule from "./modules/AuthModule";
import TodolistModule from "./modules/TodolistModule";
import FriendModule from "./modules/FriendModule";

const store = createStore({
    modules: {
        AuthModule: AuthModule,
        TodolistModule: TodolistModule,
        FriendModule: FriendModule
    }
});

export default store;
