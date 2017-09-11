<div class="modal-header">
    <h5 class="modal-title">Кроссировать {{ $node->name }} ({{ $interface->name }})</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <form>
        <div class="form-group">
            <label for="lineSelect">Тракт</label>
            <select class="form-control" id="lineSelect">
                @foreach ($lines as $line)
                    <option data-id="{{$line->id}}">{{$line->name}}</option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- Node tree -->
    <div id="tree1"></div>

    <form>
        <div class="form-group">
            <select class="form-control" id="interfaceSelect">

            </select>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="crossNodeExecute">Связать</button>
</div>

<script type="text/javascript">

    function getKeyPath(tree) {
        var parents = tree.fancytree("getActiveNode").getParentList();
        var path = "";
        for(var i in parents) {
            path = path + "/" + parents[i].key;
        }
        path = path + "/" + tree.fancytree("getActiveNode").key;
        return path;
    }

    $(function(){
        @if($node->line_id <> "")
            $('select option[data-id={{$node->line_id}}]').prop('selected', true);
            $('select').prop('disabled', true);
        @endif

        // Create the tree inside the <div id="tree"> element.
        $("#tree1").fancytree({
            autoScroll: true,
            activate: function(event, data)
            {
               $('#interfaceSelect').html("");
                var nodeId = $("#tree1").fancytree("getActiveNode").key;
                $('#interfaceSelect')
                    .load(  "http://localhost/content/node/cross/available-interfaces-select",
                        { _method: "get", _token: "{{ csrf_token() }}", nodeId: nodeId },
                        function( response, status, xhr ) {
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
                // Load child nodes via ajax GET /getTreeData?mode=children&parent=1234
                data.result = {
                    url: "/getTreeData",
                    data: {mode: "children", parentNodeId: node.key},
                    cache: false
                };
            },
            init: function(event, data)
            {
                // Expand tree nodes to target node
                var tree1 = $("#tree1").fancytree("getTree");
                var path = getKeyPath($("#tree"));
                tree1.loadKeyPath(path, function(node, status){
                    if(status === "loaded") {
                        //console.log("loaded intermiediate node " + node);
                    }else if(status === "ok") {
                        //console.log("Node to activate: " + node);
                        tree1.activateKey(node.key);
                        node.setExpanded(true);
                    }
                });
            }
        });
    });

    $("#crossNodeExecute").on("click",function () {
        $.post( "http://localhost/node/cross/execute", {
            _token: "{{ csrf_token() }}",
            nodeId1: $("#tree").fancytree("getActiveNode").key,
            interfaceId1: "{{ $interface->id }}",
            nodeId2: $("#tree1" ).fancytree("getActiveNode").key,
            interfaceId2: $("select#interfaceSelect option:selected").data("id"),
            lineId: $("select#lineSelect option:selected").data("id")
            },
            function( data ) {
                $('#nodeActionModal').modal('hide');
                //var node =  $("#tree").fancytree("getActiveNode");
                //node.parent.load(true);
                var path = getKeyPath($("#tree1"));
                var tree = $("#tree").fancytree("getTree");
                //tree.visit(function(node){
                //    node.setExpanded(false);
                //});
                tree.loadKeyPath(path, function(node, status){
                    if(status === "loaded") {
                        console.log("loaded intermiediate node " + node);
                    }else if(status === "ok") {
                        console.log("Node to activate: " + node);
                        tree.activateKey(node.key);
                        //node.setExpanded(true);
                    }
                });
                $("#tree").fancytree("getActiveNode").parent.load(true);
            }
        );
    });
</script>