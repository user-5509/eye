<div class="text-center h6 mb-3">
    {{ $lineName }}
</div>

<i class="fa fa-random"></i>

@if ($nodeId == null)
    @foreach ($nodes as $node)
        <button type="button" class="btn btn-outline-primary mb-2">{{ $node->nameWithParent() }}</button>
        <i class="fa fa-random"></i>
    @endforeach
@else
    @foreach ($nodes as $node)
        @if($node->id == $nodeId)
            <button type="button" class="btn btn-outline-primary mb-2" data-toggle="button" aria-pressed="true">{{ $node->nameWithParent() }}</button>
        @else
            <button type="button" class="btn btn-outline-secondary mb-2">{{ $node->nameWithParent() }}</button>
        @endif
        <i class="fa fa-random"></i>
    @endforeach
@endif