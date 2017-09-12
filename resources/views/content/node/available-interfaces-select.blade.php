@foreach ($interfaces as $interface)
    <option data-id="{{$interface->id}}" data-alias="{{$interface->alias}}">{{$interface->name}}</option>
@endforeach
