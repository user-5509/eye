<div class="card card-outline-primary mb-1 text-center mx-auto" style="width: 30rem;">
    <div class="card-header">
        <span class="text-muted">{{ $node->getPath() }}</span>
    </div>
    <div class="card-block">
        <span class="h4"><span class="text-muted">{{ $node->type->getName() }}</span> {{ $node->nameWithParent() }}</span>
    </div>
    <div class="card-footer">
        @if ($line)
            <span class="text-muted">Тракт: </span><span class="badge badge-success">{{$line->name}}</span>
        @else
            <span class="text-muted">Свободна</span>
        @endif
    </div>
</div>