function compilatePayments() {
    if($('#salary_employee').val() != '') {
        var employee = $('#salary_employee option:selected').text();
    } else {
        var employee = '';
    }
    var year = $('#salary_year option:selected').text();
    var month = $('#salary_month option:selected').text();
    var amount = $('#salary_amount').val();

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd = '0'+dd
    }

    if(mm<10) {
        mm = '0'+mm
    }

    today = dd + '/' + mm + '/' + yyyy;

    var repeater = $('.repeater');

    var accountAmounts = $('.repeater').find("input[id*='amount']");
    var accountDate = $('.repeater').find("input[id*='paymentDate']");
    var accountCausal = $('.repeater').find("input[id*='causal']");

    accountAmounts.each(function(i) {
        if($(this).val() == '') {
            $(this).val(amount);
        }
    });

    accountDate.each(function(i) {
        if($(this).val() == '') {
            $(this).val(today);
        }
    });

    accountCausal.each(function(i) {
        if($(this).val() == '') {
            $(this).val('Acconto stipendio del ' + month + '/' + year + ' di ' + employee);
        }
    })
}

$(document).ready(function() {
    $('#compila_acconti').on('click', function(){
        compilatePayments();
    })
});