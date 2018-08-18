var UnavailabilityBatchDelete = function(data_array) {
    mApp.blockPage({
        overlayColor: "#000000",
        type: "loader",
        state: "info",
        message: "Caricamento..."
    });

    $.ajax({
        method: 'POST',
        url: 'ajax/batch-delete-unavailabilities',
        data: { 'ids' : JSON.stringify(data_array) },
        success: function(response) {
            swal({
                title: "",
                text: "Indisponibilità eliminate con successo!",
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
    });
};