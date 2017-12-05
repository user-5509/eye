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
                <li class="list-group-item list-group-item-action">
                    <a href="#" class="nav-link" id="checkRootNode">Check root node</a>
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

        function _checkRootNode(e) {
            e.preventDefault();
            let url = "/admin/checkRootNode",
                props = {
                    _token: "{{ csrf_token() }}"
                };
            $.get(url, props, function (data) {

            }).fail(function(data) {
                actionModal.set(data.responseText);
                actionModal.show();
            });
        }

        $("#checkRootNode").on("click", _checkRootNode);
    })();
</script>