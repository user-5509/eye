import Vue from 'vue'
import VueRouter from 'vue-router'
import NodesLayout from './../components/NodesLayout.vue'
import LinesLayout from './../components/LinesLayout.vue'

Vue.use(VueRouter)

const routes = [
    { path: '/nodes', component: NodesLayout },
    { path: '/lines', component: LinesLayout }
]

export default new VueRouter({
    routes,
    linkActiveClass: "active",

})
