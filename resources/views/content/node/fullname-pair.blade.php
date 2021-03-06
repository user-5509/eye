<span class="tree" @if($line)data-toggle="tooltip" data-placement="right" title="{{ $line->name }}"@endif>
    @if($linkedNode1)
        <span class="int-prev-{{ $nodeId }} text-muted" data-id="{{ $linkedNode1->id }}" style="font-size: 12px">
            {{ $linkedNode1->parent->name }}-{{ $linkedNode1->name }}
        </span>
    @else
        ...
    @endif
    <i class="fa fa-random text-muted"></i>
    <span class=" badge @if($line) alert-primary @else alert-success @endif" style="font-size: 12px">
         {{ $nodeName }}
    </span>
    <i class="fa fa-random text-muted"></i>
    @if($linkedNode2)
        <span class="int-next-{{ $nodeId }} text-muted" data-id="{{ $linkedNode2->id }}" style="font-size: 12px">
            {{ $linkedNode2->parent->name }}-{{ $linkedNode2->name }}
        </span>
    @else
        ...
    @endif
</span>
{{--
@if($line)
    <span class="badge badge-success">{{ $line->name }}</span>
@endif--}}
