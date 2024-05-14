import axios from 'axios'
import router  from "@/routes"

export default {
    namespaced: true,
    state:{
        authenticated:false,
        user:{},
        states:[]
    },
    getters:{
        authenticated(state){
            return state.authenticated
        },
        user(state){
            return state.user
        },
        states(state){
            return state.states
        }
    },
    mutations:{
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value
        },
        SET_USER (state, value) {
            state.user = value
        },
        SET_STATES (state, value) {
            state.states = value
        }
    },
    actions:{
        login({commit}){
            return axios.get('user').then(({data})=>{
                commit('SET_USER',data)
                commit('SET_AUTHENTICATED',true)
                router.push({name:'dashboard'})
            }).catch((response)=>{
                commit('SET_USER',{})
                commit('SET_AUTHENTICATED',false)
            })
        },
        logout({commit}){
            commit('SET_USER',{})
            commit('SET_AUTHENTICATED',false)
        },
        authUser({commit}){

            return axios.get('user').then(({data})=>{
                commit('SET_USER',data)
                commit('SET_AUTHENTICATED',true)
            }).catch((response)=>{
                commit('SET_USER',{})
                commit('SET_AUTHENTICATED',false)
            })
        },
    }
}
