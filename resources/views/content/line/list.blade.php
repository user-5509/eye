<div class="list-group" id="lines-list">
    @foreach ( $lines as $line )
        <a href="#" class="list-group-item list-group-item-action" id="line-{{ $line->id }}" data-id="{{ $line->id }}" data-type="{{ $line->type }}">
            <span id="icon">
                <span class="fa-stack text-primary">
                    <i class="fa fa-square-o fa-stack-2x"></i>
                    @if( $line->type == 0 )
                        <i class="fa fa-stack-1x"><div class="icon-letter">?</div></i>
                    @elseif( $line->type == 1 )
                        <i class="fa fa-stack-1x"><div class="icon-letter">А</div></i>
                    @elseif( $line->type == 2 )
                        <i class="fa fa-stack-1x"><div class="icon-letter">И</div></i>
                    @elseif( $line->type == 3 )
                        <i class="fa fa-phone fa-stack-1x"></i>
                    @endif
                </span>
            </span>
            <span id="name">{{ $line->name }}</span>
        </a>
    @endforeach
</div>

<script type="text/javascript">
    $(".list-group-item").on("click",function () {
        let lineId = $(this).data("id");

        $("#lineAbout").load("http://localhost/content/line/about",
            {
                _method:    "get",
                _token:     "{{ csrf_token() }}",
                lineId:     lineId
            },
            function (response, status, xhr) {
                if (status === "error") {
                    let msg = "[lineAbout] Sorry but there was an error: ";

                    alert(msg + xhr.status + " " + xhr.statusText);
                }
            }
        );

        $("#lines-list").find(".list-group-item-primary").removeClass(".list-group-item-primary");
        $(this).addClass(".list-group-item-primary");
    });
</script>
