import { createStore } from "vuex";
import AuthModule from "./modules/AuthModule";
import TodolistModule from "./modules/TodolistModule";
import FriendModule from "./modules/FriendModule";
import UserModule from "./modules/UserModule";

const store = createStore({
    modules: {
        AuthModule: AuthModule,
        TodolistModule: TodolistModule,
        FriendModule: FriendModule,
        UserModule: UserModule
    }
});

export default store;
