$(document).ready(function() {
    $('.m_datatable').on('click', '.dropdown-item', function() {
        $('.highlighted_row').removeClass('highlighted_row');
        $(this).closest('tr').find('td').addClass('highlighted_row');
    });
});