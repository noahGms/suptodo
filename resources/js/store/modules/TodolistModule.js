import { formatQuery } from "../../helpers/routes";

export default {
    state: {
        todolists: null
    },
    getters: {
        getTodolists: (state) => state.todolists
    },
    mutations: {
        setTodolists(state, todolists) {
            state.todolists = todolists;
        }
    },
    actions: {
        getAllTodolists({ commit }, query) {
            return new Promise((resolve, reject) => {
                axios.get('/api/todolists/all' + formatQuery(query))
                    .then(response => {
                        commit('setTodolists', response.data.data);
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        getAllTodolistsInvitations() {
            return new Promise((resolve, reject) => {
                axios.get('/api/todolists/invitations')
                    .then(response => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        getOneTodolist({commit}, id) {
            return new Promise((resolve, reject) => {
                axios.get('/api/todolists/' + id)
                    .then(response => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        newTodolist({ commit }, inputs) {
            return new Promise((resolve, reject) => {
                axios.post('/api/todolists', inputs)
                    .then(response => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        }
    }
}
