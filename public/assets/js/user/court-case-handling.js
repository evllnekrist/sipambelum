// console.log('COURT CASE HANDLING 21-06-31 01')

function resetFilterCCH(){
  $('[name="_title"]').val('');
  $('[name="_year"]').val('1945;'+new Date().getFullYear());
  $('[name="_case_status"]').val('');
  $('[name="_case_type"]').val('');
  $('[name="_case_classification"]').val('');
  $('[name="_sort_by"]').val('latest');
  getCCHList(); // auto page 1
}

$(function(){
  getCCHList();
});
