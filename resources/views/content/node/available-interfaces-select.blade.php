@foreach ($interfaces as $interface)
    <option data-id="{{$interface->id}}" data-alias="{{$interface->alias}}" @if($interface->alias <> $node1InterfaceAlias) selected @endif>{{$interface->name}}</option>
@endforeach
