@foreach ($interfaces as $interface)
    <a class="crossNodePrepare1 dropdown-item" data-interfaceId="{{$interface->id}}"
       data-toggle="modal" data-target="#nodeActionModal" href="#">{{ $interface->name }}</a>
@endforeach

<script type="text/javascript">
    $(".crossNodePrepare1").on("click",function () {
        var nodeId = $("#tree").fancytree("getActiveNode").key;
        var interfaceId = $(this).attr('data-interfaceId');
        $('#nodeActionModal').find('.modal-content').load("http://localhost/content/node/cross/modal",
            {
                _method: "get",
                nodeId: nodeId,
                interfaceId: interfaceId,
                _token: "{{ csrf_token() }}"
            },
            function( response, status, xhr ) {
                if ( status == "error" ) {
                    var msg = "Sorry but there was an error: ";
                    alert( msg + xhr.status + " " + xhr.statusText );
                }
            }
        );
    });
</script>