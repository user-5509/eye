<ul class="list-group">
    @foreach ($lines as $line)
        <li class="list-group-item" data-id="{{ $line->id }}">{{ $line->name }}
            <button type="button" class="close" id="deleteLineButton" aria-label="Close" data-id="{{ $line->id }}">
                <span aria-hidden="true">&times;</span>
            </button>
        </li>
    @endforeach
</ul>

<script type="text/javascript">
    $("#deleteLineButton").on("click",function () {
        var lineId = $(this).data("id");
        console.log(lineId);
        $('#actionModal').find('.modal-content')
            .load(  "http://localhost/content/line/delete/modal",
                { _method: "get", _token: "{{ csrf_token() }}", lineId: lineId },
                function( response, status, xhr ) {
                    if ( status == "error" ) {
                        var msg = "Sorry but there was an error: ";
                        alert( msg + xhr.status + " " + xhr.statusText );
                    }
                }
            );
    });
</script>
