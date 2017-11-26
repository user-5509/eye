 <div class="container pt-3">
        <div class="row">
            <div class="col-6">
                <div class="tree" id="tree"></div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        <div id="nodeAbout"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="lineAbout"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $("title").text("Кросс > структура");
        });

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

        function updateAboutNode()
        {
            var node = $("#tree").fancytree("getActiveNode");

            if(node.data.about) {

                $("#nodeAbout").load(  "http://localhost/content/node/about",
                    {
                        _method: "get",
                        _token: "{{ csrf_token() }}",
                        nodeId: node.key,
                    },
                    function( response, status, xhr )
                    {
                        if ( status == "error" ) {
                            var msg = "[updateAboutNode] Sorry but there was an error: ";
                            alert( msg + xhr.status + " " + xhr.statusText );
                        }
                    }
                );
            }
            else {
                $("#nodeAbout").html('');
            }
        }

        function updateAboutLine()
        {
            let node = $("#tree").fancytree("getActiveNode");

            if( node.data.line ) {
                $("#lineAbout").load(  "http://localhost/content/line/about",
                    {
                        _method:    "get",
                        _token:     "{{ csrf_token() }}",
                        lineId:     node.data.line,
                        nodeId:     node.key
                    },
                    function( response, status, xhr ) {
                        if ( status == "error" ) {

                            var msg = "[lineAbout] Sorry but there was an error: ";
                            alert( msg + xhr.status + " " + xhr.statusText );
                        }
                    }
                );
            }
            else {
                $("#lineAbout").html('');
            }
        }

        function createNodePrepare(nodeTypeId)
        {
            var parentNodeId = $("#tree").fancytree("getActiveNode").key;

            $('#actionModal').find('.modal-content').load(
                "http://localhost/content/node/create/modal", {
                    _token: "{{ csrf_token() }}",
                    _method: "get",
                    nodeTypeId: nodeTypeId,
                    parentNodeId: parentNodeId
                },
                function( response, status, xhr )
                {
                    if ( status == "error" ) {
                        var msg = "Sorry but there was an error: ";
                        alert( msg + xhr.status + " " + xhr.statusText );
                    } else {
                        $('#actionModal').modal('show');
                    }
                }
            );
        }

        function editNodePrepare()
        {
            var nodeId = $("#tree").fancytree("getActiveNode").key;

            $('#actionModal').find('.modal-content').load(
                "http://localhost/content/node/edit/modal", {
                    _token: "{{ csrf_token() }}",
                    _method: "get",
                    nodeId: nodeId
                },
                function( response, status, xhr )
                {
                    if ( status == "error" ) {
                        var msg = "Sorry but there was an error: ";
                        alert( msg + xhr.status + " " + xhr.statusText );
                    } else {
                        $('#actionModal').modal('show');
                    }
                }
            );
        }

        function deleteNodePrepare()
        {
            var nodeId = $("#tree").fancytree("getActiveNode").key;

            $('#actionModal').find('.modal-content').load(
                "http://localhost/content/node/delete/modal",
                { _method: "get", _token: "{{ csrf_token() }}", nodeId: nodeId },
                function( response, status, xhr )
                {
                    if ( status == "error" ) {
                        var msg = "Sorry but there was an error: ";
                        alert( msg + xhr.status + " " + xhr.statusText );
                    } else {
                        $('#actionModal').modal('show');
                    }
                }
            );
        };

        function crossNodePrepare(interfaceId)
        {
            var nodeId = $("#tree").fancytree("getActiveNode").key;
            //var interfaceId = $(this).attr('data-interfaceId');

            $('#actionModal').find('.modal-content').load(
                "http://localhost/content/node/cross/modal", {
                    _method: "get",
                    nodeId: nodeId,
                    interfaceId: interfaceId,
                    _token: "{{ csrf_token() }}"
                },
                function( response, status, xhr )
                {
                    if ( status == "error" ) {
                        var msg = "Sorry but there was an error: ";
                        alert( msg + xhr.status + " " + xhr.statusText );
                    } else {
                        $('#actionModal').modal('show');
                    }
                }
            );
        }

        function decrossNodePrepare(interfaceId)
        {
            var nodeId = $("#tree").fancytree("getActiveNode").key;
            var actionModal = $('#actionModal');


            actionModal.find('.modal-content').load(
                "http://localhost/content/node/decross/modal", {
                    _method: "get",
                    nodeId: nodeId,
                    interfaceId: interfaceId,
                    _token: "{{ csrf_token() }}"
                },
                function( response, status, xhr )
                {
                    if ( status == "error" ) {
                        var msg = "Sorry but there was an error: ";
                        alert( msg + xhr.status + " " + xhr.statusText );
                    }
                    else {
                        $('#actionModal').modal('show');
                    }
                }
            );
        }

        function massLinkNodePrepare(interfaceAlias)
        {
            var nodeId = $("#tree").fancytree("getActiveNode").key;
            var actionModal = $('#actionModal');

            actionModal.find('.modal-content').load(
                "http://localhost/content/node/massLink/modal", {
                    _method: "get",
                    nodeId: nodeId,
                    interfaceAlias: interfaceAlias,
                    _token: "{{ csrf_token() }}"
                },
                function( response, status, xhr )
                {
                    if ( status == "error" ) {
                        var msg = "Sorry but there was an error: ";
                        alert( msg + xhr.status + " " + xhr.statusText );
                    } else {
                        $('#actionModal').modal('show');
                    }
                }
            );
        }

        function massUnlinkPrepare()
        {
            var nodeId = $("#tree").fancytree("getActiveNode").key;
            var actionModal = $('#actionModal');

           actionModal.find('.modal-content').load(
                "http://localhost/content/node/massUnlink/modal", {
                    _method: "get",
                    nodeId: nodeId,
                    _token: "{{ csrf_token() }}"
                },
                function( response, status, xhr )
                {
                    if ( status == "error" ) {
                        var msg = "Sorry but there was an error: ";
                        alert( msg + xhr.status + " " + xhr.statusText );
                    } else {
                        $('#actionModal').modal('show');
                    }
                }
            );
        }

        $(function() {
            // Tree init
            $("#tree").fancytree( {
                autoScroll: true,
                activate:   function(event, data) {
                    $.post( "http://localhost/node/savePath", {
                            _token:     "{{ csrf_token() }}",
                            nodePath:   getNodePath()
                        }
                    );

                    updateAboutNode();

                    updateAboutLine();

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
                                    tree.activateKey(node.key);
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
                    url: "/getTreeData",
                    data: { mode: "children", parentNodeId: 1 }
                },

                lazyLoad: function(event, data) {
                    var node = data.node;

                    data.result = {
                        url: "/getTreeData",
                        data: {mode: "children", parentNodeId: node.key},
                        cache: false
                    };

                    //console.dir(data);
                },

                expand: function(event, data) {

                    // Inject tooltip
                    let template = '<div class="tooltip tooltip-line pl-2" role="tooltip"><div class="arrow pl-1"></div>' +
                        '<div class="tooltip-inner bg-primary"></div></div>';

                    $('[data-toggle="tooltip"]').tooltip( { template: template } );
                },

                renderNode: function(event, data) {
                    let node = data.node;
                    let span = $(node.span).find("> span.fancytree-icon");

                    if(node.data._icon) {
                        span.html('<i class="fa fa-' + node.data._icon + ' fa-lg"></i>');
                    }

                    span.removeClass("fancytree-icon");

                    //console.dir($(data.node.span));
                    //console.log('renderNode');
                },

                init: function(event, data) {

                    // Expand tree nodes to target node
                    let tree = $("#tree").fancytree("getTree");
                    let path = "{{ $nodePath }}";

                    tree.loadKeyPath(path, function(node, status) {
                        if(status === "loaded") {
                            tree.activateKey(node.key);
                        } else if(status === "ok") {
                            tree.activateKey(node.key);
                            node.setExpanded(true);
                        }
                    });
                }
            });

            let contextSubMenu = function (action, callback) {
                let url;

                switch (action) {
                    case "create":
                        url = 'http://localhost/node/contextSubMenuCreate';
                        break;

                    case "cross":
                        url = 'http://localhost/node/contextSubMenuCross';
                        break;

                    case "decross":
                        url = 'http://localhost/node/contextSubMenuDecross';
                        break;

                    case "massLink":
                        console.log('case:' + action);
                        url = 'http://localhost/node/contextSubMenuMassLink';
                        break;

                    case "removeLinkFromChain":
                        console.log('case:' + action);
                        url = 'http://localhost/node/removeLinkFromChain';
                        break;

                    default:
                        url = '';
                }

                if (url === "") {
                    console.log("[contextSubMenu]: Empty url, " + action);
                    return;
                }

                let dfd = jQuery.Deferred();

                $.ajax(
                    {
                        url:    url,
                        method: "get",
                        data:
                            {
                                _token:     "{{ csrf_token() }}",
                                nodeId:     $("#tree").fancytree("getActiveNode").key,
                                callback:   callback
                            },
                        dataType: "json"
                    }
                 )
                    .done(function (data) {
                        let data2 = JSON.parse(data, function (key, value) {
                            if (key === "callback") {
                                return eval("(" + value + ")");
                            }
                            return value;
                        });
                        dfd.resolve(data2);
                    })
                    .fail(function (err) {
                        console.log(action, err);
                    });

                return dfd.promise();
            };

            // setup context menu
            $.contextMenu( {
                selector: '.fancytree-title',
                build: function ( $trigger, e ) {
                    let items   = {};
                    let node    = $("#tree").fancytree("getActiveNode");

                    if( node.data.canCreate ) {
                        items.create = {
                            name:   "Создать...",
                            icon:   "add",
                            items:  contextSubMenu('create', 'createNodePrepare')
                        };
                    }
                    if( node.data.canEdit ) {

                        items.edit = {
                            name: "Редактировать",
                            icon: "edit",
                            callback: function () {
                                editNodePrepare();
                            }
                        };
                    }

                    if(node.data.canMassLink) {
                        items.link = {
                            name: "Связать...",
                            icon: "fa-chain",
                            items: contextSubMenu('massLink', 'massLinkNodePrepare')
                        };
                    }
                    if(node.data.canMassUnlink) {

                        items.unlink = {
                            name: "Отвязать",
                            icon: "fa-chain-broken",
                            items: contextSubMenu('massUnlink', 'massUnlinkNodePrepare'),

                            callback: function () {
                                massUnlinkPrepare();
                            }
                        };
                    }
                    if(node.data.canCross) {

                        items.cross = {
                            name: "Кроссировать...",
                            icon: "fa-exchange",
                            items: contextSubMenu('cross', 'crossNodePrepare')
                        };
                    }
                    if(node.data.canDecross) {
                        items.decross = {
                            name: "Убрать кроссировку",
                            icon: "fa-ban",
                            items: contextSubMenu('decross', 'decrossNodePrepare')
                        };
                    }
                    if(node.data.canDelete) {
                        items.delete = {
                            name: "Удалить",
                            icon: "delete",
                            callback: function () {
                                deleteNodePrepare();
                            }
                        };
                    }

                    return {
                        callback: function (key, options, rootMenu, originalEvent) {

                            //console.dir($('.context-menu-active'));
                        },
                        items: items
                    };
                }
            });
        });
    </script>