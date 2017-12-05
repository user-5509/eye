<div class="modal-header">
    <h5 class="modal-title" id="modal-title"></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="type-form">
        <input type="hidden" id="id" value="{{ isset($type)?$type->id:'' }}">
        <div class="form-group">
            <label for="name">Наименование</label>
            <input type="text" class="form-control" id="name" value="{{ isset($type)?$type->name:'' }}"
                   placeholder="Укажите наименование">
        </div>
        <div class="form-group">
            <label for="icon">Иконка</label>
            <input type="text" class="form-control" id="name" value="{{ isset($type)?$type->icon:'' }}"
                   placeholder="Укажите код иконки">
        </div>
        <div class="form-group">
            <label for="wires">Количество проводов</label>
            <select class="form-control" id="wires">
                <option>1</option>
                <option>2</option>
                <option>4</option>
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
            actionModal.find('modal-title').text('Тип тракта');
            actionModal.find('btn-title').text('Создать');
        } else {
            actionModal.find('modal-title').text('Тип тракта');
            actionModal.find('btn-title').text('Редактировать');
        }

        function _create() {
            let url = '/admin/linetypes/create',
                props = {
                    _token: '{{ csrf_token() }}',
                    name: actionModal.find('name').val(),
                    icon: actionModal.find('icon').val(),
                    wires: actionModal.find('wires').val()
                };

            $.post(url, props,
                function (data) {
                    actionModal.hide();
                    actionModal.reset();
                    app.loadSection('/admin/linetypes');
                }
            ).fail(function(data) {
                actionModal.set(data.responseText);
            });
        }

        function _edit() {
            let url = '/admin/linetypes/edit',
                props = {
                    _token: '{{ csrf_token() }}',
                    id: actionModal.find('id').val(),
                    name: actionModal.find('name').val(),
                    icon: actionModal.find('icon').val(),
                    parents: actionModal.find('wires').val()
                };

            $.post(url, props,
                function (data) {
                    actionModal.hide();
                    actionModal.reset();
                    app.loadSection('/admin/linetypes');
                }
            ).fail(function(data) {
                actionModal.set(data.responseText);
            });
        }

        $("#execute").on("click", (action === 'create')?_create:_edit);
    })('{{ $action }}');
</script>

<style type="text/css">
    .multiselect-container {
        width: 100% !important; /* multiselect width fix */
    }
</style>