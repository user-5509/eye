    <!-- Modal: node action -->
    <div class="modal fade" id="nodeActionModal" tabindex="-1" role="dialog" aria-labelledby="nodeActionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>


        <div class="container pt-3">
        <!-- Контент разбит на 2 row -->
        <div class="row">
            <div class="col-6">
                <div id="tree"></div>
            </div>
            <div class="col-6">
                <div id="nodeAbout"></div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        function getNodePath()
        {
            var parents = $("#tree").fancytree("getActiveNode").getParentList();
            var path = "";
            for(var i in parents) {
                path = path + "/" + parents[i].key;
            }
            path = path + "/" + $("#tree").fancytree("getActiveNode").key;
            return path;
        }

        function updateAbout()
        {
            var node = $("#tree").fancytree("getActiveNode");
            if(node.data.about) {
                $("#nodeAbout").load(  "http://localhost/content/node/about", {
                        _method: "get",
                        _token: "{{ csrf_token() }}",
                        nodeId: node.key,
                    },
                    function( response, status, xhr )
                    {
                        if ( status == "error" ) {
                            var msg = "[availableTypesDropdown] Sorry but there was an error: ";
                            alert( msg + xhr.status + " " + xhr.statusText );
                        }
                    }
                );
            }
            else {
                $("#nodeAbout").html('');
            }
        }

        function createNodePrepare(nodeTypeId)
        {
            var parentNodeId = $("#tree").fancytree("getActiveNode").key;
            $('#nodeActionModal').modal('show');
            $('#nodeActionModal').find('.modal-content').load(
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
                    }
                }
            );
        }

        function editNodePrepare()
        {
            var nodeId = $("#tree").fancytree("getActiveNode").key;

            $('#nodeActionModal').modal('show');
            $('#nodeActionModal').find('.modal-content').load(
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
                    }
                }
            );
        }

        function deleteNodePrepare()
        {
            var nodeId = $("#tree").fancytree("getActiveNode").key;
            $('#nodeActionModal').modal('show');
            $('#nodeActionModal').find('.modal-content').load(
                "http://localhost/content/node/delete/modal",
                { _method: "get", _token: "{{ csrf_token() }}", nodeId: nodeId },
                function( response, status, xhr )
                {
                    if ( status == "error" ) {
                        var msg = "Sorry but there was an error: ";
                        alert( msg + xhr.status + " " + xhr.statusText );
                    }
                }
            );
        };

        function crossNodePrepare(interfaceId)
        {
            var nodeId = $("#tree").fancytree("getActiveNode").key;
            //var interfaceId = $(this).attr('data-interfaceId');
            $('#nodeActionModal').modal('show');
            $('#nodeActionModal').find('.modal-content').load(
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
                    }
                }
            );
        }

        function decrossNodePrepare(interfaceId)
        {
            var nodeId = $("#tree").fancytree("getActiveNode").key;
            //var interfaceId = $(this).attr('data-interfaceId');
            $('#nodeActionModal').modal('show');
            $('#nodeActionModal').find('.modal-content').load(
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
                }
            );
        }

        function massLinkNodePrepare(interfaceAlias)
        {
            var nodeId = $("#tree").fancytree("getActiveNode").key;
            $('#nodeActionModal').modal('show');
            $('#nodeActionModal').find('.modal-content').load(
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
                    }
                }
            );
        }

        function massUnlinkPrepare()
        {
            var nodeId = $("#tree").fancytree("getActiveNode").key;
            $('#nodeActionModal').modal('show');
            $('#nodeActionModal').find('.modal-content').load(
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
                    }
                }
            );
        }

        $(function()
        {
            // Tree init
            $("#tree").fancytree({
                activate: function(event, data)
                {
                    console.log("Active node: " + data.node.key);
                    $.post( "http://localhost/node/savePath", {
                            _token: "{{ csrf_token() }}",
                            nodePath: getNodePath()
                        }
                    );
                    updateAbout();
                },
                source: {
                    url: "/getTreeData",
                    data: {mode: "children", parentNodeId: 1}
                },
                lazyLoad: function(event, data)
                {
                    var node = data.node;
                    // Load child nodes via ajax GET /getTreeData?mode=children&parent=1234
                    data.result = {
                        url: "/getTreeData",
                        data: {mode: "children", parentNodeId: node.key},
                        cache: false,

                    };
                },
                renderNode: function(event, data)
                {
                    // Optionally tweak data.node.span
                    var node = data.node;
                    //if(node.data.cstrender){
                    if(node.data._icon){
                        console.log("icon="+node.data._icon);
                        var $span = $(node.span);
                        $span.find('> span.fancytree-icon').html('<i class="fa fa-' + node.data._icon + '"></i>').removeClass("fancytree-icon");
                    }
                },
                init: function(event, data)
                {
                    // Expand tree nodes to target node
                    var tree = $("#tree").fancytree("getTree");
                    var path = "{{ $nodePath }}";
                    console.log(path);
                    tree.loadKeyPath(path, function(node, status)
                    {
                        if(status === "loaded") {
                            //console.log("loaded intermiediate node " + node);
                        }else if(status === "ok") {
                            //console.log("Node to activate: " + node);
                            $("#tree").fancytree("getTree").activateKey(node.key);
                            //node.setExpanded(true);
                        }
                    });
                }
            });

            var contextSubMenu = function (action, callback)
            {
                var url;

                switch(action) {
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

                    default:
                        url ='';
                }

                if(url == '') {
                    console.log('[contextSubMenu]: Empty url, ' + action);
                    return;
                }

                var dfd = jQuery.Deferred();

                $.ajax({url: url,
                        method: 'get',
                        data: {_token: "{{ csrf_token() }}",
                            nodeId: $("#tree").fancytree("getActiveNode").key,
                            callback: callback
                        },
                        dataType: 'json'
                })
                .done(function( data )
                {
                    var data2 = JSON.parse(data, function(key, value)
                    {
                        if (key === "callback") {
                            return eval("(" + value + ")");
                        }
                        return value;
                    });
                    dfd.resolve(data2);
                })
                .fail(function( err )
                {
                    console.log(action, err);
                });

                return dfd.promise();
            };

            // setup context menu
            $.contextMenu({
                selector: '.fancytree-title',
                build: function ($trigger, e)
                {
                    var items = {};
                    var node = $("#tree").fancytree("getActiveNode");

                    if(node.data.canCreate) {
                        items.create = {
                            name: "Создать...",
                            icon: "add",
                            items: contextSubMenu('create', 'createNodePrepare')
                        };
                    }
                    if(node.data.canEdit) {
                        items.edit = {
                            name: "Редактировать",
                            icon: "edit",
                            callback: function () {
                                editNodePrepare();
                            }
                        };
                    }
                    console.log(node.data.canMassLink);
                    if(node.data.canMassLink) {
                        items.link = {
                            name: "Связать...",
                            icon: "loading",
                            items: contextSubMenu('massLink', 'massLinkNodePrepare')
                        };
                    }
                    if(node.data.canMassUnlink) {
                        items.unlink = {
                            name: "Отвязать",
                            items: contextSubMenu('massUnlink', 'massUnlinkNodePrepare'),
                            callback: function () {
                                massUnlinkPrepare();
                            }
                        };
                    }
                    if(node.data.canCross) {
                        items.cross = {
                            name: "Кроссировать...",
                            icon: "loading",
                            items: contextSubMenu('cross', 'crossNodePrepare')
                        };
                    }
                    if(node.data.canDecross) {
                        items.decross = {
                            name: "Убрать кроссировку",
                            icon: "loading",
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
                        callback: function (key, options, rootMenu, originalEvent)
                        {
                            //console.dir($('.context-menu-active'));
                        },
                        items: items
                    };
                }
            });


        });

        $("title").text("Кросс - структура");
    </script>