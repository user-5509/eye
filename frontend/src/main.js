import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue' // TODO: is bootstrap must be here or in modules?
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import App from './components/App.vue'
import store from './store'
import NodesLayout from './components/NodesLayout.vue'
import LinesLayout from './components/LinesLayout.vue'

Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(BootstrapVue);

const routes = [
    { path: '/nodes', component: NodesLayout },
    { path: '/lines', component: LinesLayout }
]

const router = new VueRouter({
    routes,
    linkActiveClass: "active"
})

router.push('/nodes')

const app = new Vue({
    router,
    store,
    el: '#app',
    render: h => h(App)
});
