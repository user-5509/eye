<button type="button" id="createLineButton" class="btn btn-secondary btn-sm" data-toggle="modal"
        data-target="#actionModal">Создать</button>
<table>
        <colgroup>
            <col width="500px" valign="top">
            <col width="90%">
        </colgroup>
        <tr>
            <td valign="top" id="listContainer">

            </td>
            <td valign="top">
                <div id="lineAbout"></div>
            </td>
        </tr>
</table>

<!-- Modal: node action -->
<div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#createLineButton").on("click",function () {
        $('#actionModal').find('.modal-content').load(
            "http://localhost/content/line/create/modal",
            {_method: "get", _token: "{{ csrf_token() }}"},
            function( response, status, xhr ) {
                if ( status == "error" ) {
                    var msg = "Sorry but there was an error: ";
                    alert( msg + xhr.status + " " + xhr.statusText );
                }
            }
        );
    });

    function linesListReload() {
        $('#listContainer').load(
            "http://localhost/content/line/list",
            {_method: "get", _token: "{{ csrf_token() }}"},
            function (response, status, xhr) {
                if (status == "error") {
                    var msg = "Sorry but there was an error: ";
                    alert(msg + xhr.status + " " + xhr.statusText);
                }
            }
        );
    }

    $(".list-group-item").on("click",function () {
        //console.log(this);
        var lineId = $(this).data("id");
        $("#lineAbout").load(  "http://localhost/content/line/about",
            { _method: "get", _token: "{{ csrf_token() }}", lineId: lineId },
            function( response, status, xhr ) {
                if ( status == "error" ) {
                    var msg = "[lineAbout] Sorry but there was an error: ";
                    alert( msg + xhr.status + " " + xhr.statusText );
                }
            }
        );
    });

    $(function(){
        $("title").text("Кросс - тракты");
        linesListReload();}
    );
</script>
