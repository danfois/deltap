var setActive = function (id, url) {
    genericAjaxRequest('GET', url, {'id' : id});
};