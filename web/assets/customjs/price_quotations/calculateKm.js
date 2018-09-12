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
        var sfc = undefined;
        var rtc = undefined;

        startLocation = ParentElement.find("input[name*='departureLocation']").val();
        endLocation = ParentElement.find("input[name*='arrivalLocation']").val();
        sfc = ParentElement.find('#company_departure').is(':checked');
        rtc = ParentElement.find('#company_arrival').is(':checked');

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
        var PriceField = ParentElement.find("input[name*='[price]']");

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
        data: { 'startPoint' : startLocation, 'endPoint' : endLocation, 'sfc' : sfc, 'rtc' : rtc},
        dataType : 'json',
        success: function(response) {
            console.log(response);
            KmField.val(Math.round(response.km / 1000));
            TimeField.val(Math.round(response.time / 60));
            mApp.unblockPage();
        },
        error: function(e) {
            console.log(e);
            swal({
                title: "Calcolo non riuscito",
                html: e.responseText,
                type: "warning",
                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
            });
            mApp.unblockPage();
        }
    })
};