<div class="modal-header">
    <h5 class="modal-title">Редактировать {{ $node->name }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="editNodeForm" class="node-form">
        <div class="form-group">
            <label for="nodeName">Наименование</label>
            <input type="text" class="form-control" name="nodeName" id="nodeName" placeholder="Наименование" value="{{ $node->name }}">
        </div>
        <input type="hidden" name = "nodeId" value="{{ $node->id }}">
        {{ csrf_field() }}
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="editNodeExecute">Сохранить</button>
</div>

<script type="text/javascript">
    $("#editNodeExecute").on("click",function () {
        $.post( "http://localhost/node/edit/execute",
            $("#editNodeForm").serialize(),
            function( data ) {
                $('#nodeActionModal').modal('hide');
                $("#tree").fancytree("getActiveNode").parent.load(true);
            }
        );
    });
</script>