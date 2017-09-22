<div class="modal-header">
    <h5 class="modal-title">Кроссировать {{ $node->parent->name . '-' . $node->name }} ({{ $interface->name }})</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <div>Куда:</div>
    <!-- Node tree -->
    <div id="tree1"></div>

    <form>
        <div class="form-group">
            <select class="form-control" id="interfaceSelect">

            </select>
        </div>
    </form>
    <form>
        <div class="form-group">
            <label for="lineSelect">Тракт:</label>
            <select class="form-control" id="lineSelect">
                @foreach ($lines as $line)
                    <option data-id="{{$line->id}}" @if($line->id == $predefinedLineId) selected @endif >{{$line->name}}</option>
                @endforeach
            </select>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="crossNodeExecute">Связать</button>
</div>

<script type="text/javascript">

    function getKeyPath(tree)
    {
        var parents = tree.fancytree("getActiveNode").getParentList();
        var path = "";

        for(var i in parents) {
            path = path + "/" + parents[i].key;
        }
        //path = path + "/" + tree.fancytree("getActiveNode").key;
        return path;
    }

    $(function(){
        {{--@if($node->line_id <> "")
            $('select#lineSelect option[data-id={{$node->line_id}}]').prop('selected', true);
            $('select#lineSelect').prop('disabled', true);
        @endif--}}

        // Create the tree inside the <div id="tree"> element.
        $("#tree1").fancytree({
            autoScroll: true,
            activate: function(event, data)
            {
               $('#interfaceSelect').html("");
                var nodeId = $("#tree1").fancytree("getActiveNode").key;
                $('#interfaceSelect')
                    .load("http://localhost/content/node/cross/available-interfaces-select", {
                            _token: "{{ csrf_token() }}",
                            _method: "get",
                            nodeId: nodeId,
                            node1InterfaceAlias: "{{$node1InterfaceAlias}}"
                        },
                        function( response, status, xhr )
                        {
                            if ( status == "error" ) {
                                var msg = "[interfaceSelect] Sorry but there was an error: ";
                                alert( msg + xhr.status + " " + xhr.statusText );
                            }
                        }
                    );
            },
            source: {
                url: "/getTreeData",
                data: {mode: "children", parentNodeId: 1}
            },
            lazyLoad: function(event, data)
            {
                var node = data.node;

                data.result = {
                    url: "/getTreeData",
                    data: {mode: "children", parentNodeId: node.key},
                    cache: false
                };
            },
            renderNode: function(event, data)
            {
                // Optionally tweak data.node.span
                var node = data.node;
                //if(node.data.cstrender){
                if(node.data._icon){
                    var $span = $(node.span);
                    $span.find('> span.fancytree-icon').html('<i class="fa fa-' + node.data._icon + '"></i>').removeClass("fancytree-icon");
                }
            },
            init: function(event, data)
            {
                $("#tree1").find(".fancytree-container").css({ height: "280px" });

                // Expand tree nodes to target node
                var tree1 = $("#tree1").fancytree("getTree");
                var path = getKeyPath($("#tree"));
                tree1.loadKeyPath(path, function(node, status){
                    if(status === "loaded") {
                        tree1.activateKey(node.key);
                        //console.log("loaded intermiediate node " + node);
                    }else if(status === "ok") {
                        //console.log("Node to activate: " + node);
                        tree1.activateKey(node.key);
                        //node.setExpanded(true);
                    }
                });
            }
        });
    });

    $("#crossNodeExecute").on("click",function () {

        $('#crossNodeExecute').html('<i class="fa fa-refresh fa-spin"></i> Ждём...');

        var nodeId1 = $("#tree").fancytree("getActiveNode").key;
        var nodeId2 = $("#tree1").fancytree("getActiveNode").key;

        $.post( "http://localhost/node/cross/execute", {
            _token: "{{ csrf_token() }}",
            nodeId1: nodeId1,
            interfaceId1: "{{ $interface->id }}",
            nodeId2: nodeId2,
            interfaceId2: $("select#interfaceSelect option:selected").data("id"),
            lineId: $("select#lineSelect option:selected").data("id")
            },
            function( data )
            {
                var tree = $("#tree").fancytree("getTree");
                var node1 = tree.getNodeByKey(nodeId1);
                var node2 = tree.getNodeByKey(nodeId2);

                node1.parent.load(true);

                if(node2 != null) {

                    node2.parent.load(true).done(function () {

                        node2.parent.setExpanded();
                        tree.activateKey(node2.key);
                    });
                }

                $('#nodeActionModal').find('.modal-content').html('');

                $('#nodeActionModal').modal('hide');
            }
        );
    });
</script>