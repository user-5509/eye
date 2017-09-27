<div class="container pt-3">
    <div class="row">
        <div class="col-6">
            <button type="button" id="create-line" class="btn btn-primary">
                <i class="fa fa-file-o"></i> Создать
            </button>
            <div class="pt-2" id="listContainer">
            </div>
        </div>
        <div class="col-6" id="lineAbout">
        </div>
    </div>
</div>

<div id="tmpl" hidden>
    <div id="line">
        <div id="create" >
            <div class="modal-header">
                <h5 class="modal-title">Создать</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{--TODO: form attr id is needed anymore?--}}
                <form id="form">
                    <div class="form-group">
                        <label for="line-name">Наименование</label>
                        <input type="text" class="form-control" id="line-name" name="line-name" placeholder="Наименование" value="">
                    </div>
                    <div class="form-group">
                        <label for="line-type">Тип:</label>
                        <select class="form-control" id="line-type" name="line-type">
                            <option value="0">черновой</option>
                            <option value="1">Атлас</option>
                            <option value="2">Исток</option>
                            <option value="3">ПТС</option>
                        </select>
                    </div>
                    <input type="hidden" id="line-id" name="line-id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Отмена</button>
                <button type="button" class="btn btn-primary" id="create-line-execute"><i class="fa fa-check"></i> Создать</button>
            </div>
        </div>
        <div id="edit" >
            <div class="modal-header">
                <h5 class="modal-title">Редактировать</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{--TODO: form attr id is needed anymore?--}}
                <form id="form">
                    <div class="form-group">
                        <label for="line-name">Наименование</label>
                        <input type="text" class="form-control" id="line-name" name="line-name" placeholder="Наименование" value="">
                    </div>
                    <div class="form-group">
                        <label for="line-type">Тип:</label>
                        <select class="form-control" id="line-type" name="line-type">
                            <option value="0">черновой</option>
                            <option value="1">Атлас</option>
                            <option value="2">Исток</option>
                            <option value="3">ПТС</option>
                        </select>
                    </div>
                    <input type="hidden" id="line-id" name="line-id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary" id="edit-line-execute">Сохранить</button>
            </div>
        </div>
    </div>
    <div id="line-icon">
        <div id="type-0">
        <span class="fa-stack text-primary">
            <i class="fa fa-square-o fa-stack-2x"></i>
            <i class="fa fa-stack-1x" style="font-size: 20px"><b>?</b></i>
        </span>
        </div>
        <div id="type-1">
        <span class="fa-stack text-primary">
            <i class="fa fa-square-o fa-stack-2x"></i>
            <i class="fa fa-stack-1x" style="   font-size: 20px"><b>А</b></i>
        </span>
        </div>
        <div id="type-2">
        <span class="fa-stack text-primary">
            <i class="fa fa-square-o fa-stack-2x"></i>
            <i class="fa fa-stack-1x" style="font-size: 20px"><b>И</b></i>
        </span>
        </div>
        <div id="type-3">
        <span class="fa-stack text-primary">
            <i class="fa fa-square-o fa-stack-2x"></i>
            <i class="fa fa-phone fa-stack-1x"></i>
        </span>
        </div>
    </div>
</div>




<script type="text/javascript">
    $("#create-line").on("click",function () {
        let modal = $("#actionModal");

        modal.find(".modal-content").html($("#tmpl").find("#line #create").html());
        modal.find("button#create-line-execute").on("click",function () {
            let modal = $("#actionModal");

            $.post( "http://localhost/line/create/execute",
                {
                    _token: "{{ csrf_token() }}",
                    lineId: modal.find("#line-id").val(),
                    lineName: modal.find("#line-name").val(),
                    lineType: modal.find("#line-type").val()
                },
                function( data ) {
                    linesListReload();
                    $('#actionModal').modal('hide');
                }
            );
        });
        modal.modal('show');
    });

    function linesListReload() {
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

        $('#actionModal').find('.modal-content').html('');
        $('#actionModal').find('.modal-content').load(
            "http://localhost/content/line/delete/modal",
            { _token: "{{ csrf_token() }}", _method: "get", lineId: lineId },
            function( response, status, xhr ) {
                if ( status == "error" ) {
                    var msg = "Sorry but there was an error: ";
                    alert( msg + xhr.status + " " + xhr.statusText );
                }
                else {
                    $('#actionModal').modal('show');
                }
            }
        );
    }

    function editLine($trigger) {
        let lineId =    $trigger.data('id');
        let lineName =  $trigger.find("#name").text().trim();
        let lineType =  $trigger.data('type');
        let modal    =  $("#actionModal");

        modal.find(".modal-content").html($("#line-edit").html());
        modal.find("#line-id").val(lineId);
        modal.find("#line-name").val(lineName);
        modal.find("select#line-type").val(lineType);
        modal.find("button#edit-line-execute").on("click",function () {
            let modal = $("#actionModal");

            $.post( "http://localhost/line/edit/execute",
                {
                    _token  : "{{ csrf_token() }}",
                    lineId  : modal.find("#line-id").val(),
                    lineName: modal.find("#line-name").val(),
                    lineType: modal.find("#line-type").val()
                },
                function( data ) {
                    let modal = $("#actionModal");
                    let lineId   = modal.find("#line-id").val();
                    let lineName = modal.find("#line-name").val();
                    let lineType = modal.find("#line-type").val();
                    let lineIcon = $("tmpl").find("#line-icon #type-" + lineType).html();
                    let line = $("#lines-list").find("li[data-id='" + lineId + "']");

                    line.find("span#name").text(lineName);
                    line.find("span#icon").html(lineIcon);
                    modal.modal("hide");
                }
            );
        });
        modal.modal("show");
    }

    $(function()
    {
        // setup context menu
        $.contextMenu( {
            selector: '.list-group-item',
            build: function ( $trigger ) {
                let items = {};

                items.edit = {
                    name: "Редактировать",
                    icon: "edit",
                    callback: function () {
                        editLine($trigger);
                    }
                };
                items.del = {
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

    $(function()
        {
            $("title").text("Кросс - тракты");
            linesListReload();
        }
    );

</script>
