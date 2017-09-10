{
@foreach ($subTypes as $subType)
    "type{{ $subType->id }}": {
        name: "{{ $subType->name }}",
        icon: "edit"
    },
@endforeach
}