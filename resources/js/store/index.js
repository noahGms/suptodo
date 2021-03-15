import { createStore } from "vuex";
import AuthModule from "./modules/AuthModule";
import TodolistModule from "./modules/TodolistModule";

const store = createStore({
    modules: {
        AuthModule: AuthModule,
        TodolistModule: TodolistModule
    }
});

export default store;
