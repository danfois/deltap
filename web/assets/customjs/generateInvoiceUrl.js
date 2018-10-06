var generateInvoiceUrl = function(type, datatype, data) {
    var baseUrl = '/generate-invoice?';

    if(type !== 'issued' && type !== 'received') {
        alert('Tipo di fattura richiesta errato');
        return false;
    }

    var finalUrl = baseUrl + 'type=' + type + '&datatype=' + datatype + '&data=[' + data.join(',') + ']';
    window.location.href = finalUrl;
};