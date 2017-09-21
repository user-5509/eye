<div class="text-center h6">
    {{ $lineName }}
</div>
<div class="text-center h3">
    <i class="fa fa-random fa-rotate-90"></i>
</div>
@foreach ($nodes as $node)
    <div class="card card-outline-primary mb-1 text-center mx-auto" style="width: 25rem;">
        <div class="card-header">
            <span class="text-muted">{{ $node->getPath() }}</span>
        </div>
        <div class="card-block mb-2">
             <span class="h6">{{ $node->nameWithParent() }}</span>
        </div>
    </div>
    <div class="text-center h3">
        <i class="fa fa-random fa-rotate-90"></i>
    </div>
@endforeach