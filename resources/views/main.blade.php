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
        @font-face {
            font-family: "San Francisco";
            font-weight: 400;
            src: url("fonts/SF-UI-Display-Regular.otf")
        }

        html, html a {
            /*-webkit-font-smoothing: antialiased;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.004);*/
            font-family: San Francisco;

            font-smooth: always;
        }

        body {
            font-family: San Francisco;
        }




        .fancytree-container {
            height: 480px;
            width: 100%;
            overflow: auto;
        }

        .tooltip-line.bs-tooltip-right .arrow::before, .tooltip-line.bs-tooltip-auto[x-placement^="right"] .arrow::before {
            margin-top: -3px;
            content: "";
            border-width: 5px 5px 5px 0;
            border-right-color: #007BFF;
        }

        .busy-outer {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,.5);
            z-index:999;
        }

        .busy-inner {
            position: absolute;
            top: 40%;
            left: 50%;
        }
    </style>

    <title></title>
</head>
<body>

<div class="busy-outer" hidden>
    <div class="busy-inner">
        <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-light alert-secondary h5">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#"><span class="h3">&nesear;</span> <b>КРОСС</b><sup><small>&copy;</small></sup></a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav" id="navbar">
                            <li class="nav-item active" id="menuNodes">
                            <a class="nav-link" href="#">Структура</a>
                        </li>
                        <li class="nav-item" id="menuLines">
                            <a class="nav-link" href="#">Тракты</a>
                        </li>
                        <li class="nav-item">
                             <a class="nav-link" href="#" id="menuTypes">Types</a>
                        </li>
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


<div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>


    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="fancytree/jquery.fancytree-all-deps.min.js"></script>
    <script src="js/jquery.contextMenu.min.js"></script>

    <script type="text/javascript">

        function loadNodes(contentContainer, nodeId = null) {
            contentContainer.load(  "http://localhost/content/node/index",
                {
                    _method: "get",
                    _token: "{{ csrf_token() }}",
                    nodeId: nodeId
                },
                function( response, status, xhr ) {
                    if ( status == "error" ) {
                        let msg = "[loadNodes] Sorry but there was an error: ";

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
