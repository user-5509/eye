import Vue from 'vue'
import VueRouter from 'vue-router'
import $ from 'jquery'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import App from './App.vue'
import NodesLayout from './NodesLayout.vue'
import LinesLayout from './LinesLayout.vue'

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

new Vue({
    router,
    el: '#app',
    render: h => h(App)
});
