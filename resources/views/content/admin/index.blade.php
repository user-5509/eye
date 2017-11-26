<div class="container pt-3">
    <div class="row">
        <div class="col-5">
            <ul class="list-group">
                <li class="list-group-item list-group-item-action">
                    <a href="/admin/nodetypes" class="nav-link" data-link="ajax" data-section="node-types">Типы узлов</a>
                </li>
                <li class="list-group-item list-group-item-action">
                    <a href="/admin/linetypes" class="nav-link" data-link="ajax" data-section="line-types">Типы трактов</a>
                </li>
            </ul>
        </div>
        <div class="col-10" id="adminContent">
        </div>
    </div>
</div>

<script type="text/javascript">
    (function() {
        $("title").text("Кросс > параметры");
    })();

    /*
        $("#menuAdminTypes").on("click", function () {
            $('#adminContent').load("/types", {
                    _method: "get",
                    _token: "{{ csrf_token() }}"
            },
            function (response, status, xhr) {
                if (status == "error") {
                    var msg = "[loadAdmin] Sorry but there was an error: ";
                    alert(msg + xhr.status + " " + xhr.statusText);
                }
            }
        );
    });*/
</script>