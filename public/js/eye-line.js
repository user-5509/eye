class EyeSystem {
    static CSRF() {
        return $('meta[name="_token"]').attr('content');
    }
}

class EyeWidgets {
    static lineListWrapper() {
        return $("#tmpl").find("#line #list-wrapper");
    }
    static lineListItem() {
        return $("#tmpl").find("#line #list-item");
    }
}

class EyeRender {
    static createLineDialog(modal) {
        let modalBody = $("#tmpl").find("#line #create").html();

        modal.find(".modal-body").html(modalBody);
        modal.find(".modal-title").text("Создать тракт");
        modal.find("#exec-title").text("Создать");
        modal.find("#exec").off();
        modal.find("#exec").on("click", function () {
            let modal = $("#actionModal-1");

            $.post("http://localhost/line/create/execute",
                {
                    _token: EyeSystem.CSRF(),
                    lineId: modal.find("#line-id").val(),
                    lineName: modal.find("#line-name").val(),
                    lineType: modal.find("#line-type").val()
                },
                function (data) {
                    EyeRender.reloadLinesList();
                    $('#actionModal-1').modal('hide');
                }
            );
        });
        modal.modal('show');
    }
    static editLineDialog(modal, $trigger) {
        let lineId =    $trigger.data('id');
        let lineName =  $trigger.find("#name").text().trim();
        let lineType =  $trigger.data('type');
        let modalBody = $("#tmpl").find("#line #edit").html();

        modal.find(".modal-body").html(modalBody);
        modal.find(".modal-title").text("Редактировать тракт");
        modal.find("#exec-title").text("Сохранить");
        modal.find("#line-id").val(lineId);
        modal.find("#line-name").val(lineName);
        modal.find("#line-type").val(lineType);
        modal.find("#exec").on("click", function() {
            $.post( "http://localhost/line/edit/execute",
                {
                    _token  : EyeSystem.CSRF(),
                    lineId  : modal.find("#line-id").val(),
                    lineName: modal.find("#line-name").val(),
                    lineType: modal.find("#line-type").val()
                },
                function( data ) {
                    //let lineId   = modal.find("#line-id").val();
                    //let lineName = modal.find("#line-name").val();
                    //let lineType = modal.find("#line-type").val();
                    let lineIcon = $("tmpl").find("#line #icon #type-" + lineType).html();
                    let line = $("#lines-list").find("li[data-id='" + lineId + "']");

                    line.find("span#name").text(lineName);
                    line.find("span#icon").html(lineIcon);
                    modal.modal("hide");
                }
            );
        });
        modal.modal("show");
    }
    static async reloadLinesList() {
        let listContainer = $("#listContainer");
        let response = await fetch("http://localhost/content/line/list", { _token: EyeSystem.CSRF() });
        let lines = await response.json();

        listContainer.html(EyeWidgets.lineListWrapper().html());

        lines.forEach((line)=>{
            let lineTemplate = EyeWidgets.lineListItem();

            lineTemplate.find("a").attr("id", "line-" + line.id);
            lineTemplate.find("a").attr("data-id", line.id);
            lineTemplate.find("a").attr("data-type", line.type);
            lineTemplate.find("#name").text(line.name);
            lineTemplate.find("#icon").html($("#tmpl").find("#line #icon #type-" + line.type).html());

            listContainer.find("#lines-list").append(lineTemplate.html());
        });

        listContainer.find(".list-group-item").on("click", function () {
            let lineId = $(this).data("id");

            $("#lineAbout").load("http://localhost/content/line/about",
                {
                    _method:    "get",
                    _token:     "{{ csrf_token() }}",
                    lineId:     lineId
                },
                function (response, status, xhr) {
                    if (status === "error") {
                        let msg = "[lineAbout] Sorry but there was an error: ";

                        alert(msg + xhr.status + " " + xhr.statusText);
                    }
                }
            );

            $("#lines-list").find(".list-group-item-primary").removeClass(".list-group-item-primary");
            $(this).addClass(".list-group-item-primary");
        });

        console.log("list reload:" + lines);
    }
}