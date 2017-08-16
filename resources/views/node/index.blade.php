<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap -->
    <link href="http://localhost/css/bootstrap.min.css" rel="stylesheet">



    <title>{{$currentNode->name}}</title>
</head>
<body>
    <h1>{{$currentNode->name}}</h1>

    <!-- Create node list -->
    @if(count($availableNodeTypes) > 0)
    <form>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle"
                    type="button" id="dropdownMenu1" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                Создать...
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                @foreach ($availableNodeTypes as $nodeType)
                <a class="createNodePrepare dropdown-item" data-nodeTypeId="{{$nodeType->id}}" data-toggle="modal" data-target="#createNodeModal" href="#">{{ $nodeType->name }}</a>
                @endforeach
            </div>
        </div>
    </form>
    @endif

    <!-- Node list -->
    <ul id="nodeList" class="list-group">
        @foreach ($nodes as $node)
        <li id="node-item-{{$node->id}}" class="list-group-item">
            <a href="/node/{{$node->id}}">{{ $node->name }} [{{ $node->type->name }}]</a>
            <button type="button" class="deleteNodePrepare btn btn-secondary btn-sm" data-nodeId="{{$node->id}}" data-nodeName="{{$node->name}}" data-toggle="modal" data-target="#deleteNodeModal">X</button>
        </li>
        @endforeach
    </ul>

    <!-- Modal create node-->
    <div class="modal fade" id="createNodeModal" tabindex="-1" role="dialog" aria-labelledby="createNodeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createNodeForm" class="node-form">
                        <div id="createNodeFormContent"></div>
                        <input type="hidden" name = "parentNodeId" value="{{$currentNode->id}}">
                        {{ csrf_field() }}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary" id="createNodeExecute">Создать</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal delete node-->
    <div class="modal fade" id="deleteNodeModal" tabindex="-1" role="dialog" aria-labelledby="deleteNodeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <input type="hidden" class = "nodeId" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary" id="deleteNodeExecute">Удалить</button>
                </div>
            </div>
        </div>
    </div>



    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="http://localhost/js/jquery-3.2.1.js"></script>
    <script src="http://localhost/js/tether.min.js"></script>
    <script src="http://localhost/js/bootstrap.min.js"></script>

    <script>
        $(".createNodePrepare").on("click",function () {
            var nodeTypeId = $(this).attr('data-nodeTypeId');
            var label = "Создать " + $(this).text();
            $('#createNodeModal').find('.modal-title').text(label);
            $('#createNodeFormContent').load("http://localhost/getFormContent", { nodeTypeId: nodeTypeId, _token: "{{ csrf_token() }}" }, function( response, status, xhr ) {
                if ( status == "error" ) {
                    var msg = "Sorry but there was an error: ";
                    alert( msg + xhr.status + " " + xhr.statusText );
                }
            });
        });

        $("#createNodeExecute").on("click",function () {
            $.post( "http://localhost/createNodeExecute", $("#createNodeForm").serialize(), function( data ) {
                $('#createNodeModal').modal('hide');
                location.reload();
            });
        });

        $(".deleteNodePrepare").on("click",function () {
            var nodeId = $(this).attr('data-nodeId');
            var label = "Удалить " + $(this).attr('data-nodeName');
            var deleteNodeModal = $('#deleteNodeModal');
            deleteNodeModal.find('.modal-title').text(label);
            deleteNodeModal.find('.nodeId').val(nodeId);
        });

        $("#deleteNodeExecute").on("click",function () {
            var nodeId = $('#deleteNodeModal').find('.nodeId').val();
            $.post( "http://localhost/node/"+nodeId, { _method: "delete", _token: "{{ csrf_token() }}" }, function( data ) {
                $('#deleteNodeModal').modal('hide');
                $("#node-item-"+nodeId).remove();
            });
        });
    </script>
</body>
</html>
