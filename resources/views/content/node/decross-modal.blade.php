<div class="modal-header">
    <h5 class="modal-title">Убрать кроссировку</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">

    <div class="container">

        <div class="row">
            <div class="col-12 text-center">
                {{ $node1->parent->name . '-' . $node1->name .'('. $interface1->name . ')' }}
                <i class="fa fa-random"></i>
                {{ $node2->parent->name . '-' . $node2->name .'('. $interface2->name . ')' }}
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <span>Присвоить тракт:</span>
            </div>

        </div>

        <div class="row">
            <div class="col-6 text-center">
                <select class="form-control" id="line1Select">
                    <option data-id="-1" >Создать новый</option>
                    @foreach ($lines as $line)
                        <option data-id="{{$line->id}}" @if($line->id == $node1->line->id) selected @endif >{{$line->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 text-center">
                <select class="form-control" id="line2Select">
                    <option data-id="-1" >Создать новый</option>
                    @foreach ($lines as $line)
                        <option data-id="{{$line->id}}" @if($line->id == $node2->line->id) selected @endif >{{$line->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-6 text-center">
                <div class="collapse" id="collapseNewLine1Name">
                    <input type="text" class="form-control" id="newLine1Name" placeholder="Введите наименование">
                </div>
            </div>
            <div class="col-6 text-center">
                <div class="collapse" id="collapseNewLine2Name">
                    <input type="text" class="form-control" id="newLine2Name" placeholder="Введите наименование">
                </div>
            </div>
        </div>

    </div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="decrossNodeExecute">Удалить</button>
</div>

<script type="text/javascript">

    $("#line1Select").on("change",function () {
        if( $(this).find("option:selected").data("id") == -1 ) {

            $("#collapseNewLine1Name").addClass('show');
        }
        else {
            $("#collapseNewLine1Name").removeClass('show');
        }
    });

    $("#line2Select").on("change",function () {
        if( $(this).find("option:selected").data("id") == -1 ) {

            $("#collapseNewLine2Name").addClass('show');
        }
        else {
            $("#collapseNewLine2Name").removeClass('show');
        }
    });

    $("#decrossNodeExecute").on("click",function () {

        $('#decrossNodeExecute').html('<i class="fa fa-refresh fa-spin"></i> Ждём...');


        $.post( "http://localhost/node/decross/execute", {
                _token: "{{ csrf_token() }}",
                nodeId1: "{{ $node1->id }}",
                interfaceId1: "{{ $interface1->id }}",
                nodeId2: "{{ $node2->id }}",
                interfaceId2: "{{ $interface2->id }}",
                line1Id: $("select#line1Select option:selected").data("id"),
                newLine1Name: $("#newLine1Name").val(),
                line2Id: $("select#line2Select option:selected").data("id"),
                newLine2Name: $("#newLine2Name").val()
            },
            function( data )
            {
                $("#tree").fancytree("getActiveNode").parent.load(true);
                $("#tree").fancytree("getTree").getNodeByKey("{{ $node2->id }}").parent.load(true);
                $("#tree").fancytree("getTree").activateKey("{{ $node2->id }}");
                //updateAbout();

                //$('#nodeActionModal').find('.modal-content').html('');
                $('#nodeActionModal').modal('hide');
            }
        );
    });
</script>