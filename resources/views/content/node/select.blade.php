@foreach ($nodes as $node)
    <option data-id="{{$node->id}}" data-num="{{$counter++}}">{{$node->name}}</option>
@endforeach
