let app = (function() {

    // Загрузим конфиг из data/config.json
    let config = {};

    let ui = {
        $body: $('body'),
        $menu: $('#navbar'),
        //$pageTitle: $('#page-title'),
        $content: $('#content'),
        $modal: $('#actionModal')
    };

    let section = '',
        token = '';

    // Загрузка контента по странице
    function _loadSection(url) {
        console.log('ajax url: ' + url);
        $.get(url, {_token: token}, function(html) {
            ui.$menu.find('li').removeClass('active');
            ui.$menu.find('li[data-menu="' + url.split('/')[1] + '"]').addClass('active');
            ui.$content.html(html);
            _bindHandlers();
        }).fail(function(data) {
            ui.$content.html(data.responseText);
        });
    }

    // Клик по ссылке
    function _navigate(e) {
        e.stopPropagation();
        e.preventDefault();

        let href = $(e.target).attr('href');

        _loadSection(href);
        history.pushState({page: href}, '', href);
    }

    // Кнопки Назад/Вперед
    function _popState(e) {
        var page = (e.state && e.state.page) || config.mainPage;
        _loadSection(page);
    }

    // Привязка событий
    function _bindHandlers() {
        ui.$body.off();
        ui.$body.on('click', '[data-link="ajax"]', _navigate);
        window.onpopstate = _popState;
    }

    // Старт приложения: привязка событий
    function _start() {
        _loadSection(section);
        _bindHandlers();
    }

    // Инициализация приложения: загрузка конфига и старт
    function init(props) {
        section = props.section;
        token = props.token;

        _start();
    }

    // Возвращаем наружу
    return {
        init: init,
        $modal: () => ui.$modal
    }
})();

let makeModal = function(props) {
    let $modal= props.$modal;

    return {
        $modal: () => $modal,
        set: (content) => $modal.find('.modal-content').html(content),
        reset: (content) => $modal.find('.modal-content').html(''),
        show: () => $modal.modal('show'),
        hide: () => $modal.modal('hide')
    }
};


// Запуск приложения
//$(document).ready(app.init);