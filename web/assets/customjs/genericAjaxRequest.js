var genericAjaxRequest = function(method, url, data) {
    mApp.blockPage({
        overlayColor: "#000000",
        type: "loader",
        state: "info",
        message: "Caricamento..."
    });
    $.ajax({
        method: method,
        url: url,
        data: data,
        success: function(response) {
            swal({
                title: "",
                text: response,
                type: "success",
                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
            });
            mApp.unblockPage();
        },
        error: function(e) {
            swal({
                title: "",
                html: e.responseText,
                type: "error",
                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
            });
            mApp.unblockPage();
        }
    })
};
