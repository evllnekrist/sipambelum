function resetFilter() {
    $('[name="_title"]').val('');
    $('[name="_subdistrict"]').val('');
    $('[name="_sort_by"]').val('latest');
    getLocalPotentialList(1, true); // auto page 1
}
// JavaScript code to handle the button click event for subdistrict details
$(document).on('click', '.subdistrict-details-btn', function () {
    var subdistrictNames = $(this).data('subdistrict').split(',');
    var subdistrictDetails = subdistrictNames.map(function (sub, index) {
        var detailNumber = index + 1; // Start counting from 1
        return '<p>' + detailNumber + '. Kecamatan ' + sub + '</p>';
    }).join('');

    // Get the LocalPotential name
    var localPotentialName = $(this).closest('.fr-grid-deatil').find('.fr-can-name a').text();

    // Set the modal title
    $('#subdistrictDetailModalLabel').html('Detail Kecamatan (' + localPotentialName + ')');

    // Insert subdistrict details into the modal body
    $('#subdistrictDetailBody').html(subdistrictDetails);
});

$(function () {
    console.log('get Listing');
    getLocalPotentialList(1, true);
});
