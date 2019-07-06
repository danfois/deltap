var Tickler = function () {
    genericAjaxRequestWithCallback('GET', 'expiring-maintenances', {}, function (r) {
        $('#manutenzioni').html(r);
    });

    genericAjaxRequestWithCallback('GET', 'expiring-vehicle-costs', {}, function (r) {
        $('#spese_mezzi').html(r);
    });

    genericAjaxRequestWithCallback('GET', 'expiring-loans', {}, function (r) {
        $('#finanziarie').html(r);
    });

};

$(document).ready(function () {
    Tickler();
});