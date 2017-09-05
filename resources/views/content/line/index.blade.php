<ul class="list-group">
    @foreach ($lines as $line)
        <li class="list-group-item">{{ $line->name }}</li>
    @endforeach
</ul>