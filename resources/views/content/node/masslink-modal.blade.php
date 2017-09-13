<div class="modal-header">
    <h5 class="modal-title">Связать {{ $node->name }} ({{ $interfaceName }})</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <form>
        <div class="form-group">
            <label for="order">Нумерация</label>
            <select class="form-control" id="order">
                <option data-order="0">Подряд (1, 2, 3...)</option>
                <option data-order="1">Через один (1, 3, 5...)</option>
            </select>
        </div>
        <div class="form-group">
            <label for="startNodeId1">Начиная с</label>
            <select class="form-control" id="startNodeId1">
            </select>
        </div>
    </form>

    <!-- Node tree -->
    <div id="tree1"></div>

    <form>
        <div class="form-group">
            <label for="interfaceSelect">Направление</label>
            <select class="form-control" id="interfaceSelect">
            </select>
        </div>
        <div class="form-group">
            <label for="startNodeId2">Начиная с</label>
            <select class="form-control" id="startNodeId2">
            </select>
        </div>
        <div class="form-group">
            <label for="count">Количество</label>
            <select class="form-control" id="count">
            </select>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
    <button type="button" class="btn btn-primary" id="massLinkExecute">Связать</button>
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

    function updateCount()
    {
        var count1 = $('#startNodeId1 option').length;
        var count2 = $('#startNodeId2 option').length;
        var startFrom1 = $("select#startNodeId1 option:selected").data("num");
        var startFrom2 = $("select#startNodeId2 option:selected").data("num");
        var order = $("select#order option:selected").data("order");

        var count = Math.min((count1 - startFrom1)/(order + 1), count2 - startFrom2);
        console.log('count='+count);

        var newHtml = '';
        for(var i = 1; i < count; i++) {
            newHtml += '<option>' + i + '</option>';
        }
        newHtml += '<option selected>' + count + '</option>';
        $('#count').html(newHtml);
    }

    $(function()
    {
        $('#startNodeId1').load(
            "http://localhost/content/node/select",
            { _token: "{{ csrf_token() }}", _method: "get", parentNodeId: $("#tree").fancytree("getActiveNode").key },
            function( response, status, xhr )
            {
                if ( status == "error" ) {
                    var msg = "[startNode2] Sorry but there was an error: ";
                    alert( msg + xhr.status + " " + xhr.statusText );
                }
            }
        );

        // Create the tree inside the <div id="tree"> element.
        $("#tree1").fancytree({
            autoScroll: true,
            activate: function(event, data)
            {
                var nodeId = $("#tree1").fancytree("getActiveNode").key;

                $('#interfaceSelect').html("");
                $('#interfaceSelect').load(
                    "http://localhost/content/node/cross/available-masslink-interfaces-select",
                    { _token: "{{ csrf_token() }}", _method: "get", nodeId: nodeId },
                    function( response, status, xhr )
                    {
                        if ( status == "error" ) {
                            var msg = "[interfaceSelect] Sorry but there was an error: ";
                            alert( msg + xhr.status + " " + xhr.statusText );
                        }
                    }
                );

                $('#startNodeId2').load(
                    "http://localhost/content/node/select",
                    { _token: "{{ csrf_token() }}", _method: "get", parentNodeId: nodeId },
                    function( response, status, xhr )
                    {
                        if ( status == "error" ) {
                            var msg = "[startNode2] Sorry but there was an error: ";
                            alert( msg + xhr.status + " " + xhr.statusText );
                        }

                       updateCount();
                    }
                );
            },
            source: {
                url: "/getTreeData",
                data: {mode: "children", parentNodeId: 1, massLink: true}
            },
            lazyLoad: function(event, data)
            {
                var node = data.node;
                // Load child nodes via ajax GET /getTreeData?mode=children&parent=1234
                data.result = {
                    url: "/getTreeData",
                    data: {mode: "children", parentNodeId: node.key, massLink: true},
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
                        //node.setExpanded(true);
                    }
                });
            }
        });
    });

    $("#order").on("change",function () {
        updateCount();
    });

    $("#startNodeId1").on("change",function () {
        updateCount();
    });

    $("#startNodeId2").on("change",function () {
        updateCount();
    });

    $("#massLinkExecute").on("click",function ()
    {
        $.post( "http://localhost/node/massLink/execute", {
                _token: "{{ csrf_token() }}",
                nodeId1: $("#tree").fancytree("getActiveNode").key,
                interfaceAlias1: "{{ $interfaceAlias }}",
                nodeId2: $("#tree1" ).fancytree("getActiveNode").key,
                interfaceAlias2: $("select#interfaceSelect option:selected").data("alias"),
                order: $("select#order option:selected").data("order"),
                startNodeNum1: $("select#startNodeId1 option:selected").data("num"),
                startNodeNum2: $("select#startNodeId2 option:selected").data("num"),
                count: $("select#count").val()
            },
            function( data )
            {
                $('#nodeActionModal').modal('hide');
                //var node =  $("#tree").fancytree("getActiveNode");
                //node.parent.load(true);

                $("#tree").fancytree("getActiveNode").parent.load(true);

                var path = getKeyPath($("#tree1"));
                var tree = $("#tree").fancytree("getTree");
                tree.loadKeyPath(path, function(node, status){
                    if(status === "loaded") {
                        //console.log("loaded intermiediate node " + node);
                    }else if(status === "ok") {
                        //console.log("Node to activate: " + node);
                        tree.activateKey(node.key);
                        //node.setExpanded(true);
                    }
                });
                $("#tree").fancytree("getActiveNode").parent.load(true);
            }
        );
    });
</script>