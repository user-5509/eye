<template>
    <div class="container pt-3">
        <div class="row">
            <div class="col-6">
                <div is="NodesTree" :key="3"></div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        <div id="nodeAbout">about node</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="lineAbout">about line</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import NodesTree from './NodesTree.vue';
    export default {
        name: 'NodesLayout',
        data () {
            return {
            }
        },
        components: {
            'NodesTree': NodesTree
        }
    }
</script>