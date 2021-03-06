<div class="modal-header">
    <h5 class="modal-title">Создать {{$nodeTypeName}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="createNodeForm" class="node-form">
        <div class="form-group">
            <label for="nodeName">Наименование</label>
            <input type="text" class="form-control" name="nodeName" placeholder="Введите наименование">
            <input type="hidden" name="nodeTypeId" value="{{$nodeTypeId}}">
        </div>
        <input type="hidden" name="parentNodeId" value="{{$parentNodeId}}">
        {{ csrf_field() }}
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="createNodeExecute">Создать</button>
</div>

<script type="text/javascript">
    $("#createNodeExecute").on("click",function () {
        $.post( "http://localhost/node/create/execute",
            $("#createNodeForm").serialize(),
            function( data )
            {
                var activeNode = $("#tree").fancytree("getActiveNode");

                activeNode.folder = true;
                activeNode.lazy = true;
                activeNode.load(true);
                activeNode.setExpanded(true);

                $('#actionModal').modal('hide');
                $('#actionModal').find('.modal-content').html('');
            }
        );
    });
</script>