@foreach ($interfaces as $interface)
    <option data-id="{{$interface->id}}">{{$interface->name}}</option>
@endforeach
