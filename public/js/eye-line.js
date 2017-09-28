class EyeRender {
    static createLineDialog(modal) {
        let modalBody = $("#tmpl").find("#line #create").html();

        modal.find(".modal-body").html(modalBody);
        modal.find(".modal-title").text("Создать тракт");
        modal.find("#exec-title").text("Создать");
        modal.find("#exec").on("click", function () {
            let modal = $("#actionModal-1");

            $.post("http://localhost/line/create/execute",
                {
                    _token: "{{ csrf_token() }}",
                    lineId: modal.find("#line-id").val(),
                    lineName: modal.find("#line-name").val(),
                    lineType: modal.find("#line-type").val()
                },
                function (data) {
                    linesListReload();
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
        modal.find("#line-id").val(lineId);
        modal.find("#line-name").val(lineName);
        modal.find("#line-type").val(lineType);
        modal.find("#exec").on("click", function() {
            $.post( "http://localhost/line/edit/execute",
                {
                    _token  : "{{ csrf_token() }}",
                    lineId  : modal.find("#line-id").val(),
                    lineName: modal.find("#line-name").val(),
                    lineType: modal.find("#line-type").val()
                },
                function( data ) {
                    //let lineId   = modal.find("#line-id").val();
                    //let lineName = modal.find("#line-name").val();
                    //let lineType = modal.find("#line-type").val();
                    let lineIcon = $("tmpl").find("#line-icon #type-" + lineType).html();
                    let line = $("#lines-list").find("li[data-id='" + lineId + "']");

                    line.find("span#name").text(lineName);
                    line.find("span#icon").html(lineIcon);
                    modal.modal("hide");
                }
            );
        });
        modal.modal("show");
    }
}