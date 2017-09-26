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
            <input type="text" class="form-control" name="nodeName" placeholder="Наименование" value="{{ $node->getName() }}">
        </div>
        <div class="form-group">
            <label for="nodeName">Описание</label>
            <input type="text" class="form-control" name="nodeDescription" placeholder="Описание" value="{{ $node->getDescription() }}">
        </div>
        <input type="hidden" name="nodeId" value="{{ $node->id }}">
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
                $("#tree").fancytree("getActiveNode").parent.load(true);
                $('#actionModal').modal('hide');
            }
        );
    });
</script>