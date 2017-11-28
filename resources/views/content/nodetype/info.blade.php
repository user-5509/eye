<div class="container pt-3">
    <form id="nodetype-info">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $type->id }}">
        <div class="form-group">
            <label for="typeName">Наименование</label>
            <input type="text" class="form-control" name="name" value="{{ $type->name }}"
                   placeholder="Укажите наименование">
        </div>
        <div class="form-check">
            <label for="typeParents">Родительские типы</label>
            <br/>
            <select name="parents" id="parents" style="width: 500px" multiple="multiple">
                @foreach ($allTypes as $item)
                    <option value="{{ $item->id }}"
                            @if(array_search($item->name, $parents) !== false) selected="true" @endif>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <br/>
        <button type="submit" class="btn btn-primary" id="nodetype-info-submit">Сохранить</button>
    </form>
</div>

<script type="text/javascript">
    (function () {
        $("title").text("Кросс > Типы узлов > {{ $type->name }}");

        $('#parents').multiselect({
            buttonWidth: '400px', /* multiselect width fix */
            nonSelectedText: 'Выберите типы!'
        });

        function _submit(e) {
            e.preventDefault();
            $.post("/admin/nodetypes/save", $('form#nodetype-info').serialize(), function () {
                history.back();
            });
        }

        $('form#nodetype-info').submit(_submit);
    })();

    /*
    $("#createTypeButton").on("click", function () {
        $('#actionModal').find('.modal-content').load(
            "http://localhost/content/line/create/modal",
            {_method: "get", _token: "{{ csrf_token() }}"},
            function (response, status, xhr) {
                if (status == "error") {
                    var msg = "Sorry but there was an error: ";
                    alert(msg + xhr.status + " " + xhr.statusText);
                }
            }
        );
    });

    function typesListReload() {
        $('#typeContainer').load(
            "http://localhost/content/type/list",
            {_method: "get", _token: "{{ csrf_token() }}"},
            function (response, status, xhr) {
                if (status == "error") {
                    var msg = "Sorry but there was an error: ";
                    alert(msg + xhr.status + " " + xhr.statusText);
                }
            }
        );
    }

    function deleteLinePrepare($trigger) {
        var lineId = $trigger.data('id');

        $('#actionModal').modal('show');
        $('#actionModal').find('.modal-content').load(
            "http://localhost/content/line/delete/modal",
            {_token: "{{ csrf_token() }}", _method: "get", lineId: lineId},
            function (response, status, xhr) {
                if (status == "error") {
                    var msg = "Sorry but there was an error: ";
                    alert(msg + xhr.status + " " + xhr.statusText);
                }
            }
        );
    }

    function editLinePrepare($trigger) {
        console.log('editLinePrepare');
        var typeId = $trigger.data('id');
        var typeName = $trigger.text().trim();
        var typeParents = '';

        $.get("http://localhost/type/getParents", {
            _token: "{{ csrf_token() }}",
            typeId: typeId
        }, function (jsonTypes) {
            var types = JSON.parse(jsonTypes);
            $.each(types, function (index, value) {
                typeParents += " " + value;
            });
            typeParents = typeParents.trim();
        });


        var newHtml =
            '<form class="form-inline" id="typeEdit" data-id="' + typeId + '">' +
            '<input type="text" class="form-control" id="typeName"  value="' + typeName + '">' +
            '<input type="text" class="form-control" id="typeParents"  value="' + typeParents + '">' +
            '<input type="hidden" class="form-control" id="typeNameBackup"  value="' + typeName + '">' +
            '<button type="button" class="btn btn-sm btn-primary" id="editTypeExecute">&#10004;</button>' +
            '<button type="button" class="btn btn-sm btn-secondary" id="editTypeCancel">&#10008;</button>' +
            '</form>';

        $trigger.html(newHtml);

        $("button#editTypeExecute").on("click", editTypeExecute);
        $("button#editTypeCancel").on("click", editTypeCancel);
    }

    function editLineExecute() {
        $.post("http://localhost/line/edit/execute", {
            _token: "{{ csrf_token() }}",
            lineId: $('#lineEdit').data('id'),
            lineNewName: $('#lineEdit').find('#lineName').val()
        }, function (updatedLine) {
            updatedLine = JSON.parse(updatedLine);
            $("#line-" + updatedLine.id).html(updatedLine.name);
        });
    }

    function editLineCancel(lineName) {
        lineId = $('#lineEdit').data('id');
        lineName = $('#lineEdit').find('#lineNameBackup').val();
        $("#line-" + lineId).html(lineName);
    }


    $(function () {
        // setup context menu
        $.contextMenu({
            selector: '.list-group-item',
            build: function ($trigger, e) {
                var items = {};

                items.edit = {
                    name: "Редактировать",
                    icon: "edit",
                    callback: function () {
                        editLinePrepare($trigger);
                    }
                };
                items.delete = {
                    name: "Удалить",
                    icon: "delete",
                    callback: function () {
                        deleteLinePrepare($trigger);
                    }
                };

                return {
                    callback: function (key, options, rootMenu, originalEvent) {
                        //console.dir($('.context-menu-active'));
                    },
                    items: items
                };
            }
        });
    });
    */
</script>

<style type="text/css">
    .multiselect-container {
        width: 100% !important; /* multiselect width fix */
    }
</style>
