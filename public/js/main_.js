var app = (function() {

    // Загрузим конфиг из data/config.json
    let config = {};

    let ui = {
        $body: $('body'),
        $menu: $('#navbar'),
        //$pageTitle: $('#page-title'),
        $content: $('#content')
    };

    let currentSection = '',
        token = '';

    // Загрузка контента по странице
    function _loadSection(section) {
        var url = '/getSection/' + section,
            menu = config.pages[section].menu;

        $.get(url, {_token: token}, function(html) {
            ui.$menu.find('li').removeClass('active');
            ui.$menu.find('li[data-menu="' + menu + '"]').addClass('active');
            ui.$content.html(html);
            _bindHandlers();
        });
    }

    // Клик по ссылке
    function _navigate(e) {
        e.stopPropagation();
        e.preventDefault();

        var href = $(e.target).attr('href');
        if(!localStorage.currentHref || localStorage.currentHref != href) {
            _loadSection(href);
            history.pushState({page: href}, '', href);
            localStorage.currentHref = href;
        }
    }

    // Кнопки Назад/Вперед
    function _popState(e) {
        var page = (e.state && e.state.page) || config.mainPage;
        _loadSection(page);
    }

    // Привязка событий
    function _bindHandlers() {
        ui.$body.off();
        ui.$body.on('click', 'a[data-link="ajax"]', _navigate);
        window.onpopstate = _popState;
    }

    // Старт приложения: привязка событий
    function _start() {
        _loadSection(currentSection);
        _bindHandlers();
    }

    // Инициализация приложения: загрузка конфига и старт
    function init(params) {
        currentSection = params.section;
        token = params.token;
        $.getJSON('/data/config.json', function(data) {
            config = data;
            _start();
        });
    }

    // Возвращаем наружу
    return {
        init: init
    }
})();

// Запуск приложения
//$(document).ready(app.init);