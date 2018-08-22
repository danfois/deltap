var deleteInsuranceSuspension = function (id) {
    swal({
        title: "Sei sicuro?",
        text: "La modifica non è reversibile!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Si, Elimina!",
        cancelButtonText: "No, Annulla!",
        reverseButtons: !0
    }).then(function (e) {
        e.value ? deleteAjaxInsuranceSuspension(id) : "cancel" === e.dismiss && swal("Annullato", "La sospensione non è stata eliminata.", "info")
    })
};

function deleteAjaxInsuranceSuspension(id) {
    mApp.blockPage({
        overlayColor: "#000000",
        type: "loader",
        state: "info",
        message: "Caricamento..."
    });
    $.ajax({
        method: 'GET',
        url: 'ajax/delete-suspension',
        data: {'id': id },
        dataType: 'html',
        success: function (response) {
            swal({
                title: "",
                html: 'Sospensione Eliminata con successo',
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