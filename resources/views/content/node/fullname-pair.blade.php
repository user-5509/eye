<span @if($line)data-toggle="tooltip" data-placement="right" title="{{ $line->name }}"@endif>
    @if($linkedNode1)
        <small class="int-prev-{{ $nodeId }} text-muted" data-id="{{ $linkedNode1->id }}">
            {{ $linkedNode1->parent->name }}-{{ $linkedNode1->name }}
        </small>
    @else
        ...
    @endif
    <i class="fa fa-random text-muted"></i>
    <span class="badge badge-primary">
         {{ $nodeName }}
    </span>
    <i class="fa fa-random text-muted"></i>
    @if($linkedNode2)
        <small class="int-next-{{ $nodeId }} text-muted" data-id="{{ $linkedNode2->id }}">
            {{ $linkedNode2->parent->name }}-{{ $linkedNode2->name }}
        </small>
    @else
        ...
    @endif
</span>
{{--
@if($line)
    <span class="badge badge-success">{{ $line->name }}</span>
@endif--}}
