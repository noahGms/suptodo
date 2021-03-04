import { createStore } from "vuex";
import AuthModule from "./modules/AuthModule";

export default createStore({
    modules: {
        AuthModule: AuthModule
    }
});