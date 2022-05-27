import App from './App.vue'
import Vuex from 'vuex'
import axios from 'axios'
App.use(Vuex)
export default new Vuex.Store({
    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user : {}
    },
    mutations: {
    },
    actions: {
        login({commit}, user){
            return new Promise((resolve, reject) => {
                commit('auth_request')
                axios({url: 'http://localhost:8080/login', data: user, method: 'POST' })
                    .then(resp => {
                        const token = resp.data.token
                        const user = resp.data.user
                        localStorage.setItem('token', token)
                        axios.defaults.headers.common['Authorization'] = token
                        commit('auth_success', token, user)
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('auth_error')
                        localStorage.removeItem('token')
                        reject(err)
                    })
            })
        },
        register({commit}, user){
            return new Promise((resolve, reject) => {
                commit('auth_request')
                axios({url: 'http://localhost:84/api/v1/register', data: user, method: 'POST' })
                    .then(resp => {
                        const token = resp.data.token
                        const user = resp.data.user
                        localStorage.setItem('token', token)
                        axios.defaults.headers.common['Authorization'] = token
                        commit('auth_success', token, user)
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('auth_error', err)
                        localStorage.removeItem('token')
                        reject(err)
                    })
            })
        },

    },
    getters : {
    }
})