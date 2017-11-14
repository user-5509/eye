import Vue from 'vue'
import Vuex from 'vuex'
import nodesTree from './modules/nodesTree'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        nodesTree
    }
})