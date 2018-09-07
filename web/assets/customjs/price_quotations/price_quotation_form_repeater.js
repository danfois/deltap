var PriceQuotationFormRepeater = {
    init: function () {
        var counter = 0;

        $(".repeater").repeater({
            initEmpty: false,
            isFirstItemUndeletable: true,
            defaultValues: {
            },

            show: function () {
                $(this).slideDown();
                counter++;

                $(this).find("input[name*='departureLocation']").val($('#price_quotation_detail_stages_0_departureLocation').val());
                $(this).find("input[name*='arrivalLocation']").val($('#price_quotation_detail_stages_0_arrivalLocation').val());
                $(this).find("input[name*='departureDate']").val($('#price_quotation_detail_stages_0_departureDate').val());
                $(this).find("input[name*='arrivalDate']").val($('#price_quotation_detail_stages_0_arrivalDate').val());
                $(this).find("input[name*='busNumber']").val($('#price_quotation_detail_stages_0_busNumber').val());
                $(this).find("input[name*='passengers']").val($('#price_quotation_detail_stages_0_passengers').val());

                var $id = $(this).find('.itiner_class').attr('id');
                var $href = $(this).find('.itiner_head').attr('href');
                var $title = $(this).find('.itiner_title').text();

                $(this).find('.itiner_class').attr('id', getFirstPart($id, '_') + '_' + (counter + 1));
                $(this).find('.itiner_head').attr('href', getFirstPart($href, '_') + '_' + (counter + 1));
                $(this).find('.itiner_title').text(getFirstPart($title, '#') + '#' + (counter + 1));

                initializeWidgets();
                TypeAheadWidget();
            },
            hide: function (e) {
                if(confirm('Sei sicuro di voler cancellare questo elemento?')) {
                    $(this).slideUp(e);
                    counter--;
                }
            },
            repeaters: [{
                selector: '.repeated-times-repeater',
                isFirstItemUndeletable: true,
                show: function () {
                    $(this).slideDown();
                    $(".time_picker").timepicker({
                        minuteStep: 1,
                        defaultTime: "",
                        showSeconds: 0,
                        showMeridian: !1,
                        snapToStep: !0
                    });
                }
            }]
        })
    }
};


function getFirstPart(str, sym) {
    return str.split(sym)[0];
}

// function getSecondPart(str, sym) { return str.split(sym)[1]; }