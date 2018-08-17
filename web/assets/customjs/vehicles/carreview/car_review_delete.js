var deleteCarReview = function (id) {
    swal({
        title: "Sei sicuro?",
        text: "La modifica non è reversibile!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Si, Elimina!",
        cancelButtonText: "No, Annulla!",
        reverseButtons: !0
    }).then(function (e) {
        e.value ? deleteAjaxCarTax(id) : "cancel" === e.dismiss && swal("Annullato", "La revisione non è stata eliminata.", "info")
    })
};

function deleteAjaxCarTax(id) {
    mApp.blockPage({
        overlayColor: "#000000",
        type: "loader",
        state: "info",
        message: "Caricamento..."
    });
    $.ajax({
        method: 'GET',
        url: 'ajax/delete-carreview-' + id,
        data: {'id': id},
        dataType: 'html',
        success: function (response) {
            swal({
                title: "",
                html: 'Revisione eliminata con successo',
                type: "success",
                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
            });
            $('.m_datatable').mDatatable('reload');
            mApp.unblockPage();
        },
        error: function (e) {
            swal({
                title: "",
                html: e.responseText,
                type: "error",
                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
            });
            mApp.unblockPage();
        }
    })
}