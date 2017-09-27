<div class="d-flex flex-row">
    <div class="d-flex align-items-center">
        <span style="font-size: 12px">
            @if($linkedNode1)
                <span class="int-prev-{{ $nodeId }} text-muted" data-id="{{ $linkedNode1->id }}">
                    {{ $linkedNode1->parent->name }}-{{ $linkedNode1->name }}
                </span>
            @else
            ...
            @endif
            <i class="fa fa-random text-muted"></i>
        </span>
    </div>
    <div class="d-flex align-items-center ml-2 mr-2">
        <span class="badge @if($line) alert-primary @else alert-success @endif" style="font-size: 12px">
            {{ $nodeName }}
        </span>
    </div>
    <div>
        <div style="font-size: 12px">
            <i class="fa fa-random text-muted"></i>
            @if($linkedNode2)
                <span class="int-next-{{ $nodeId }} text-muted" data-id="{{ $linkedNode2->id }}">
                    {{ $linkedNode2->parent->name }}-{{ $linkedNode2->name }}
                </span>
            @else
            ...
            @endif
        </div>
        <div style="font-size: 12px">
            <i class="fa fa-random text-muted"></i>
            @if($linkedNode3)
                <span class="int-next-{{ $nodeId }} text-muted" data-id="{{ $linkedNode3->id }}">
                    {{ $linkedNode3->parent->name }}-{{ $linkedNode3->name }}
                </span>
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