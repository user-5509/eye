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
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="massUnlinkExecute">Удалить</button>
</div>

<script type="text/javascript">
    $("#massUnlinkExecute").on("click",function () {

        var nodeId1 = $("#tree").fancytree("getActiveNode").key;
        var nodeId2 = "{{ $nodeId2 }}";

        $.post( "http://localhost/node/massUnlinkExecute", {
            _token: "{{ csrf_token() }}",
            nodeId1: nodeId1,
            nodeId2: nodeId2
            },
            function( data )
            {
                var tree = $("#tree").fancytree("getTree");
                var node1 = tree.getNodeByKey(nodeId1);
                var node2 = tree.getNodeByKey(nodeId2);

                node1.load(true);

                if(node2 != null) {
                    node2.load(true);
                }

                $('#nodeActionModal').modal('hide');
            }
        );
    });
</script>