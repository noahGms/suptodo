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
        getAllTodolists({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/todolists')
                    .then(response => {
                        commit('setTodolists', response.data.data);
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
