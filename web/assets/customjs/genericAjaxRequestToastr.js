var genericAjaxRequestToastr = function(method, url, data, callback) {
    $.ajax({
        method: method,
        url: url,
        data: data,
        success: function(response) {
            toastr.success(response);
        },
        error: function(e) {
            swal({
                title: "",
                html: e.responseText,
                type: "error",
                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
            });
        }
    });
    callback();
};
