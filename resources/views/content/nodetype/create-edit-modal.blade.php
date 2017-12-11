<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="nodetype-form">
                    <input type="hidden" id="id" value="{{ isset($type)?$type->id:'' }}">
                    <div class="form-group">
                        <label for="name">Наименование</label>
                        <input type="text" class="form-control" id="name" value="{{ isset($type)?$type->name:'' }}"
                               placeholder="Укажите наименование">
                    </div>
                    <div class="form-group">
                        <label for="alias">Алиас</label>
                        <input type="text" class="form-control" id="alias" value="{{ isset($type)?$type->alias:'' }}"
                               placeholder="Укажите алиас">
                    </div>
                    <div class="form-group">
                        <label for="icon">Иконка</label>
                        <input type="text" class="form-control" id="name" value="{{ isset($type)?$type->icon:'' }}"
                               placeholder="Укажите наименование">
                    </div>
                    <div class="form-check">
                        <label for="parents">Родительские типы</label>
                        <br/>
                        <select name="parents[]" id="parents" style="width: 500px" multiple="multiple">
                            @foreach ($allTypes as $item)
                                <option value="{{ $item->id }}"
                                        @if(array_search($item->name, $parents) !== false) selected="true" @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Отмена</button>
                <button type="button" class="btn btn-primary" id="execute"><i class="fa fa-check"></i> <span id="btn-title">Создать</span></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    (function (action) {
        let $dialog = $('#createModal');

        // set multiselect
        $dialog.find('#parents').multiselect({
            buttonWidth: '400px', /* multiselect width fix */
            nonSelectedText: 'Выберите типы!'
        });

        if(action === 'create') {
            $dialog.find('#modal-title').text('Создать');
            $dialog.find('#btn-title').text('Создать');
            $("#execute").on("click", create);
        } else if(action === 'edit') {
            $dialog.find('#modal-title').text('Редактировать');
            $dialog.find('#btn-title').text('Редактировать');
            $("#execute").on("click", edit);
        } else {
            app.error('Неопознанное действие!');
            return;
        }

        function create() {
            let url = '/admin/nodetypes/create',
                props = {
                    name: $dialog.find('#name').val(),
                    alias: $dialog.find('#alias').val(),
                    icon: $dialog.find('#icon').val(),
                    parents: $dialog.find('#parents').val()
                };

            app.post(url, props, () => {
                $dialog.modal('hide');
                app.loadSection('/admin/nodetypes');
            });
        }

        function edit() {
            let url = '/admin/nodetypes/edit',
                props = {
                    id: $dialog.find('#id').val(),
                    name: $dialog.find('#name').val(),
                    alias: $dialog.find('#alias').val(),
                    icon: $dialog.find('#icon').val(),
                    parents: $dialog.find('#parents').val()
                };

            app.post(url, props, () => {
                $dialog.modal('hide');
                app.loadSection('/admin/nodetypes');
            });
        }
    })('{{ $action }}');
</script>

<style type="text/css">
    .multiselect-container {
        width: 100% !important; /* multiselect width fix */
    }
</style>