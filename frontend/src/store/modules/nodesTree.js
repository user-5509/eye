import * as types from './mutation-types'

// initial state
const state = {
    nodePath: ''
}

// getters
const getters = {
    getNodePath: state => state.nodePath
}

// actions
const actions = {
    savePath ({ commit, state }, path) {
        commit(types.NODESTREE_SAVE_PATH, path)
    }
}

// mutations
const mutations = {
    [types.NODESTREE_SAVE_PATH](state, path) {
        state.nodePath = path
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}