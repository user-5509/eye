<div class="list-group">
    @foreach ($lines as $line)
        <li class="list-group-item list-group-item-action" id="line-{{ $line->id }}" data-id="{{ $line->id }}">
            {{ $line->name }}
        </li>
    @endforeach
</div>

<script type="text/javascript">

    $(".list-group-item").on("click",function (event) {
        var target = $( event.target );
        var lineId = $(this).data("id");
        if(target.is("li.list-group-item")) {
            $("#lineAbout").load("http://localhost/content/line/about",
                {_method: "get", _token: "{{ csrf_token() }}", lineId: lineId},
                function (response, status, xhr) {
                    if (status == "error") {
                        var msg = "[lineAbout] Sorry but there was an error: ";
                        alert(msg + xhr.status + " " + xhr.statusText);
                    }
                }
            );
        } else if(target.is("button.close")) {
            $('#actionModal').find('.modal-content').load(
                "http://localhost/content/line/delete/modal",
                    { _method: "get", _token: "{{ csrf_token() }}", lineId: lineId },
                    function( response, status, xhr ) {
                        if ( status == "error" ) {
                            var msg = "Sorry but there was an error: ";
                            alert( msg + xhr.status + " " + xhr.statusText );
                        }
                    }
                );
        }
    });

</script>
