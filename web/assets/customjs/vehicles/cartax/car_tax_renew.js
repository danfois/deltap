var CarTaxRenew = function(data_array) {
    mApp.blockPage({
        overlayColor: "#000000",
        type: "loader",
        state: "info",
        message: "Caricamento..."
    });

    $.ajax({
        method: 'POST',
        url: 'ajax/renew-cartax',
        data: { 'ids' : JSON.stringify(data_array) },
        success: function(response) {
            alert(response + 'successo');
            mApp.unblockPage();
        },
        error: function(e) {
            alert(e.responseText);
            mApp.unblockPage();
        }
    });
};