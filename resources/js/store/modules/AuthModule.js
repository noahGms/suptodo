export default {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        register({ commit }, credentails) {
            return new Promise((resolve, reject) => {
                axios.post('/api/auth/register', credentails)
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