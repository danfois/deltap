function fixChildTableHeight() {
    return 300;
    var height = $('.m-datatable__subtable').find('.dropdown-menu').height;
    if(height < 200) return 300;
    return height + 100;
}