var calculateTotal = function() {
    var imponibile = $('#da_pagare');
    var lordo = $('#pagato');
    var importo = $('#salary_amount').val();

    var invoiceItems = $('.repeater').find("input[name*='amount']");

    var totaleImponibile = 0;

    invoiceItems.each(function(i, e) {
        var price = parseFloat(e.value);

        totaleImponibile += price;
    });

    imponibile.val(importo - totaleImponibile);
    lordo.val(totaleImponibile);
};