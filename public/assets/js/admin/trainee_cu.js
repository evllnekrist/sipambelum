console.log('TRAINING CU');

$(function(){
  $("#input-file").fileinput();

  $('#publishdatetime').datetimepicker({ 
    format: 'DD/MM/YYYY HH:mm',
    icons: { time: 'far fa-clock' } 
  });
  
  $("#btn-submit-add").click(function(e){
    const form = document.getElementById('form');
    form.reportValidity();
    if (!form.checkValidity()) {
    } else {
      $('#loading').show();
      $('#form').hide();
      const formData = new FormData(form);
      axios.post(baseUrl+'/trainee/post-add', formData, apiHeaders)
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
          window.location = baseUrl+'/admin-katkab/trainee';
        } else {
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

  $("#btn-submit-edit").click(function(e){
    const form = document.getElementById('form');
    form.reportValidity();
    if (!form.checkValidity()) {
    } else {
      $('#loading').show();
      $('#form').hide();
      const formData = new FormData(form);
      axios.post(baseUrl+'/trainee/post-edit', formData, apiHeaders)
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
          window.location = baseUrl+'/admin-katkab/trainee';
        } else {
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
