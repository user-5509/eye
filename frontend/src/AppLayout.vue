<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div is="Navbar"></div>
                <div>{{ layout }}</div>
                <input v-model="layout"/>
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="content">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
    import Navbar from './Navbar.vue';
    import NodesLayout from './NodesLayout.vue';
    import LinesLayout from './LinesLayout.vue';
    export default {
        name: 'AppLayout',
        data: function () {
            return {
                layout: ''
            }
        },
        components: {
            'Navbar': Navbar,
            'NodesLayout': NodesLayout,
            'LinesLayout': LinesLayout
        }
    }
</script>