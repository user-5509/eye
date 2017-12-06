<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
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
        </div>
    </div>
</div>

<script type="text/javascript">
    (function () {
        let $dialog = $('#deleteModal');

        $("#execute").on("click", function () {
            let url = "/admin/nodetypes/delete",
                id = $dialog.find('#id').val(),
                props = { id:  id};

            app.post(url, props, () => {
                $dialog.modal('hide');

                // remove trigger
                let $trigger = $('#nodetype-' + id);
                $trigger.remove();
            });
        });
    })();
</script>