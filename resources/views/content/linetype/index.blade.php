<div class="container pt-3">
    <div class="row">
        <div class="col-4">
            <button type="button" id="typeCreate" class="btn btn-outline-primary">Создать</button>
            <div class="pt-3" id="typeContainer">
                <div class="list-group">
                    @foreach ($types as $type)
                        <li class="list-group-item list-group-item-action p-1 m-0" id="type-{{ $type->id }}"
                            data-id="{{ $type->id }}">
                            {{--<a href="/admin/nodetypes/{{ $type->id }}" class="nav-link" data-link="ajax">--}}
                            <i class="fa fa-{{ $type->icon }}"></i>
                            {{ $type->name }}
                            {{--</a>--}}
                        </li>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-6" id="typeAbout">
        </div>
    </div>
</div>

<script type="text/javascript">
    (function() {
        $("title").text("Кросс > типы трактов");

        function _createModal() {
            let url = "/admin/linetypes/create-modal",
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

        $("button#typeCreate").on("click", _createModal);

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
                            url = "/admin/linetypes/edit-modal",
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
                            url = "/admin/linetypes/delete-modal",
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
