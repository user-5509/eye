<div class="modal-header">
    <h5 class="modal-title">Удалить {{$nodeName}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    ВНИМАНИЕ! Будут удалены все вложенные объекты!
</div>
<div class="modal-footer">
    <input type="hidden" class = "nodeId" value="{{$nodeId}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="deleteNodeExecute">Удалить</button>
</div>

<script type="text/javascript">
    $("#deleteNodeExecute").on("click",function () {
        $.post( "http://localhost/node/{{$nodeId}}/delete",
            { _method: "delete", _token: "{{ csrf_token() }}" },
            function( data ) {
                $('#nodeActionModal').modal('hide');
                var node = $("#tree").fancytree("getActiveNode");
                node.remove();
            }
        );
    });
</script>