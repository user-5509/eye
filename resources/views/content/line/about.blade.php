<div class="card card-outline-primary mt-4 mx-auto" style="width: 30rem;">
    <div class="card-header text-dark pl-2 alert-secondary">
        <span class="fa-stack small">
            <i class="fa fa-circle-o fa-stack-2x"></i>
            <i class="fa fa-info fa-stack-1x"></i>
        </span>
        <span>Станционный тракт</span>
    </div>
    <div class="card-block text-center pt-4 pb-4">
        <h6 class="card-title text-dark pb-2">
            <span class="fa-stack text-primary">
                <i class="fa fa-square-o fa-stack-2x"></i>
                <i class="fa fa-stack-1x" style="font-size: 20px"><b>А</b></i>
            </span>
            {{ $lineName }}
        </h6>
        <i class="fa fa-random"></i>
        @if ($nodeId == null)
            @foreach ($nodes as $node)
                <button type="button" class="btn btn-outline-primary mb-2 gotoNode" data-node-id="{{ $node->id }}">{{ $node->nameWithParent() }}</button>
                <i class="fa fa-random"></i>
            @endforeach
        @else
            @foreach ($nodes as $node)
                @if($node->id == $nodeId)
                    <button type="button" class="btn btn-outline-primary active btn mb-2" data-toggle="button">
                        {{ $node->nameWithParent() }}</button>
                @else
                    <button type="button" class="btn btn-outline-secondary mb-2 gotoKeyPath"
                            data-key-path="{{ $node->getKeyPath() }}">{{ $node->nameWithParent() }}</button>
                @endif
                <i class="fa fa-random"></i>
            @endforeach
        @endif
    </div>
    {{--<div class="card-footer">
        @if ($line)
            <span class="text-muted">Тракт: </span><span class="badge badge-success">{{$line->name}}</span>
        @else
            <span class="text-muted">Свободна</span>
        @endif
    </div>--}}

    <script type="text/javascript">
        $(".gotoKeyPath").on("click",function () {
            let keyPath = $(this).data('key-path');
            let tree    = $("#tree").fancytree("getTree");

            tree.loadKeyPath(keyPath, function (node, status) {
                if (status === "loaded") {
                    node.scrollIntoView(true);
                } else if (status === "ok") {
                    tree.activateKey(node.key);
                    node.scrollIntoView(true);
                }
            });
        });

        $(".gotoNode").on("click",function () {
            let nodeId = $(this).data('node-id');
            let navbar = $( "#navbar" );
            navbar.find( ".nav-item.active" ).removeClass("active");
            navbar.find( "#menuNodes" ).addClass("active");

            loadNodes($('#content'), nodeId);
        });

    </script>
</div>





