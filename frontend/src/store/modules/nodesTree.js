import * as types from './../mutation-types'

// initial state
const state = {
    nodePath: null
}

// getters
const getters = {
    getPath: state =>  state.nodePath
}

// actions
const actions = {
    savePath ({ commit }, path) {
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