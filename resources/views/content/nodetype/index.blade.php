<div class="container pt-3">
    <div class="row">
        <div class="col-4">
            <button type="button" id="nodetype-create" class="btn btn-outline-primary" data-link="ajax"
                    href="/admin/nodetypes/create">Создать</button>
            <div class="pt-3" id="typeContainer">
                <div class="list-group">
                    @foreach ($types as $type)
                        <li class="list-group-item list-group-item-action p-0 m-0" id="type-{{ $type->id }}"
                            data-id="{{ $type->id }}">
                            <a href="/admin/nodetypes/{{ $type->id }}" class="nav-link" data-link="ajax">
                                {{ $type->name }}
                            </a>
                        </li>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-6" id="typeAbout">
        </div>
    </div>
</div>

<script type="text/javascript">
    (function() {
        $("title").text("Кросс > типы узлов");
    })();





    function deleteLinePrepare($trigger)
    {
        var lineId = $trigger.data('id');

        $('#actionModal').modal('show');
        $('#actionModal').find('.modal-content').load(
            "http://localhost/content/line/delete/modal",
            { _token: "{{ csrf_token() }}", _method: "get", lineId: lineId },
            function( response, status, xhr ) {
                if ( status == "error" ) {
                    var msg = "Sorry but there was an error: ";
                    alert( msg + xhr.status + " " + xhr.statusText );
                }
            }
        );
    }

    function editLinePrepare($trigger)
    {
        console.log('editLinePrepare');
        var typeId = $trigger.data('id');
        var typeName = $trigger.text().trim();
        var typeParents = '';

        $.get( "http://localhost/type/getParents", {
            _token: "{{ csrf_token() }}",
            typeId: typeId
        }, function( jsonTypes )
        {
            var types = JSON.parse(jsonTypes);
            $.each(types, function(index, value) {
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

    function editLineExecute()
    {
        $.post( "http://localhost/line/edit/execute", {
            _token: "{{ csrf_token() }}",
            lineId: $('#lineEdit').data('id'),
            lineNewName: $('#lineEdit').find('#lineName').val()
        }, function( updatedLine )
        {
            updatedLine = JSON.parse(updatedLine);
            $("#line-" + updatedLine.id).html( updatedLine.name );
        });
    }

    function editLineCancel(lineName)
    {
        lineId = $('#lineEdit').data('id');
        lineName = $('#lineEdit').find('#lineNameBackup').val();
        $("#line-" + lineId).html( lineName );
    }



    $(function()
    {
        // setup context menu
        $.contextMenu({
            selector: '.list-group-item',
            build: function ($trigger, e)
            {
                var items = {};

                items.delete = {
                    name: "Удалить",
                    icon: "delete",
                    callback: function () {
                        let id = $trigger.data('id'),
                            $modal = $('#actionModal'),
                            url = "/admin/nodetypes/delete-modal",
                            props = {
                                _token: "{{ csrf_token() }}",
                                id: id
                            };
                        $.get(url, props, function (data) {
                            console.log('data='+data);
                            $modal.find('.modal-content').html(data);
                            $modal.modal('show');
                            //$trigger.remove();
                        });
                    }
                };

                return {
                    callback: function (key, options, rootMenu, originalEvent)
                    {
                        //console.dir($('.context-menu-active'));
                    },
                    items: items
                };
            }
        });


    });
</script>
