<div class="d-flex flex-row">
    <div class="d-flex align-items-center">
        <span>
            @if($linkedNode1)
                <small class="int-prev-{{ $nodeId }} text-muted" data-id="{{ $linkedNode1->id }}">
                    {{ $linkedNode1->parent->name }}-{{ $linkedNode1->name }}
                </small>
            @else
            ...
            @endif
            <i class="fa fa-random text-muted"></i>
        </span>
    </div>
    <div class="d-flex align-items-center ml-2 mr-2">
        <span class="badge badge-primary">
            {{ $nodeName }}
        </span>
    </div>
    <div>
        <div>
            <i class="fa fa-random text-muted"></i>
            @if($linkedNode2)
                <small class="int-next-{{ $nodeId }} text-muted" data-id="{{ $linkedNode2->id }}">
                    {{ $linkedNode2->parent->name }}-{{ $linkedNode2->name }}
                </small>
            @else
            ...
            @endif
        </div>
        <div>
            <i class="fa fa-random text-muted"></i>
            @if($linkedNode3)
                <small class="int-next-{{ $nodeId }} text-muted" data-id="{{ $linkedNode3->id }}">
                    {{ $linkedNode3->parent->name }}-{{ $linkedNode3->name }}
                </small>
            @else
                ...
            @endif
        </div>
    </div>
</div>
@if($line)
        {{--<span class="badge badge-success">{{ $line->name }}</span>--}}
    <span>{{ $line->name }}</span>
@endif