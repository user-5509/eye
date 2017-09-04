<div class="modal-header">
    <h5 class="modal-title">Кроссировать</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    @if($lineId == null)
        <form>
            <div class="form-group">
                <label for="lineName">Линия</label>
                <input type="text" class="form-control" id="lineName" placeholder="Введите наименование" value="">
            </div>
        </form>
    @else
        <form>
            <div class="form-group">
                <label for="lineName">Линия</label>
                <input type="text" class="form-control" id="lineName" placeholder="" value="{{$lineName}}" readonly>
            </div>
        </form>
    @endif
    <div id="activeNodeId1">1</div>
    <!-- Node tree -->
    <div id="tree1"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="crossNodeExecute">Связать</button>
</div>

<script type="text/javascript">
    $(function(){
        // Create the tree inside the <div id="tree"> element.
        $("#tree1").fancytree({
            autoScroll: true,
            activate: function(event, data) {
                $("#activeNodeId1").text(data.node.key);
            },
            source: {
                url: "/getTreeData",
                data: {mode: "children", parentNodeId: 1}
            },
            lazyLoad: function(event, data) {
                var node = data.node;
                // Load child nodes via ajax GET /getTreeData?mode=children&parent=1234
                data.result = {
                    url: "/getTreeData",
                    data: {mode: "children", parentNodeId: node.key},
                    cache: false
                };
            },
            init: function(event, data) {
                // Expand tree nodes to target node
                var parents = $("#tree").fancytree("getActiveNode").getParentList();
                var path = "";
                for(i in parents) {
                    path = path + "/" + parents[i].key;
                }
                var tree1 = $("#tree1").fancytree("getTree");
                tree1.loadKeyPath(path, function(node, status){
                    if(status === "loaded") {
                        console.log("loaded intermiediate node " + node);
                    }else if(status === "ok") {
                        console.log("Node to activate: " + node);
                        $("#tree1").fancytree("getTree").activateKey(node.key);
                        node.setExpanded(true);
                    }
                });
            }
        });
    });
    $("#crossNodeExecute").on("click",function () {
        //alert($("#lineName").val());
        $.post( "http://localhost/node/cross/execute", {
            _token: "{{ csrf_token() }}",
            nodeId1: $("#tree").fancytree("getActiveNode").key,
            nodeId2: $("#tree1" ).fancytree("getActiveNode").key,
            lineName: $("#lineName").val()
            },
            function( data ) {
                $('#nodeActionModal').modal('hide');
                var node =  $("#tree").fancytree("getActiveNode");
                node.parent.load(true);
            }
        );
    });
</script>