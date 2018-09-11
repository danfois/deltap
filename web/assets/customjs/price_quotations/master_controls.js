var MainControls = function () {
    var StartTime = $('#main_start_time').val();
    var EndTime = $('#main_end_time').val();
    var Leftouts = $('#main_leftouts').val();
    var MainDays = {
        0: $('#repeated_day1').is(':checked'),
        1: $('#repeated_day2').is(':checked'),
        2: $('#repeated_day3').is(':checked'),
        3: $('#repeated_day4').is(':checked'),
        4: $('#repeated_day5').is(':checked'),
        5: $('#repeated_day6').is(':checked'),
        6: $('#repeated_day7').is(':checked')
    };

    //Tutti gli input che mi servono sono all'interno di elementi con queste classi
    var Itineraries = $('.m-accordion__item');

    //Inizializzo gli array che conterranno gli input da riempire/modificare
    var startTimes = [];
    var endTimes = [];
    var leftouts = [];
    var repeatedDays = [];

    //Trova i vari input che devono essere riempiti
    Itineraries.each(function() {
        startTimes.push($(this).find("input[name*='start_time']"));
        endTimes.push($(this).find("input[name*='end_time']"));
        leftouts.push($(this).find("input[name*='leftouts']"));
        var repDays = [];
        for(var i = 1; i < 8; i++) {
            repDays.push($(this).find("input" + "[value=" + i + "]"));
        }
        repeatedDays.push(repDays);
    });

    //iterazione Orari Partenza
    startTimes.forEach(function(el) {
        el.val(StartTime);
    });

    //iterazione Orari Arrivo
    endTimes.forEach(function(el) {
        el.val(EndTime);
    });

    //iterazione tranne
    leftouts.forEach(function(el) {
        el.val(Leftouts);
    });

    //iterazione delle checkbox, un po più complessa perchè è un array multidimensionale
    repeatedDays.forEach(function(el) {
        el.forEach(function(i, index) {
            if(MainDays[index]) i.prop('checked', true);
        });
    });

    alert('Impostazioni Itinerari Modificate!');

};


jQuery(document).ready(function() {
    $('#main_leftouts').tagsInput({
        width:'inherit',
        height:'inherit',
        defaultText: 'gg/mm/yyyy'
    });
});

/*
 Il flow deve essere:
     - Individuare e salvare i dati del main control - OK
     - Individuare i campi da modificare delle varie tappe - OK
     - Modificare quei campi - OK

 Ora è necessario fare in modo che quando le tappe vengono clonate siano già precompilate,
 ma per questo bisogna modificare price_quotation_details.js - OK

 */