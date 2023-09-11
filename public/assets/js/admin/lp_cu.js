console.log('LP IDX V-23-06-28 01')
console.log('baseUrl ',baseUrl)

$(function(){
  $("#input-file").fileinput();

  $("#btn-submit-add").click(function(e){
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
      $('#loading').show();
      $('#form').hide();
      const formData = new FormData(form);
      // for (const [key, value] of formData) {
      //   console.log('»', key, value)
      // }
      axios.post(baseUrl+'/api/lp/post-add', formData, apiHeaders)
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
          window.location = baseUrl+'/admin-jdih-katkab/lp';
        }else{
          Swal.fire({
            icon: 'warning',
            width: 600,
            title: "Gagal",
            html: response.data.message,
            confirmButtonText: 'Ya',
          });
        }
        $('#loading').hide();
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
        $('#loading').hide();
        $('#form').show();
      });
    }
  });

  $("#btn-submit-edit").click(function(e){
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
      $('#loading').show();
      $('#form').hide();
      const formData = new FormData(form);
      // for (const [key, value] of formData) {
      //   console.log('»', key, value)
      // }
      axios.post(baseUrl+'/api/lp/post-edit', formData, apiHeaders)
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
          window.location = baseUrl+'/admin-jdih-katkab/lp';
        }else{
          Swal.fire({
            icon: 'warning',
            width: 600,
            title: "Gagal",
            html: response.data.message,
            confirmButtonText: 'Ya',
          });
        }
        $('#loading').hide();
        $('#form').show();
      })
      .catch(function (error) {
        Swal.fire({
          icon: 'error',
          width: 600,
          title: "Error",
          html: error,
          confirmButtonText: 'Ya',
        });
        $('#loading').hide();
        $('#form').show();
      });
    }
  });

  $('.legal-product-type').on('change', function() {
    let value2 =  $(this).find(':selected').data("value2")
    $('#lpt_info').html(value2)
    switch(value2){
      default:
      case 'LPT1': // org for PERDA
        $('.regional_sheet_number_wrap').show()
        $('[name="regional_sheet_number"]').val('')
        $('[name="regional_sheet_number"]').attr('required','required')
        $('.regional_sheet_additional_number_wrap').show()
        $('[name="regional_sheet_additional_number"]').val('')
        $('[name="regional_sheet_additional_number"]').attr('required','required')
        $('.regional_news_number_wrap').hide()
        $('[name="regional_news_number"]').val('')
        $('[name="regional_news_number"]').removeAttr('required')
        $('.legal_field_wrap').show()
        $('[name="legal_field"]').val('')
        $('.isbn_wrap').hide()
        $('.publisher_wrap').hide()
        $('[name="publisher"]').val('')
        break;
      case 'LPT2': // org for PERBUP
        $('.regional_sheet_number_wrap').hide()
        $('[name="regional_sheet_number"]').val('')
        $('[name="regional_sheet_number"]').removeAttr('required')
        $('.regional_sheet_additional_number_wrap').hide()
        $('[name="regional_sheet_additional_number"]').val('')
        $('[name="regional_sheet_additional_number"]').removeAttr('required')
        $('.regional_news_number_wrap').show()
        $('[name="regional_news_number"]').val('')
        $('[name="regional_news_number"]').attr('required','required')
        $('.legal_field_wrap').show()
        $('[name="legal_field"]').val('')
        $('.isbn_wrap').hide()
        $('[name="isbn"]').val('')
        $('.publisher_wrap').hide()
        $('[name="publisher"]').val('')
        break;
      case 'LPT3': // org for KEPBUP
        $('.regional_sheet_number_wrap').hide()
        $('[name="regional_sheet_number"]').val('')
        $('[name="regional_sheet_number"]').removeAttr('required')
        $('.regional_sheet_additional_number_wrap').hide()
        $('[name="regional_sheet_additional_number"]').val('')
        $('[name="regional_sheet_additional_number"]').removeAttr('required')
        $('.regional_news_number_wrap').hide()
        $('[name="regional_news_number"]').val('')
        $('[name="regional_news_number"]').removeAttr('required')
        $('.legal_field_wrap').show()
        $('[name="legal_field"]').val('')
        $('.isbn_wrap').hide()
        $('[name="isbn"]').val('')
        $('.publisher_wrap').hide()
        $('[name="publisher"]').val('')
        break;
      case 'LPT4': // org for INSBUP, SE_BUP, SE_SEKDA
        $('.regional_sheet_number_wrap').hide()
        $('[name="regional_sheet_number"]').val('')
        $('[name="regional_sheet_number"]').removeAttr('required')
        $('.regional_sheet_additional_number_wrap').hide()
        $('[name="regional_sheet_additional_number"]').val('')
        $('[name="regional_sheet_additional_number"]').removeAttr('required')
        $('.regional_news_number_wrap').hide()
        $('[name="regional_news_number"]').val('')
        $('[name="regional_news_number"]').removeAttr('required')
        $('.legal_field_wrap').show()
        $('[name="legal_field"]').val('')
        $('.isbn_wrap').hide()
        $('[name="isbn"]').val('')
        $('.publisher_wrap').hide()
        $('[name="publisher"]').val('')
        break;
      case 'LPT5': // org for PROPEMPERDA
        $('.regional_sheet_number_wrap').hide()
        $('[name="regional_sheet_number"]').val('')
        $('[name="regional_sheet_number"]').removeAttr('required')
        $('.regional_sheet_additional_number_wrap').hide()
        $('[name="regional_sheet_additional_number"]').val('')
        $('[name="regional_sheet_additional_number"]').removeAttr('required')
        $('.regional_news_number_wrap').hide()
        $('[name="regional_news_number"]').val('')
        $('[name="regional_news_number"]').removeAttr('required')
        $('.legal_field_wrap').hide()
        $('[name="legal_field"]').val('')
        $('.isbn_wrap').hide()
        $('[name="isbn"]').val('')
        $('.publisher_wrap').hide()
        $('[name="publisher"]').val('')
        break;
      case 'LPT6': // org for NA
        $('.regional_sheet_number_wrap').hide()
        $('[name="regional_sheet_number"]').val('')
        $('[name="regional_sheet_number"]').removeAttr('required')
        $('.regional_sheet_additional_number_wrap').hide()
        $('[name="regional_sheet_additional_number"]').val('')
        $('[name="regional_sheet_additional_number"]').removeAttr('required')
        $('.regional_news_number_wrap').hide()
        $('[name="regional_news_number"]').val('')
        $('[name="regional_news_number"]').removeAttr('required')
        $('.legal_field_wrap').hide()
        $('[name="legal_field"]').val('')
        $('.isbn_wrap').show()
        $('[name="isbn"]').val('')
        $('.publisher_wrap').show()
        $('[name="publisher"]').val('')
        break;
    }
    legalProductStatus_change()
  });

  $('.legal-product-status').on('change', function(event) {
    legalProductStatus_change(event.target.value)
  });

  function legalProductStatus_change(value='') {
    if(value == '') {
      value = $('[name="status"]').val()
    }
    $('.legal-product-status-child').hide()
    if($('#lpt_info').html() != 'LPT6'){
      $('.'+value+'-child').show()
    }
  }

});
