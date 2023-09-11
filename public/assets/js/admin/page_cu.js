console.log('PAGE CU V-23-05-17 01')
console.log('baseUrl ',baseUrl)

$(function(){
  $("#input-file").fileinput();

  $('#publishdatetime').datetimepicker({ 
    format: 'DD/MM/YYYY HH:mm',
    icons: { time: 'far fa-clock' } 
  });
  
  $('#publishdatetime2').datetimepicker({ 
    format: 'DD/MM/YYYY HH:mm',
    icons: { time: 'far fa-clock' } 
  });

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
      axios.post(baseUrl+'/api/page/post-add', formData, apiHeaders)
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
          window.location = baseUrl+'/admin-jdih-katkab/page';
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
      axios.post(baseUrl+'/api/page/post-edit', formData, apiHeaders)
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
          window.location = baseUrl+'/admin-jdih-katkab/page';
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

});
