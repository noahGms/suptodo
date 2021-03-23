import {formatQuery} from "../../helpers/routes";

export default {
    state: {
        users: []
    },
    getters: {
        users: (state) => state.users
    },
    mutations: {
        setUsers(state, data) {
            state.users = data;
        }
    },
    actions: {
        getAllUsers({commit}, query) {
            return new Promise((resolve, reject) => {
                axios.get('/api/users' + formatQuery(query))
                    .then(response => {
                        commit('setUsers', response.data.data);
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        }
    }
}
