var deleteUnavailability = function (id) {
    swal({
        title: "Sei sicuro?",
        text: "La modifica non è reversibile!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Si, Elimina!",
        cancelButtonText: "No, Annulla!",
        reverseButtons: !0
    }).then(function (e) {
        e.value ? deleteAjaxUnavailability(id) : "cancel" === e.dismiss && swal("Annullato", "L'indisponibilità non è stata eliminata.", "info")
    })
};

function deleteAjaxUnavailability(id) {
    mApp.blockPage({
        overlayColor: "#000000",
        type: "loader",
        state: "info",
        message: "Caricamento..."
    });
    $.ajax({
        method: 'GET',
        url: 'ajax/delete-unavailability-' + id,
        data: {'id': id},
        dataType: 'html',
        success: function (response) {
            swal({
                title: "",
                html: 'Indisponibilità eliminata con successo',
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