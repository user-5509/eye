<div class="list-group" id="lines-list">
    @foreach ($lines as $line)
        <li class="list-group-item list-group-item-action" id="line-{{ $line->id }}" data-id="{{ $line->id }}" data-type="{{ $line->type }}">
            <span id="icon">
                <span class="fa-stack text-primary">
                    <i class="fa fa-square-o fa-stack-2x"></i>
                    @if($line->type == 0)
                        <i class="fa fa-stack-1x" style="font-size: 20px"><b>?</b></i>
                    @elseif($line->type == 1)
                        <i class="fa fa-stack-1x" style="font-size: 20px"><b>А</b></i>
                    @elseif($line->type == 2)
                        <i class="fa fa-stack-1x" style="font-size: 20px"><b>И</b></i>
                    @elseif($line->type == 3)
                        <i class="fa fa-phone fa-stack-1x"></i>
                    @endif
                </span>
            </span>
            <span id="name">{{ $line->name }}</span>
        </li>
    @endforeach
</div>

<script type="text/javascript">
    $(".list-group-item").on("click",function (event) {
        let lineId = $(this).data("id");

        $("#lineAbout").load("http://localhost/content/line/about",
            {_method: "get", _token: "{{ csrf_token() }}", lineId: lineId},
            function (response, status, xhr) {
                if (status == "error") {
                    var msg = "[lineAbout] Sorry but there was an error: ";
                    alert(msg + xhr.status + " " + xhr.statusText);
                }
            }
        );
    });
</script>
