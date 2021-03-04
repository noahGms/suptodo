import { createStore } from "vuex";
import AuthModule from "./modules/AuthModule";

const store = createStore({
    modules: {
        AuthModule: AuthModule
    }
});

export default store;