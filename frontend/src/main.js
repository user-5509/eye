import 'babel-polyfill'
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue' // TODO: is bootstrap must be here or in modules?
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import App from './components/App.vue'
import router from './router'
import store from './store'
import * as types from './store/mutation-types'


Vue.use(BootstrapVue);

const app = new Vue({
    router,
    store,
    el: '#app',
    render: h => h(App),
    mounted: () => {
        router.push('/nodes')
    }
});

