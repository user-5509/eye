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
    <form>
        @if($availableNodeTypes)
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle"
                    type="button" id="dropdownMenu1" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                Создать...
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                @foreach ($availableNodeTypes as $nodeType)
                <a class="dropdown-item" data-nodeTypeId="{{$nodeType->id}}" data-toggle="modal" data-target="#createNodeModal" href="/node/{{$currentNode->id}}/create/{{$nodeType->id}}">{{ $nodeType->name }}</a>
                @endforeach
            </div>
        </div>
        @endif
    </form>

    <!-- Node list -->
    <ul class="list-group">
        @foreach ($nodes as $node)
        <li class="list-group-item">
            <a href="/node/{{$node->id}}">{{ $node->name }} [{{ $node->type->name }}]</a>
            <button type="button" class="del-node btn btn-secondary btn-sm" data-nodeId="{{$node->id}}">X</button>
        </li>
        @endforeach
    </ul>

    <!--
    <a class="dropdown-item" data-id="" data-toggle="modal-ajax" href="#">test</a>
    <div class="test">
        ???
    </div>
    -->

    <!-- Modal -->
    <div class="modal fade" id="createNodeModal" tabindex="-1" role="dialog" aria-labelledby="createNodeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createNodeModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createNodeForm">
                        <div id="createNodeFormContent">
                        </div>
                        <input type="hidden" name = "parentNodeId" value="{{$currentNode->id}}">
                        {{ csrf_field() }}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary" id="accept">Создать</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="http://localhost/js/jquery-3.2.1.js"></script>
    <script src="http://localhost/js/tether.min.js"></script>
    <script src="http://localhost/js/bootstrap.min.js"></script>

    <script>
        $("a[data-toggle='modal']").on("click",function () {
            var nodeTypeId = $(this).attr('data-nodeTypeId');
            var label = "Создать " + $(this).text();
            $('#createNodeModalLabel').text(label);
            $.get( "http://localhost/getFormContent", {nodeTypeId: nodeTypeId}, function( data ) {
                $('#createNodeFormContent').html( data );
            });
        });

        $("button[id='accept']").on("click",function () {
            $.post( "http://localhost/accept", $("#createNodeForm").serialize(), function( data ) {
                //$('.test').html( data );
                $('#createNodeModal').modal('hide');
                location.reload();
            });
        });

        $('.del-node').on("click",function () {
            var nodeId = $(this).attr('data-nodeId');
            alert('http://localhost/node/'+nodeId);
            //return;
            $.post( "http://localhost/node/"+nodeId, {method: 'DELETE'}, function( data ) {

                //$('.test').html( data );
                //$('#createNodeModal').modal('hide');
                location.reload();
            });
        });
    </script>
</body>
</html>
