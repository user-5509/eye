<div class="modal-header">
    <h5 class="modal-title" id="modal-title"></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="line-form">
        <input type="hidden" id="id" value="{{ isset($line)?$line->id:'' }}">
        <div class="form-group">
            <label for="name">Наименование</label>
            <input type="text" class="form-control" id="name" value="{{ isset($line)?$line->name:'' }}"
                   placeholder="Укажите наименование">
        </div>
        <div class="form-group">
            <label for="type">Тип</label>
            <select class="form-control" id="type">
                <option value="1" @if($line->type === 1) selected="true" @endif>1-п</option>
                <option value="2" @if($line->type === 2) selected="true" @endif>2-п</option>
                <option value="4" @if($line->type === 4) selected="true" @endif>4-п</option>
            </select>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Отмена</button>
    <button type="button" class="btn btn-primary" id="execute"><i class="fa fa-check"></i> <span id="btn-title">Создать</span></button>
</div>

<script type="text/javascript">
    (function (action) {
        if(action === 'create') {
            actionModal.find('modal-title').text('Тракт');
            actionModal.find('btn-title').text('Создать');
        } else {
            actionModal.find('modal-title').text('Тракт');
            actionModal.find('btn-title').text('Редактировать');
        }

        function _create() {
            let url = '/lines/create',
                props = {
                    _token: '{{ csrf_token() }}',
                    name: actionModal.find('name').val(),
                    type: actionModal.find('type').val()
                };

            $.post(url, props,
                function (data) {
                    actionModal.hide();
                    actionModal.reset();
                    app.loadSection('/lines');
                }
            ).fail(function(data) {
                actionModal.set(data.responseText);
            });
        }

        function _edit() {
            let url = '/lines/edit',
                props = {
                    _token: '{{ csrf_token() }}',
                    id: actionModal.find('id').val(),
                    name: actionModal.find('name').val(),
                    type: actionModal.find('type').val(),
                };

            $.post(url, props,
                function (data) {
                    actionModal.hide();
                    actionModal.reset();
                    app.loadSection('/lines');
                }
            ).fail(function(data) {
                actionModal.set(data.responseText);
            });
        }

        $("#execute").on("click", (action === 'create')?_create:_edit);
    })('{{ $action }}');
</script>