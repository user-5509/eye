@foreach ($subTypes as $subType)
    <a class="createNodePrepare dropdown-item" data-nodeTypeId="{{$subType->id}}" data-parentNodeId="{{$nodeId}}"
       data-toggle="modal" data-target="#nodeActionModal" href="#">{{ $subType->name }}</a>
@endforeach

<script type="text/javascript">
    $(".createNodePrepare").on("click",function () {
        var nodeTypeId = $(this).attr('data-nodeTypeId');
        var parentNodeId = $(this).attr('data-parentNodeId');
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
    });
</script>