var genericDelete = function (url, sentence, data, callback) {
    swal({
        title: "Sei sicuro?",
        text: "La modifica non è reversibile!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Si, Elimina!",
        cancelButtonText: "No, Annulla!",
        reverseButtons: !0
    }).then(function (e) {
        e.value ? genericAjaxRequest('GET', url, data, function() { $('.m_datatable').mDatatable('reload'); $('#generic_modal').modal('hide'); $('#m_table_1').DataTable().ajax.reload(); if(callback !== undefined) {callback();} }) : "cancel" === e.dismiss && swal("Annullato", sentence, "info")
    })
};