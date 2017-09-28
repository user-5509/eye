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
        <div id="create">
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
        <div id="edit">
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
    </div>
    <div id="line-icon">
        <div id="type-0">
        <span class="fa-stack text-primary">
            <i class="fa fa-square-o fa-stack-2x"></i>
            <i class="fa fa-stack-1x"><div class="icon-letter">?</div></i>
        </span>
        </div>
        <div id="type-1">
        <span class="fa-stack text-primary">
            <i class="fa fa-square-o fa-stack-2x"></i>
            <i class="fa fa-stack-1x"><div class="icon-letter">А</div></i>
        </span>
        </div>
        <div id="type-2">
        <span class="fa-stack text-primary">
            <i class="fa fa-square-o fa-stack-2x"></i>
            <i class="fa fa-stack-1x"><div class="icon-letter">И</div></i>
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
        let modal     = $("#actionModal-1");

        EyeRender.createLineDialog(modal);
    });

    function editLine($trigger) {
        let modal =  $("#actionModal-1");

        EyeRender.editLineDialog(modal, $trigger);
    }

    function linesListReload() {
        $('#listContainer').load(
            "http://localhost/content/line/list",
            {_method: "get", _token: "{{ csrf_token() }}"},
            function (response, status, xhr) {
                if (status == "error") {
                    var msg = "Sorry but there was an error: ";
                    alert(msg + xhr.status + " " + xhr.statusText);
                } else {
                    console.log(response);
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
