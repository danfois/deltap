var Tickler = function () {
    genericAjaxRequestWithCallback('GET', 'expiring-maintenances', {}, function (r) {
        $('#manutenzioni').html(r)
    });
};

$(document).ready(function () {
    Tickler();
});