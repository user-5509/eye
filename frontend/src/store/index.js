import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import nodesTree from './modules/nodesTree'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        nodesTree
    },
    plugins: [ createPersistedState({ storage: window.sessionStorage }) ]
})