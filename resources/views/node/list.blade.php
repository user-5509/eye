<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap -->
    <link href="http://localhost/css/bootstrap.min.css" rel="stylesheet">



    <title>Создать</title>
</head>
<body>

    <form>
        @if($availableTypes <> null)
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle"
                    type="button" id="dropdownMenu1" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                Создать...
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                @foreach ($availableTypes as $type)
                <a class="dropdown-item" data-id="{{$type->id}}" data-toggle="modal" data-target="#exampleModal3" href="/node/{{$curNodeId}}/create/{{$type->id}}">{{ $type->name }}</a>
                @endforeach
            </div>
        </div>
        @endif
    </form>

    <ul class="list-group">
        @foreach ($nodes as $node)
        <li class="list-group-item"><a href="/node/{{$node->id}}">{{ $node->name }} [{{ $node->type->name }}]</a></li>
        @endforeach
    </ul>

    <a class="dropdown-item" data-id="{{$type->id}}" data-toggle="modal-ajax" href="#">test</a>
    <div class="test">
        ???
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModal3Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal3Label">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="http://localhost/js/jquery-3.1.1.slim.min.js"></script>
    <script src="http://localhost/js/tether.min.js"></script>
    <script src="http://localhost/js/bootstrap.min.js"></script>

    <script>
        $("a[data-toggle='modal']").on("click",function () {
            var id = $(this).attr('data-id');
            alert( "ajax start" );
            $.ajax( "http://localhost/ajax" )
                .done(function() {
                    $('.modal-body').text("1234567");
                })
                .fail(function() {
                    $('.modal-body').text("1234567");
                })
                .always(function() {
                    $('.modal-body').text("1234567");
                });
        });

        $("a[data-toggle='modal-ajax']").on("click",function () {

            $.get( "http://localhost/ajax", {userId: 1234}, function( data ) {
                $( ".test" ).html( data );
                alert( "Load was performed." );
            });
        });
    </script>

</body>
</html>
