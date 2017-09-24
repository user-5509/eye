<div class="modal-header">
    <h5 class="modal-title">Связать {{ $node->name }} ({{ $interfaceName }})</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <form>
        <div class="form-group">
            <label for="startNodeId1">Начиная с</label>
            <select class="form-control" id="startNodeId1">
            </select>
        </div>
        <div class="form-group">
            <label for="order">Порядок</label>
            <select class="form-control" id="order1">
                <option data-order="0">Подряд (1, 2, 3...)</option>
                <option data-order="1">Через один (1, 3, 5...)</option>
            </select>
        </div>
    </form>

    <!-- Node tree -->
    <label for="tree1">Куда</label>
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
            <label for="order">Порядок</label>
            <select class="form-control" id="order2">
                <option data-order="0">Подряд (1, 2, 3...)</option>
                <option data-order="1">Через один (1, 3, 5...)</option>
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
        var order1 = $("select#order1 option:selected").data("order");
        var order2 = $("select#order2 option:selected").data("order");

        var count = Math.min((count1 - startFrom1)/(order1 + 1), (count2 - startFrom2)/(order2 + 1));

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

        $("#tree1").fancytree({
            autoScroll: true,
            activate: function(event, data)
            {
                var nodeId = $("#tree1").fancytree("getActiveNode").key;

                $('#interfaceSelect').html("");
                $('#interfaceSelect').load(
                    "http://localhost/content/node/cross/available-masslink-interfaces-select",
                    { _token: "{{ csrf_token() }}",
                        _method: "get",
                        nodeId: nodeId,
                        node1InterfaceAlias: "{{$interfaceAlias}}"},
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

                tree1.loadKeyPath(path, function(node, status)
                {
                    if(status === "ok") {
                        tree1.activateKey(node.key);
                    }
                });
            }
        });
    });

    $("#order1").on("change",function () {
        updateCount();
    });

    $("#order2").on("change",function () {
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
        var nodeId1 = $("#tree").fancytree("getActiveNode").key;
        var nodeId2 = $("#tree1").fancytree("getActiveNode").key;

        $.post( "http://localhost/node/massLink/execute", {
                _token: "{{ csrf_token() }}",
                nodeId1: nodeId1,
                interfaceAlias1: "{{ $interfaceAlias }}",
                nodeId2: nodeId2,
                interfaceAlias2: $("select#interfaceSelect option:selected").data("alias"),
                order1: $("select#order1 option:selected").data("order"),
                order2: $("select#order2 option:selected").data("order"),
                startNodeNum1: $("select#startNodeId1 option:selected").data("num"),
                startNodeNum2: $("select#startNodeId2 option:selected").data("num"),
                count: $("select#count").val()
            },
            function( data )
            {
                var tree = $("#tree").fancytree("getTree");
                var node1 = tree.getNodeByKey(nodeId1);
                var node2 = tree.getNodeByKey(nodeId2);

                node1.load(true);

                if(node2 != null) {
                    node2.load(true);
                }

                $('#nodeActionModal').modal('hide');
            }
        );
    });
</script>