$('#prev').on('click', function () {
    var currentPage = getParamByName('page_index') || 0;

    if (currentPage > 0) {
        currentPage = currentPage - 1;
    }
    window.location.href = window.location.href.split('?')[0] + '?page_index=' + currentPage;
});

$('#next').on('click', function () {
    var currentPage = getParamByName('page_index') || 0;

    currentPage = +currentPage + 1;
    window.location.href = window.location.href.split('?')[0] + '?page_index=' + currentPage;
});