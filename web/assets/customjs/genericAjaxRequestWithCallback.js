var genericAjaxRequestWithCallback = function(method, url, data, callback) {
    $.ajax({
        method: method,
        url: url,
        data: data,
        success: function(response) {
            callback(response);
        },
        error: function(e) {
            callback(e.responseText);
        }
    });
};
