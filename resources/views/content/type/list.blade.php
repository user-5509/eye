<div class="list-group">
    @foreach ($types as $type)
        <li class="list-group-item list-group-item-action" id="type-{{ $type->id }}" data-id="{{ $type->id }}">
            {{ $type->name }}
        </li>
    @endforeach
</div>
