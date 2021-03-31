import {formatQuery} from "../../helpers/routes";

export default {
    state: {
        friends: []
    },
    getters: {
        friends: (state) => state.friends
    },
    mutations: {
        setFriends(state, data) {
            state.friends = data;
        }
    },
    actions: {
        getAllFriends({commit}, query) {
            return new Promise((resolve, reject) => {
                axios.get('/api/friends' + formatQuery(query))
                    .then(response => {
                        commit('setFriends', response.data.data);
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        getAllFriendsInvitations() {
            return new Promise((resolve, reject) => {
                axios.get('/api/friends/invitations')
                    .then(response => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        deleteOneFriend({commit}, friend) {
            return new Promise((resolve, reject) => {
                axios.delete('/api/friends/' + friend.id)
                    .then(response => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        addOneFriend({commit}, user) {
            return new Promise((resolve, reject) => {
                axios.post('/api/friends', {user_id: user.id})
                    .then(response => {
                        resolve(response);
                    })
                    .catch(error => reject(error));
            })
        }
    }

}
