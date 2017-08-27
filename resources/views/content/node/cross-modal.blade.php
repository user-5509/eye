<div class="modal-header">
    <h5 class="modal-title">Кроссировать</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
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
                $("#activeNodeId").value(data.node.key);
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
            }
        });
    });
    $("#crossNodeExecute").on("click",function () {
        alert("node1="+$("#tree").fancytree("getActiveNode").key+", node2="+$("#tree1").fancytree("getActiveNode").key);

    });
</script>