<div class="card card-outline-primary mx-auto" style="width: 30rem;">
    <div class="card-header text-secondary pl-2">
        <span class="fa-stack small">
            <i class="fa fa-circle-o fa-stack-2x"></i>
            <i class="fa fa-info fa-stack-1x"></i>
        </span>
        {{ $node->type->getName() }}
    </div>
    <div class="card-block text-center">
        <span class="text-muted">{{ $node->getPath() }}</span><span>{{ $node->name }}</span>
    </div>

    {{--<div class="card-footer">
        @if ($line)
            <span class="text-muted">Тракт: </span><span class="badge badge-success">{{$line->name}}</span>
        @else
            <span class="text-muted">Свободна</span>
        @endif
    </div>--}}
</div>