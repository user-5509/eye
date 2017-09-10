
    @if(count($availableNodeTypes) > 0)
        <!-- Dropdown: create node -->
        <div class="dropdown">
            <button id="createNodeButton" class="btn btn-secondary btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                Создать...
            </button>
            <div class="dropdown-menu" id="availableTypesDropdown" aria-labelledby="dropdownMenu1">
                <!-- dropdown content -->
            </div>
        </div>
    @endif

    <div class="dropdown">
        <button id="crossNodeButton" class="btn btn-secondary btn-sm dropdown-toggle"
                type="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            Кросс...
        </button>
        <div class="dropdown-menu" id="availableInterfacesDropdown" aria-labelledby="dropdownMenu2">
            <!-- dropdown content -->
        </div>
    </div>

    <button type="button" id="deleteNodeButton" class="btn btn-secondary btn-sm" data-toggle="modal"
            data-target="#nodeActionModal">Удалить</button>

    <button type="button" id="test" class="btn btn-secondary btn-sm">test</button>

    <!-- Modal: node action -->
    <div class="modal fade" id="nodeActionModal" tabindex="-1" role="dialog" aria-labelledby="nodeActionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div id="activeNodeId">1</div>

    <div id="selected-action">Click right mouse button on a node.</div>

    <table>
        <colgroup>
            <col width="300px" valign="top">
            <col width="90%">
        </colgroup>
        <tr>
            <td valign="top">
                <!-- Tree: nodes -->
                <div id="tree"></div>
            </td>
            <td valign="top">
                <div id="nodeAbout">sss</div>
            </td>
        </tr>
    </table>

    <script type="text/javascript">

        function getNodePath() {
            var parents = $("#tree").fancytree("getActiveNode").getParentList();
            var path = "";
            for(var i in parents) {
                path = path + "/" + parents[i].key;
            }
            path = path + "/" + $("#tree").fancytree("getActiveNode").key;
            return path;
        }

        $("#createNodeButton").on("click",function () {
            $('#availableTypesDropdown').html("");
            var nodeId = $("#tree").fancytree("getActiveNode").key;
            $('#availableTypesDropdown')
                .load(  "http://localhost/content/node/create/available-types-dropdown",
                    { _method: "get", _token: "{{ csrf_token() }}", nodeId: nodeId },
                    function( response, status, xhr ) {
                        if ( status == "error" ) {
                            var msg = "[availableTypesDropdown] Sorry but there was an error: ";
                            alert( msg + xhr.status + " " + xhr.statusText );
                        }
                    }
                );
        });

        function createNodePrepare(nodeTypeId) {
            console.log(nodeTypeId);
            //var nodeTypeId = $(this).attr('data-nodeTypeId;
            var parentNodeId = $("#tree").fancytree("getActiveNode").key;;
            $('#nodeActionModal').find('.modal-content').load(
                "http://localhost/content/node/create/modal",
                {_method: "get", nodeTypeId: nodeTypeId, parentNodeId: parentNodeId, _token: "{{ csrf_token() }}"},
                function( response, status, xhr ) {
                    if ( status == "error" ) {
                        var msg = "Sorry but there was an error: ";
                        alert( msg + xhr.status + " " + xhr.statusText );
                    }
                }
            );
        }

        $("#deleteNodeButton").on("click",function () {
            var nodeId = $("#tree").fancytree("getActiveNode").key;
            $('#nodeActionModal').find('.modal-content')
                .load(  "http://localhost/content/node/delete/modal",
                    { _method: "get", _token: "{{ csrf_token() }}", nodeId: nodeId },
                    function( response, status, xhr ) {
                        if ( status == "error" ) {
                            var msg = "Sorry but there was an error: ";
                            alert( msg + xhr.status + " " + xhr.statusText );
                        }
                    }
                );
        });

        $("#crossNodeButton").on("click",function () {
            $('#availableInterfacesDropdown').html("");
            var nodeId = $("#tree").fancytree("getActiveNode").key;
            $('#availableInterfacesDropdown')
                .load(  "http://localhost/content/node/cross/available-interfaces-dropdown",
                    { _method: "get", _token: "{{ csrf_token() }}", nodeId: nodeId },
                    function( response, status, xhr ) {
                        if ( status == "error" ) {
                            var msg = "[availableTypesDropdown] Sorry but there was an error: ";
                            alert( msg + xhr.status + " " + xhr.statusText );
                        }
                    }
                );
        });

        $("#test").on("click",function () {
            $("#tree").fancytree("getTree").contextMenu.menu = {};
            $('.fancytree-title').contextMenu('update');
        });

        $(function(){
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

                    if(data.node.data.about) {
                        $("#nodeAbout").load(  "http://localhost/content/node/about", {
                            _method: "get",
                            _token: "{{ csrf_token() }}",
                            nodeId: data.node.key,
                            },
                            function( response, status, xhr ) {
                                if ( status == "error" ) {
                                    var msg = "[availableTypesDropdown] Sorry but there was an error: ";
                                    alert( msg + xhr.status + " " + xhr.statusText );
                                }
                            }
                        );
                    }
                },
                source: {
                    url: "/getTreeData",
                    data: {mode: "children", parentNodeId: 1}
                },
                lazyLoad: function(event, data) {
                    var node = data.node;
                    // Load child nodes via ajax GET /getTreeData?mode=children&parent=1234
                    data.result = {
                        url: "/getTreeData",
                        data: {mode: "children", parentNodeId: node.key},
                        cache: false
                    };
                },
                init: function(event, data) {
                    // Expand tree nodes to target node
                    var tree = $("#tree").fancytree("getTree");
                    var path = "{{ $nodePath }}";
                    console.log(path);
                    tree.loadKeyPath(path, function(node, status){
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

            // some build handler to call asynchronously
            function createSomeMenu() {
                return {
                    items: loadItems()
                };
            }



            var menuCreate = function (callback) {
                var dfd = jQuery.Deferred();

                $.ajax({url: 'http://localhost/node/menu',
                        method: 'get',
                        data: {_token: "{{ csrf_token() }}",
                                nodeId: $("#tree").fancytree("getActiveNode").key,
                                callback: callback},
                        dataType: 'json'})
                    .done(function( data ){
                        console.log("OK!", data);
                        dfd.resolve(data);
                    })
                    .fail(function( err ){
                        console.log("ERR!", err);
                    });

              return dfd.promise();
            };

            var items = {
                "create": {
                    name: "qwqwqw",
                    icon: "edit"
                },
                "Зд": {
                    name: "Edit",
                    icon: "edit",
                    callback: function(itemKey, opt, rootMenu, originalEvent) {
                        var m = "edit was clicked";
                        window.console && console.log(m) || alert(m);
                    }
                },
                "cut": {name: "Cut", icon: "cut"},
                "copy": {name: "Copy", icon: "copy"}
            };

            // setup context menu
            $.contextMenu({
                selector: '.fancytree-title',
                build: function ($trigger, e) {
                    return {
                        callback: function (key, options, rootMenu, originalEvent) {
                            var m = "clicked: " + key;
                            console.log(m);
                            console.dir(key);
                            console.dir(rootMenu);
                        },
                        items: {
                            "create": {
                                name: "Создать",
                                items: menuCreate('createNodePrepare'),
                            }
                        }
                    };
                }
            });


        });

        $("title").text("Кросс - структура");
    </script>