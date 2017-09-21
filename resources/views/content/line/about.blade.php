<div class="text-center h6 mb-3">
    {{ $lineName }}
</div>
<i class="fa fa-random"></i>
@foreach ($nodes as $node)
    <button type="button" class="btn btn-outline-primary mb-2">{{ $node->nameWithParent() }}</button> <i class="fa fa-random"></i>
@endforeach