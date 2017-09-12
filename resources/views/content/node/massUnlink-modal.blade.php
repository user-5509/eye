<div class="modal-header">
    <h5 class="modal-title">Отвязать {{$nodeName}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    ВНИМАНИЕ! Будут удалены связи между объектами!
</div>
<div class="modal-footer">
    <input type="hidden" class = "nodeId" value="{{$nodeId}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="massUnlinkExecute">Удалить</button>
</div>

<script type="text/javascript">
    $("#massUnlinkExecute").on("click",function () {
        $.post( "http://localhost/node/massUnlinkExecute", {
            _token: "{{ csrf_token() }}",
            nodeId: "{{$nodeId}}"
            },
            function( data ) {
                $('#nodeActionModal').modal('hide');
                var node = $("#tree").fancytree("getActiveNode");
                $("#tree").fancytree("getActiveNode").parent.load(true);
            }
        );
    });
</script>