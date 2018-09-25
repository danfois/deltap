var goToMap = function(jQueryButtonElement) {

    //mi serve l'oggetto che contiene sia questo bottone che il form di riferimento
    var ParentElement = jQueryButtonElement.closest('.m-accordion__item');

    if(ParentElement === undefined || ParentElement === null) {
        console.log(ParentElement);
        swal({
            title: "",
            text: "Errore durante il calcolo, per maggiori info contattare lo sviluppatore",
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
    }

    var linkMappa = 'https://www.google.it/maps/dir/' + startLocation + '/' + endLocation;

    var win = window.open(linkMappa, '_blank');
    win.focus();
};