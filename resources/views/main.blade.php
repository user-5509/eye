<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="_token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-multiselect.css" rel="stylesheet">
    <link href="/fancytree/skin-win8/ui.fancytree.min.css" rel="stylesheet">
    <link href="/css/jquery.contextMenu.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css">


    <style type="text/css">
        @font-face {
            font-family: "SF-UI-Display-Regular";
            font-weight: 400;
            src: url("/fonts/SF-UI-Display-Regular.otf")
        }

        html, body {
            /*-webkit-font-smoothing: antialiased;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.004);*/
            font-family: SF-UI-Display-Regular;
            font-smooth: always;
        }

        .tree {
            font-size: 12px;
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
            background: rgba(0, 0, 0, .5);
            z-index: 999;
        }

        .busy-inner {
            position: absolute;
            top: 40%;
            left: 50%;
        }

        .icon-letter {
            margin-top: -2px;
            font-size: 20px;
        }

      /*.multiselect-container {
          width: 100% !important;
      }*/
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
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="/"><span class="h3">&nesear;</span> <b>КРОСС</b><sup>
                        <small>&copy;</small>
                    </sup></a>
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav" id="navbar">
                        <li class="nav-item active" data-menu="nodes" id="menuNodes">
                            <a href="/nodes" class="nav-link" data-link="ajax">Структура</a>
                        </li>
                        <li class="nav-item" data-menu="lines" id="menuLines">
                            <a href="/lines" class="nav-link" data-link="ajax">Тракты</a>
                        </li>
                        <li class="nav-item" data-menu="admin" id="menuAdmin">
                            <a href="/admin"  class="nav-link" data-link="ajax">Admin</a>
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

<script src="/js/jquery-3.2.1.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-multiselect.js"></script>
<script src="/fancytree/jquery.fancytree-all-deps.min.js"></script>
<script src="/js/jquery.contextMenu.min.js"></script>
{{--<script src="js/eye-line.js"></script>--}}
<script src="/js/main.js"></script>

<script type="text/javascript">
    let actionModal = makeModal({$modal: $('#actionModal')});

    $(document).ready(function() {
        let props = { section: '{{ $section }}', token: '{{ csrf_token() }}' };
        app.init(props);
    });

/*
    $(function () {
        var _load = function (url) {
            $.get(url).done(function (data) {
                $("#content").html(data);
            })
        };

        var _navigate = function (e) {
            e.stopPropagation();
            e.preventDefault();

            var $this = $(this),
                url = $this.attr("href"),
                title = $this.text();

            history.pushState({
                url: url,
                title: title
            }, title, url);

            document.title = title;

            _load(url);
        }

        $(document).off();
        $(document).on('click', 'a[data-link="ajax"]', _navigate);

        $(window).on('popstate', function (e) {
            var state = e.originalEvent.state;
            if (state !== null) {
                document.title = state.title;
                _load(state.url);
            } else {
                document.title = 'Кросс';
                $("#content").empty();
            }
        });

        //$("title").text("Кросс");
        //$('[data-toggle="tooltip"]').tooltip();

        //_bindHandlers();

        window.onpopstate = _popState;
        // default view
        loadContent('nodes');
        toggleNavbar('#menuNodes');
    });

    function loadContent(path, container = '#content') {
        $(container).load('/getSection/' + path,
            {_method: "get", _token: "{{ csrf_token() }}"},
            function (response, status, xhr) {
                if (status == "error") {
                    var msg = "[" + path + "] Sorry but there was an error: ";
                    alert(msg + xhr.status + " " + xhr.statusText);
                }
            }
        );
    }

    function toggleNavbar(name) {
        $("ul.navbar-nav").find(".active").removeClass("active");
        $("ul.navbar-nav").find("#menu-" + name).addClass("active");
    }

    $("#menuNodes").on("click", function (e) {
        e.stopPropagation();
        e.preventDefault();
        var href = $(e.target).attr('href');
        history.pushState({page: href}, '', href);
        loadContent('nodes');
        toggleNavbar('#menuNodes');
    });

    $("#menuLines").on("click", function (e) {
        e.stopPropagation();
        e.preventDefault();
        var href = $(e.target).attr('href');
        history.pushState({page: href}, '', href);
        loadContent('lines');
        toggleNavbar('#menuLines');
    });

    $("#menuAdmin").on("click", function (e) {
        e.stopPropagation();
        e.preventDefault();
        var href = $(e.target).attr('href');
        history.pushState({page: href}, '', href);
        loadContent('admin');
        toggleNavbar('#menuAdmin');
    });
*/
</script>
</body>
</html>
