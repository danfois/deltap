var genericModalFunction = function(method, url, data) {
    mApp.blockPage({
        overlayColor: "#000000",
        type: "loader",
        state: "info",
        message: "Caricamento..."
    });
    $.ajax({
        method : method,
        url : url,
        data : data,
        dataType: 'html',
        success : function(response) {
            $('#generic_modal_content').html(response);
            $('#generic_modal').modal();
            mApp.unblockPage();
        },
        error : function(e) {
            swal({
                title: "",
                html: e.responseText,
                type: "error",
                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
            });
            mApp.unblockPage();
        }
    });
};