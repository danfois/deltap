var calculateKm = function(jQueryButtonElement) {

    //mi serve l'oggetto che contiene sia questo bottone che il form di riferimento
    var ParentElement = jQueryButtonElement.closest('.m-accordion__item');

    if(ParentElement === undefined || ParentElement === null) {
        console.log(ParentElement);
        swal({
            title: "",
            text: "Errore durante il calcolo, per maggior info contattare lo sviluppatore",
            type: "error",
            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
        });
        return;
    } else {
        var startLocation = undefined;
        var endLocation = undefined;

        startLocation = ParentElement.find("input[name*='departureLocation']").val();
        endLocation = ParentElement.find("input[name*='arrivalLocation']").val();

        if(startLocation === undefined || endLocation === undefined) {
            swal({
                title: "",
                text: "Partenza e Arrivo non devono essere vuoti",
                type: "error",
                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
            });
        }

        console.log(startLocation + ' ' + endLocation);

        var KmField = ParentElement.find('input[name*="km"]');
        var TimeField = ParentElement.find('input[name*="estimatedTime"]');

    }

    mApp.blockPage({
        overlayColor: "#000000",
        type: "loader",
        state: "info",
        message: "Calcolo Km e Tempo..."
    });
    $.ajax({
        method : 'GET',
        url: '/distance-matrix',
        data: { 'startPoint' : startLocation, 'endPoint' : endLocation},
        dataType : 'json',
        success: function(response) {
            if(response.rows[0].elements[0].status === 'NOT_FOUND') {
                swal({
                    title: "Calcolo non riuscito",
                    text: 'Impossibile calcolare tempo e km per questo tragitto. Provare a cambiare partenza e arrivo',
                    type: "warning",
                    confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                });
                mApp.unblockPage();
                return;
            }
            console.log(response);
            // KmField.val(response.rows[0].elements[0].distance.text);
            // TimeField.val(response.rows[0].elements[0].duration.text);
            KmField.val(response.rows[0].elements[0].distance.value / 1000);
            TimeField.val(response.rows[0].elements[0].duration.value / 60);
            mApp.unblockPage();
        },
        error: function(e) {
            console.log(e);
            mApp.unblockPage();
        }
    })
};