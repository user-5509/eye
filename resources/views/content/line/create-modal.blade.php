<div class="modal-header">
    <h5 class="modal-title">Создать тракт</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="createNodeForm" class="line-form">
        <div class="form-group">
            <label for="lineName">Наименование</label>
            <input type="text" class="form-control" id="lineName" placeholder="Введите наименование">
        </div>
        {{ csrf_field() }}
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="createLineExecute">Создать</button>
</div>

<script type="text/javascript">
    $("#createLineExecute").on("click",function () {
        $.post( "http://localhost/line/create/execute", {
            _token: "{{ csrf_token() }}",
            lineName: $("#lineName").val()
            },
            function( data ) {
                $('#actionModal').modal('hide');
                linesListReload();
            }
        );
    });
</script>