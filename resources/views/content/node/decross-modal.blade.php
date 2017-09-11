<div class="modal-header">
    <h5 class="modal-title">Удалить связь</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    ВНИМАНИЕ! Будут удалена связь между объектами:
        {{ $node1->name }} ({{ $interface1->name }})
        {{ $node2->name }} ({{ $interface2->name }})
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="decrossNodeExecute">Удалить</button>
</div>

<script type="text/javascript">
    $("#decrossNodeExecute").on("click",function () {
        $.post( "http://localhost/node/decross/execute", {
            _token: "{{ csrf_token() }}",
            nodeId1: "{{ $node1->id }}",
            interfaceId1: "{{ $interface1->id }}",
            nodeId2: "{{ $node2->id }}",
            interfaceId2: "{{ $interface2->id }}"
            },
            function( data ) {
                $('#nodeActionModal').modal('hide');
                var node = $("#tree").fancytree("getActiveNode");
                $("#tree").fancytree("getActiveNode").parent.load(true);
                updateAbout();
                //node.remove();
                //$("#nodeAbout").text("");
            }
        );
    });
</script>