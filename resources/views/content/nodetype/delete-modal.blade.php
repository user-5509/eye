<div class="modal-header">
    <h5 class="modal-title"></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <h2>Удалить тип: {{ $type->name }} ?</h2>
</div>
<div class="modal-footer">
    <input type="hidden" id="id" value="{{ $type->id }}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Отмена</button>
    <button type="button" class="btn btn-primary" id="execute"><i class="fa fa-check"></i> Удалить</button>
</div>

<script type="text/javascript">
    (function () {
        $("#execute").on("click", function () {
            let url = "/admin/nodetypes/delete",
                props = {
                    _token: '{{ csrf_token() }}',
                    id: actionModal.find('id').val()
                };
            $.post(url, props, function () {
                actionModal.hide();
                actionModal.reset();

                // remove trigger
                let $trigger = $('#nodetype-{{ $type->id }}');
                $trigger.remove();
            }).fail(function(data) {
                actionModal.set(data.responseText);
            });
        });
    })();
</script>