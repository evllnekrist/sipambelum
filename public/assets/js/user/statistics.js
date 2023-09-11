console.log('STATISTICS 23-07-03 01')

$(function(){
  getStatistics_LegalProduct_ByTime('#LegalProductStatistic')
  // getStatistics_Visitor_ByTime('#VisitorStatistic')
  getStatistics_Satisfaction_Summary('#SatisfactionStatistic')

  $("#in_score").rating({
    hoverOnClear: false,
    // theme: 'krajee-svg',
    theme: 'krajee-fas',
    step: 1,
    stars: 5,
    tabindex: 0,
    mouseEnabled:true,
    clearValue: 0,
    hoverChangeStars:true,
    hoverChangeCaption:true,
    showClear: false,
    showCaption: true,
    zeroAsNull: true,
    displayOnly: false,
    // filledStar:'<span class="krajee-icon krajee-icon-star"></span>',
    // emptyStar:'<span class="krajee-icon krajee-icon-star"></span>',
    starCaptions: {0:'<b>Belum Dinilai</b>', 1:'<b>Sangat Kurang </b>', 2:'<b>Kurang</b>', 3:'<b>Cukup (Memadai)</b>', 4:'<b>Baik</b>', 5: '<b>Sangat Baik</b>'},
    starCaptionClasses: {0: 'text-grey', 1: 'txt-strawberry', 2: 'text-warning', 3: 'text-info', 4: 'text-primary', 5: 'text-success'}
  });

  $("#btn-submit-add").click(function(e){
    console.log('awokwowwkok');
    const form = document.getElementById('form');
    form.reportValidity()
    if (!form.checkValidity()) {
    } else if($('[name="check_validity"]').val() == 0){
      Swal.fire({
        position: 'top-end',
        icon: 'warning',
        html: 'Masih ada isian yang belum valid, mohon diperbaiki',
        showConfirmButton: false,
        timer: 2000
      });
    } else {
      $('#satisfaction-form-loading').html('mengirimkan review...');
      $('#form').hide();
      const formData = new FormData(form);
      // for (const [key, value] of formData) {
      //   console.log('»', key, value)
      // }
      axios.post(baseUrl+'/api/post-satisfaction', formData, apiHeaders)
      .then(function (response) {
        console.log('response..',response);
        if(response.status == 200 && response.data.status) {
          Swal.fire({
            icon: 'success',
            width: 600,
            title: "Berhasil",
            // html: "...",
            confirmButtonText: 'Ya, terima kasih',
          });
          window.location = baseUrl+'/statistik';
        }else{
          Swal.fire({
            icon: 'warning',
            width: 600,
            title: "Gagal",
            html: response.data.message,
            confirmButtonText: 'Ya',
          });
        }
        $('#satisfaction-form-loading').html('');
        $('#form').show();
      })
      .catch(function (error) {
        Swal.fire({
          icon: 'error',
          width: 600,
          title: "Error",
          html: error.message,
          confirmButtonText: 'Ya',
        });
        $('#satisfaction-form-loading').html('');
        $('#form').show();
      });
    }
  });

});
