var calculateTotal = function() {
    var imponibile = $('#tot_imponibile');
    var lordo = $('#tot_lordo');

    var invoiceItems = $('.repeater').find("input[name*='totTaxExc']");
    var vats = $('.repeater').find("input[name*='vat']");

    var totaleImponibile = 0;
    var totaleLordo = 0;

    invoiceItems.each(function(i, e) {
        var price = parseFloat(e.value);
        var vat = parseInt(vats[i].value);

        totaleImponibile += price;
        totaleLordo += price + ((price / 100) * vat);
    });

    imponibile.val(totaleImponibile);
    lordo.val(Math.round(totaleLordo * 100) / 100);
};