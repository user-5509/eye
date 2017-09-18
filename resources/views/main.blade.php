<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap -->
    <link href="http://localhost/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://localhost/fancytree/skin-win8/ui.fancytree.min.css" rel="stylesheet">
    <link href="http://localhost/css/jquery.contextMenu.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">


    <style type="text/css">
        .fancytree-container {
            height: 480px;
            width: 100%;
            overflow: auto;
        }
    </style>

    <title></title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-toggleable-md navbar-light bg-faded h5">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#"><span class="h3">&nesear;</span> <b>КРОСС</b><sup><small>&copy;</small></sup></a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#" id="menuNodes">Структура</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="menuLines">Тракты</a>
                        </li>
                        <li class="nav-item">
                             <a class="nav-link" href="#" id="menuTypes">Типы</a>
                         </li>
                        {{--  <li class="nav-item">
                             <a class="nav-link disabled" href="#">Пусто</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link disabled" href="#">Пусто</a>
                         </li>--}}
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-12" id="content">
        </div>
    </div>
</div>


    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="fancytree/jquery.fancytree-all-deps.min.js"></script>
    <script src="js/jquery.contextMenu.min.js"></script>
    <script src="js/jquery.fancytree.contextMenu.js"></script>

    <script type="text/javascript">
        function loadNodes(contentContainer)
        {
            contentContainer.load(  "http://localhost/content/node/index",
                { _method: "get", _token: "{{ csrf_token() }}" },
                function( response, status, xhr )
                {
                    if ( status == "error" ) {
                        var msg = "[loadNodes] Sorry but there was an error: ";
                        alert( msg + xhr.status + " " + xhr.statusText );
                    }
                }
            );
        }

        function loadLines(contentContainer)
        {
            contentContainer.load(  "http://localhost/content/line/index",
                { _method: "get", _token: "{{ csrf_token() }}" },
                function( response, status, xhr )
                {
                    if ( status == "error" ) {
                        var msg = "[loadLines] Sorry but there was an error: ";
                        alert( msg + xhr.status + " " + xhr.statusText );
                    }
                }
            );
        }

        function loadTypes(contentContainer)
        {
            contentContainer.load(  "http://localhost/content/type/index",
                { _method: "get", _token: "{{ csrf_token() }}" },
                function( response, status, xhr )
                {
                    if ( status == "error" ) {
                        var msg = "[loadLines] Sorry but there was an error: ";
                        alert( msg + xhr.status + " " + xhr.statusText );
                    }
                }
            );
        }

        function loadContent()
        {
            contentContainer.load(  "http://localhost/content/line/index",
                { _method: "get", _token: "{{ csrf_token() }}" },
                function( response, status, xhr )
                {
                    if ( status == "error" ) {
                        var msg = "[loadLines] Sorry but there was an error: ";
                        alert( msg + xhr.status + " " + xhr.statusText );
                    }
                }
            );
        }

        // default...
        $(function()
        {
            $('[data-toggle="tooltip"]').tooltip();

            loadNodes($('#content'));
        });

        $("#menuNodes").on("click",function ()
        {
            loadNodes($('#content'));
            $( "ul.navbar-nav" ).find( ".active" ).removeClass("active");
            $('#menuNodes').addClass("active");
        });

        $("#menuLines").on("click",function ()
        {
            loadLines($('#content'));
            $( "ul.navbar-nav" ).find( ".active" ).removeClass("active");
            $('#menuLines').addClass("active");
        });

        $("#menuTypes").on("click",function ()
        {
            loadTypes($('#content'));
            $( "ul.navbar-nav" ).find( ".active" ).removeClass("active");
            $('#menuTypes').addClass("active");
        });
    </script>
</body>
</html>