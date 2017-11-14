import Vue from 'vue'
import Vuex from 'vuex'
import * as types from './mutation-types'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        nodesTree: {
            nodePath: ''
        }
    },
    getters: {
        getNodePath: state => {
            return state.nodesTree.nodePath
        }
    },
    mutations: {
        [types.NODESTREE_SAVE_PATH] (state, { id }) {
            state.lastCheckout = null
            const record = state.added.find(p => p.id === id)
            if (!record) {
                state.added.push({
                    id,
                    quantity: 1
                })
            } else {
                record.quantity++
            }
        },


        setNodePath (state, payload) {
            state.nodesTree.nodePath = payload.path
        }
    },
    modules: {
        nodesTree
    }
})