<div class="text-center h2">
    {{ $lineName }}
</div>
<div class="text-center h2">
    &#8661;
</div>
@foreach ($nodes as $node)
    <div class="card card-outline-primary mb-1 text-center mx-auto" style="width: 30rem;">
        <div class="card-header">
            <span class="text-muted">{{ $node->getPath() }}</span>
        </div>
        <div class="card-block">
             <span class="h4">{{ $node->nameWithParent() }}</span>
        </div>
    </div>
    <div class="text-center h2">
        &#8661;
    </div>
@endforeach