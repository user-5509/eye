<div class="text-center h5">
    {{ $lineName }}
</div>
<div class="text-center h2">
    &#8661;
</div>
@foreach ($nodes as $node)
    <div class="card card-outline-primary mb-1 text-center mx-auto" style="width: 25rem;">
        <div class="card-header">
            <span class="text-muted">{{ $node->getPath() }}</span>
        </div>
        <div class="card-block mb-2">
             <span class="">{{ $node->nameWithParent() }}</span>
        </div>
    </div>
    <div class="text-center h2">
        &#8661;
    </div>
@endforeach