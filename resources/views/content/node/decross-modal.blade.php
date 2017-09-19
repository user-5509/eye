<div class="modal-header">
    <h5 class="modal-title">Удалить связь</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

        <div class="text-center h5 pt-3">{{ $node1->parent->name . '-' . $node1->name .'('. $interface1->name . ')' }}  <i class="fa fa-random fa-lg"></i>
            {{ $node2->parent->name . '-' . $node2->name .'('. $interface2->name . ')' }}</div>

    <div class="form-check pt-3">
        <label class="form-check-label">
            <input class="form-check-input" id="removeLinkBinding" type="checkbox" value="" checked="true">
            Удалить привязку к тракту
        </label>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="decrossNodeExecute">Удалить</button>
</div>

<script type="text/javascript">
    $("#decrossNodeExecute").on("click",function () {

        $('#decrossNodeExecute').html('<i class="fa fa-refresh fa-spin"></i> Ждём...');

        $.post( "http://localhost/node/decross/execute", {
            _token: "{{ csrf_token() }}",
            nodeId1: "{{ $node1->id }}",
            interfaceId1: "{{ $interface1->id }}",
            nodeId2: "{{ $node2->id }}",
            interfaceId2: "{{ $interface2->id }}",
            removeLinkBinding: $("#removeLinkBinding").is(':checked')
            },
            function( data )
            {
                $("#tree").fancytree("getActiveNode").parent.load(true);
                $("#tree").fancytree("getTree").getNodeByKey("{{ $node2->id }}").parent.load(true);
                $("#tree").fancytree("getTree").activateKey("{{ $node2->id }}");
                //updateAbout();

                $('#nodeActionModal').find('.modal-content').html('');
                $('#nodeActionModal').modal('hide');
            }
        );
    });
</script>