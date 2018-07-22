var FormRepeater = {
    init: function () {
        $(".repeater").repeater({
            initEmpty: !1, defaultValues: {"text-input": "foo"}, show: function () {
                $(this).slideDown();
                var $id = $('.itiner_class').last().attr('id');
                var $href = $('.itiner_head').last().attr('href');
                var $title = $('.itiner_title').last().text();
                $('.itiner_class').last().attr('id', getFirstPart($id, '_') + '_' + (parseInt(getSecondPart($id, '_')) + 1));
                $('.itiner_head').last().attr('href', getFirstPart($href, '_') + '_' + (parseInt(getSecondPart($href, '_')) + 1));
                $('.itiner_title').last().text(getFirstPart($title, '#') + '#' + (parseInt(getSecondPart($title, '#')) + 1));
            }, hide: function (e) {
                $(this).slideUp(e)
            }
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