<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Создать {{ $type->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="name">Наименование</label>
                        <input type="text" class="form-control" id="name" placeholder="Введите наименование">
                    </div>
                    <input type="hidden" id="typeId" value="{{$type->id}}">
                    <input type="hidden" id="parentId" value="{{ $parentId }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary" id="execute">Создать</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    (function () {
        let $dialog = $('#createModal');

        $("#execute").on("click",function () {
            let url = '/nodes/create',
                props = {
                    name: $dialog.find('#name').val(),
                    typeId: $dialog.find('#typeId').val(),
                    parentId: $dialog.find('#parentId').val()
                };

            app.post(url, props, () => {
                let activeNode = $("#tree").fancytree("getActiveNode");
                activeNode.folder = true;
                activeNode.lazy = true;
                activeNode.load(true);
                activeNode.setExpanded(true);

                $dialog.modal('hide');
            });
        });
    })();
</script>