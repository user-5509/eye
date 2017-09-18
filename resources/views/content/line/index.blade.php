<div class="container pt-3">
    <!-- Контент разбит на 2 row -->
    <div class="row">
        <div class="col-6">
            <button type="button" id="createLineButton" class="btn btn-secondary btn" data-toggle="modal"
                    data-target="#actionModal">Создать</button>
            <div class="pt-2" id="listContainer">

            </div>
        </div>
        <div class="col-6" id="lineAbout">
        </div>
    </div>
</div>



<!-- Modal: line action -->
<div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>

<script type="text/javascript">



    $("#createLineButton").on("click",function () {
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

    function linesListReload() {
        console.log('linesListReload');
        $('#listContainer').load(
            "http://localhost/content/line/list",
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
        var lineId = $trigger.data('id');
        var lineName = $trigger.text().trim();

        var newHtml =
            '<form class="form-inline" id="lineEdit" data-id="' + lineId + '">' +
            '<input type="text" class="form-control" id="lineName"  value="' + lineName + '">' +
            '<input type="hidden" class="form-control" id="lineNameBackup"  value="' + lineName + '">' +
            '<button type="button" class="btn btn-sm btn-primary ml-2" id="editLineExecute"><i class="fa fa-check"></i></button>' +
            '<button type="button" class="btn btn-sm btn-secondary ml-2" id="editLineCancel"><i class="fa fa-close"></i></button>' +
            '' +
            '</form>';

        $trigger.html(newHtml);

        $("button#editLineExecute").on("click", editLineExecute);
        $("button#editLineCancel").on("click", editLineCancel);
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

    $(function()
        {
            $("title").text("Кросс - тракты");
            linesListReload();
        }
    );

</script>
