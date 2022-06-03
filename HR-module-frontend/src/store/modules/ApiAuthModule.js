import {AuthApi} from "@/api/AuthApi/authApi";
export const ApiAuthModule = {
    namespace : true,
    state() {
        return {
            credentials: {
                token: localStorage.getItem('token') || null,
                roles: localStorage.getItem('roles') || null
            }
        }
    },
    getters: {
        getUserRoles: (state) => state.credentials.roles,
    },
    mutations: {
        setToken (state, token) {
            state.credentials.token = token
            localStorage.setItem('token', token)
        },

        setRoles (state, roles) {
            state.credentials.roles = roles
            localStorage.setItem('roles', JSON.stringify(roles))
        },

        deleteToken (state) {
            state.credentials.token = null
            localStorage.removeItem('token')
        },

        deleteRoles (state) {
            state.credentials.roles = null
            localStorage.removeItem('roles')
        },

    },
    actions: {
        onLogin({commit}, {login, password}) {
            AuthApi.login(login, password).then((res)=>{
                commit('setToken', res.data.token)
                commit('setRoles', res.data.roles)
            })
        },
        onLogout({commit}) {
            commit('deleteToken')
            commit('deleteRoles')
        }
    }
}