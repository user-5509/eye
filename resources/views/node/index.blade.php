<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap -->
    <link href="http://localhost/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://localhost/fancytree/skin-win8/ui.fancytree.min.css" rel="stylesheet">

    <style type="text/css">
        .fancytree-container {
            height: 500px;
            width: 500px;
            overflow: auto;
        }
    </style>

    <title>{{$currentNode->name}}</title>
</head>
<body>
    <h1>{{$currentNode->name}}</h1>

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

    <!-- Modal: node action -->
    <div class="modal fade" id="nodeActionModal" tabindex="-1" role="dialog" aria-labelledby="nodeActionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <!-- Tree: nodes -->
    <div id="tree"></div>
    <input type="hidden" id="activeNodeId" value="1">



    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="http://localhost/js/jquery-3.2.1.js"></script>
    <script src="http://localhost/js/tether.min.js"></script>
    <script src="http://localhost/js/bootstrap.min.js"></script>
    <script src="http://localhost/fancytree/jquery.fancytree-all-deps.min.js"></script>

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
            $('#nodeActionModal').find('.modal-content')
                .load("http://localhost/content/node/cross/modal",
                    { _method: "get", _token: "{{ csrf_token() }}" },
                    function( response, status, xhr ) {
                        if ( status == "error" ) {
                            var msg = "Sorry but there was an error: ";
                            alert( msg + xhr.status + " " + xhr.statusText );
                        }
                    }
                );
        });

        // Tree init
        $(function(){
            // Create the tree inside the <div id="tree"> element.
            $("#tree").fancytree({
                activate: function(event, data) {
                    $("#activeNodeId").value(data.node.key);
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
</body>
</html>
