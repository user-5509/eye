<ul class="list-group">

@foreach ($nodes as $node)
    <li class="list-group-item" data-id="{{ $node->id }}"><span data-toggle="tooltip" data-placement="top" title="{{ $node->getPath() }}">{{ $node->getPath() }}{{ $node->nameWithParent() }}</span></li>
@endforeach

</ul>

<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
