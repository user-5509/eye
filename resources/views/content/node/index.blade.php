
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

    <button type="button" id="crossNodeButton" class="btn btn-secondary btn-sm" data-toggle="modal"
            data-target="#nodeActionModal">Кросс</button>

    <button type="button" id="deleteNodeButton" class="btn btn-secondary btn-sm" data-toggle="modal"
            data-target="#nodeActionModal">Удалить</button>

    <button type="button" id="testButton" class="btn btn-secondary btn-sm">Test expand</button>

    <!-- Modal: node action -->
    <div class="modal fade" id="nodeActionModal" tabindex="-1" role="dialog" aria-labelledby="nodeActionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div id="activeNodeId">1</div>

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

    <script type="text/javascript">
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
            var nodeId = $("#tree").fancytree("getActiveNode").key;
            $('#nodeActionModal').find('.modal-content')
                .load("http://localhost/content/node/cross/modal",
                    { _method: "get", _token: "{{ csrf_token() }}", nodeId: nodeId },
                    function( response, status, xhr ) {
                        if ( status == "error" ) {
                            var msg = "Sorry but there was an error: ";
                            alert( msg + xhr.status + " " + xhr.statusText );
                        }
                    }
                );
        });

        $("#testButton").on("click",function () {
            var tree = $("#tree").fancytree("getTree");
            tree.loadKeyPath("/2/3/4/6", function(node, status){
                if(status === "loaded") {
                    console.log("loaded intermiediate node " + node);
                }else if(status === "ok") {
                    console.log("Node to activate: " + node);
                    $("#tree").fancytree("getTree").activateKey(node.key);
                }
            });
        });

        // Tree init
        $(function(){
            // Create the tree inside the <div id="tree"> element.
            $("#tree").fancytree({
                activate: function(event, data) {
                    $("#activeNodeId").text(data.node.key);
                    if(data.node.data.about) {
                        $("#nodeAbout").load(  "http://localhost/content/node/about",
                            { _method: "get", _token: "{{ csrf_token() }}", nodeId: data.node.key },
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
                }
            });
        });
    </script>