<template>
    <div class="tree" id="tree"></div>
</template>

<script>
    require('../../node_modules/jquery.fancytree/dist/jquery.fancytree-all-deps.min')

    import Vue from 'vue'
    import { mapGetters, mapActions } from 'vuex'
    import NodesTreeName from './NodesTreeName.vue';

    export default {
        computed: {
            ...mapGetters({
                getPath: 'getPath'
            })
        },
        methods: mapActions({
                savePath: 'savePath'
        }),

        components: { NodesTreeName },

        mounted: function () {
            const thisComponent = this

            function getNodePath() {
                let tree    = $("#tree");
                let parents = tree.fancytree("getActiveNode").getParentList();
                let path    = "";

                for(let i in parents) {
                    path = path + "/" + parents[i].key;
                }
                path = path + "/" + tree.fancytree("getActiveNode").key;

                return path;
            }

            // Tree init
            $(this.$el).fancytree( {
                autoScroll: true,
                activate:   function(event, data) {
                    thisComponent.savePath(getNodePath())

                    //updateAboutNode();

                    //updateAboutLine();

                    var node = data.node;

                    $(".int-prev-"+node.key+":not(.bound)").addClass('bound').on("dblclick", function () {

                        var nodeId = $('.int-prev-'+node.key).data('id');

                        $.get("http://localhost/node/getPath", {
                            _token: "{{ csrf_token() }}",
                            nodeId: nodeId,
                        }, function (data) {

                            var tree = $("#tree").fancytree("getTree");

                            tree.loadKeyPath(data, function (node, status) {
                                if (status === "ok") {
                                    //tree.activateKey(node.key);
                                }
                            });
                        });
                    });

                    $(".int-next-"+node.key+":not(.bound)").addClass('bound').on("dblclick", function ()
                    {
                        let nodeId = $('.int-next-'+node.key).data('id');

                        $.get("http://localhost/node/getPath", {
                                _token: "{{ csrf_token() }}",
                                nodeId: nodeId
                            },
                            function (data)
                            {
                                let tree = $("#tree").fancytree("getTree");

                                tree.loadKeyPath(data, function (node, status)
                                {
                                    if (status === "ok") {
                                        tree.activateKey(node.key);
                                    }
                                });
                            }
                        );
                    });
                },

                source: {
                    url: "http://localhost/getTreeData",
                    data: { mode: "children", parentNodeId: 1 }
                },

                lazyLoad: function(event, data) {
                    var node = data.node;

                    data.result = {
                        url: "http://localhost/getTreeData",
                        data: { mode: "children", parentNodeId: node.key },
                        cache: false
                    };
                },

                 expand: function(event, data) {
                    //console.log('expanded');

                    // Inject tooltip
                    /*let template = '<div class="tooltip tooltip-line pl-2" role="tooltip"><div class="arrow pl-1"></div>' +
                        '<div class="tooltip-inner bg-primary"></div></div>';

                    $('[data-toggle="tooltip"]').tooltip( { template: template } );*/
                },

                renderNode: function(event, data) {
                    let node = data.node;
                    let span_icon = $(node.span).find("span.fancytree-icon");
                    let span_title = $(node.span).find("span.fancytree-title");
                    let span = data.node.span;

                    if(node.data._icon) {
                        span_icon.html('<i class="fa fa-' + node.data._icon + ' fa-lg"></i>');
                    }

                    //span.removeClass("fancytree-icon");

                    let nodeName = node.title;

                    //span_title.html('<span is="NodesTreeName" nodeName="' + nodeName + '"></span>');

                    // Создание конструктора
                    let Name = Vue.extend({
                        template: '<span is="NodesTreeName" nodeName="' + nodeName+ '"></span> ',
                        data: function () {
                            return {
                                nodeName: nodeName
                            }
                        },
                        components: { NodesTreeName }
                    })
                    // создаёт экземпляр Profile и монтирует его к элементу DOM
                    //console.dir(span)
                    new Name().$mount(span.querySelector("span.fancytree-title"))
                },

                init: function(event, data) {
                    let tree = $("#tree").fancytree("getTree"),
                        path = thisComponent.getPath

                    tree.loadKeyPath(path, function(node, status) {
                        if(status === "loaded") {
                            tree.activateKey(node.key);
                        } else if(status === "ok") {
                            tree.activateKey(node.key);
                            //node.setExpanded(true);
                        }
                    });
                }
            });
        }
    }
</script>
<style src="../../node_modules/jquery.fancytree/dist/skin-win8/ui.fancytree.min.css"></style>
<style>
    .tree {
        font-size: 12px;
    }
    .fancytree-container {
        height: 480px;
        width: 100%;
        overflow: auto;
    }
</style>