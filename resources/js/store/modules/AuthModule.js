import axios from "axios";
import cookie from "js-cookie"

export default {
    state: {
        token: cookie.get('token_bearer') || null,
        user: null,
    },
    getters: {
        isLoggedIn(state) {
            return !!state.token
        },
        user(state) {
            return state.user;
        }
    },
    mutations: {
        setToken(state, token) {
            state.token = token;
        },
        destroyTokenAndUser(state) {
            state.token = null;
            state.user = null;
        },
        setUser(state, user) {
            state.user = user;
        }
    },
    actions: {
        register({ commit }, user) {
            return new Promise((resolve, reject) => {
                axios.post('/api/auth/register', user)
                    .then(response => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        login({ commit }, credentails) {
            return new Promise((resolve, reject) => {
                axios.post('/api/auth/login', credentails)
                    .then(response => {
                        commit('setToken', cookie.get('token_bearer'));
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        logout({ commit }) {
            return new Promise((resolve, reject) => {
                axios.post('/api/auth/logout')
                    .then(response => {
                        commit('destroyTokenAndUser');
                        cookie.remove('token_bearer');
                        resolve(response);
                    })
                    .catch(error => {
                        commit('destroyTokenAndUser');
                        cookie.remove('token_bearer');
                        reject(error);
                    })
            })
        },
        whoami({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/auth/whoami')
                    .then(response => {
                        commit('setUser', response.data);
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        }
    }
}