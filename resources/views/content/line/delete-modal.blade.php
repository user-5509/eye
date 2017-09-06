<div class="modal-header">
    <h5 class="modal-title">Удалить {{$line->name}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    Точно удалить тракт?!
</div>
<div class="modal-footer">
    <input type="hidden" class = "nodeId" value="{{$nodeId}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="deleteLineExecute">Удалить</button>
</div>

<script type="text/javascript">
    $("#deleteLineExecute").on("click",function () {
        $.post( "http://localhost/line/{{$lineId}}/delete",
            { _method: "delete", _token: "{{ csrf_token() }}" },
            function( data ) {
                $('#actionModal').modal('hide');
                $("#nodeAbout").text("");
                linesListReload();
            }
        );
    });
</script>