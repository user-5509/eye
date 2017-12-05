<div class="container pt-3">
    <div class="row">
        <div class="col-6">
            <button type="button" id="lineCreate" class="btn btn-primary">
                <i class="fa fa-file-o"></i> Создать
            </button>
            <div class="pt-3" id="lineContainer">
                <div class="list-group">
                    @foreach ($lines as $line)
                        <li class="list-group-item list-group-item-action p-1 m-0" id="line-{{ $line->id }}"
                            data-id="{{ $line->id }}">
                            {{ $line->name }}
                        </li>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-6" id="lineAbout">
        </div>
    </div>
</div>

<script type="text/javascript">
    (function() {
        $("title").text("Кросс > тракты");

        function _createModal() {
            let url = "/lines/create-modal",
                props = {
                    _token: "{{ csrf_token() }}"
                };
            $.get(url, props, function (data) {
                actionModal.set(data);
                actionModal.show();
            }).fail(function(data) {
                actionModal.set(data.responseText);
                actionModal.show();
            });;
        }

        $("button#lineCreate").on("click", _createModal);

        // setup context menu
        $.contextMenu({
            selector: '.list-group-item',
            build: function ($trigger, e)
            {
                var items = {};

                items.edit = {
                    name: "Редактировать",
                    icon: "edit",
                    callback: function () {
                        let id = $trigger.data('id'),
                            url = "/lines/edit-modal",
                            props = {
                                _token: "{{ csrf_token() }}",
                                id: id
                            };
                        $.get(url, props, function (data) {
                            actionModal.set(data);
                            actionModal.show();
                        });
                    }
                };

                items.delete = {
                    name: "Удалить",
                    icon: "delete",
                    callback: function () {
                        let id = $trigger.data('id'),
                            url = "/lines/delete-modal",
                            props = {
                                _token: "{{ csrf_token() }}",
                                id: id
                            };
                        $.get(url, props, function (data) {
                            actionModal.set(data);
                            actionModal.show();
                        });
                    }
                };

                return {
                    callback: function (key, options, rootMenu, originalEvent)
                    {
                        //console.dir($('.context-menu-active'));
                    },
                    items: items
                };
            }
        });
    })();
</script>
