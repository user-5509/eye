<button type="button" id="createTypeButton" class="btn btn-secondary btn-sm" data-toggle="modal"
        data-target="#actionModal">Создать</button>
<table>
        <colgroup>
            <col width="500px" valign="top">
            <col width="90%">
        </colgroup>
        <tr>
            <td valign="top" id="typeContainer">

            </td>
            <td valign="top">
                <div id="typeAbout"></div>
            </td>
        </tr>
</table>

<!-- Modal: line action -->
<div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>

<script type="text/javascript">

    $("#createTypeButton").on("click",function () {
        $('#actionModal').find('.modal-content').load(
            "http://localhost/content/line/create/modal",
            {_method: "get", _token: "{{ csrf_token() }}"},
            function( response, status, xhr ) {
                if ( status == "error" ) {
                    var msg = "Sorry but there was an error: ";
                    alert( msg + xhr.status + " " + xhr.statusText );
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
                    callback: function (key, options, rootMenu, originalEvent)
                    {
                        //console.dir($('.context-menu-active'));
                    },
                    items: items
                };
            }
        });


    });

    $(function(){
        $("title").text("Кросс - тракты");
        typesListReload();}
    );

</script>
