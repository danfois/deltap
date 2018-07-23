var FormRepeater = {
    init: function () {
        var counter = 0;
        $(".repeater").repeater({
            initEmpty: !1, defaultValues: {"text-input": "foo"}, show: function () {
                $(this).slideDown();
                counter++;
                var $id = $(this).find('.itiner_class').attr('id');
                var $href = $(this).find('.itiner_head').attr('href');
                var $title = $(this).find('.itiner_title').text();
                $(this).find('.itiner_class').attr('id', getFirstPart($id, '_') + '_' + (counter + 1) );
                $(this).find('.itiner_head').attr('href', getFirstPart($href, '_') + '_' + (counter + 1) );
                $(this).find('.itiner_title').text(getFirstPart($title, '#') + '#' + (counter + 1));
            }, hide: function (e) {
                $(this).slideUp(e)
            }, repeaters: [{
                selector: '.repeated-times-repeater'
            }]
        }), $("#m_repeater_2").repeater({
            initEmpty: !1, defaultValues: {"text-input": "foo"}, show: function () {
                $(this).slideDown()
            }, hide: function (e) {
                confirm("Are you sure you want to delete this element?") && $(this).slideUp(e)
            }
        })
    }
};

function getFirstPart(str, sym) {
    return str.split(sym)[0];
}

function getSecondPart(str, sym) {
    return str.split(sym)[1];
}

jQuery(document).ready(function () {
    FormRepeater.init()
});