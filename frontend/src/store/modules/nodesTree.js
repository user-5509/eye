import * as types from './../mutation-types'

// initial state
const state = {
    nodePath: ''
}

// getters
const getters = {
    getNodePath: state => {
        console.log('getNodePath => ' + state.nodePath)
        return state.nodePath
    }
}

// actions
const actions = {
    savePath ({ commit }, path) {
        commit(types.NODESTREE_SAVE_PATH, path)
        console.log('savePath => ' + state.nodePath)
        return state.nodePath
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