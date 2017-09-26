<div class="modal-header">
    <h5 class="modal-title">Редактировать {{ $line->name }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="edit-line-form">
        <div class="form-group">
            <label for="line-name">Наименование</label>
            <input type="text" class="form-control" name="line-name" placeholder="Наименование" value="{{ $line->getName() }}">
        </div>
        <div class="form-group">
            <label for="line-type">Тип:</label>
            <select class="form-control" id="line-type">
                <option data-type-id="0">черновой</option>
                <option data-type-id="1">Атлас</option>
                <option data-type-id="2">Исток</option>
                <option data-type-id="3">ПТС</option>
            </select>
        </div>
        <input type="hidden" name="line-id" value="{{ $line->id }}">
        {{ csrf_field() }}
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="edit-line-execute">Сохранить</button>
</div>
<script type="text/javascript">
    $("#edit-line-execute").on("click",function () {
        $.post( "http://localhost/line/edit/execute",
            $("#edit-line-form").serialize(),
            function( data ) {
                $("#tree").fancytree("getActiveNode").parent.load(true);
                $('#actionModal').modal('hide');
            }
        );
    });
</script>