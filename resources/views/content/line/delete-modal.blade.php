<div class="modal-header">
    <h5 class="modal-title">Удалить {{$line->name}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    Точно удалить тракт?
    Будут так же удалены все сязанные кроссировки!
</div>
<div class="modal-footer">
    <input type="hidden" class = "nodeId" value="{{$line->id}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Отмена</button>
    <button type="button" class="btn btn-primary" id="deleteLineExecute"><i class="fa fa-trash"></i> Удалить</button>
</div>

<script type="text/javascript">
    $("#deleteLineExecute").on("click",function () {
        $.post( "http://localhost/line/{{$line->id}}/delete",
            { _method: "delete", _token: "{{ csrf_token() }}" },
            function( data ) {
                $('#actionModal').modal('hide');
                $("#nodeAbout").text("");
                linesListReload();
            }
        );
    });
</script>