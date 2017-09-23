<div class="card card-outline-primary mt-4 mx-auto" style="width: 30rem;">
    <div class="card-header text-secondary pl-2">
        <span class="fa-stack small">
            <i class="fa fa-circle-o fa-stack-2x"></i>
            <i class="fa fa-info fa-stack-1x"></i>
        </span>
        Станционный тракт
    </div>
    <div class="card-block text-center">

        <h6 class="card-title mb-3">{{ $lineName }}</h6>

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
    </div>
    {{--<div class="card-footer">
        @if ($line)
            <span class="text-muted">Тракт: </span><span class="badge badge-success">{{$line->name}}</span>
        @else
            <span class="text-muted">Свободна</span>
        @endif
    </div>--}}
</div>





