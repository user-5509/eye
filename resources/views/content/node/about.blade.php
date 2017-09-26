<div class="card card-outline-primary mx-auto" style="width: 30rem;">
    <div class="card-header pl-2 alert-secondary">
        <span class="fa-stack small">
            <i class="fa fa-circle-o fa-stack-2x"></i>
            <i class="fa fa-info fa-stack-1x"></i>
        </span>
        <span>{{ $node->type->getName() }}</span>
    </div>
    <div class="card-block text-center pt-4 pb-4">
        <span class="text-muted">{{ $node->getPath() }}</span><span>{{ $node->nameWithParent() }}</span>
    </div>

    {{--<div class="card-footer">
        @if ($line)
            <span class="text-muted">Тракт: </span><span class="badge badge-success">{{$line->name}}</span>
        @else
            <span class="text-muted">Свободна</span>
        @endif
    </div>--}}
</div>