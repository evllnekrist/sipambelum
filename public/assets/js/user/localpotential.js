function resetFilter() {
    $('[name="_title"]').val('');
    $('[name="_subdistrict"]').val('');
    $('[name="_sort_by"]').val('latest');
    getLocalPotentialList(1, true); // auto page 1
}

$(function () {
    console.log('get Listing');
    getLocalPotentialList(1, true);
});
