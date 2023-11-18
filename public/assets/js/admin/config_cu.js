console.log('CONFIG IDX');

$(function () {
  $("#input-file").fileinput();

  $("#btn-submit-add").click(function (e) {
    const form = document.getElementById('form');
    form.reportValidity()
    if (!form.checkValidity()) {
    } else if ($('[name="check_validity"]').val() == 0) {
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

      axios.post(baseUrl + '/api/config/post-add', formData, apiHeaders) // Update the URL to match the Config controller
        .then(function (response) {
          console.log('response..', response);
          if (response.status == 200 && response.data.status) {
            Swal.fire({
              icon: 'success',
              width: 600,
              title: "Berhasil",
              // html: "...",
              confirmButtonText: 'Ya, terima kasih',
            });
            window.location = baseUrl + '/admin-katkab/config';
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
            console.error('Error response:', error.response);
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

  $("#btn-submit-edit").click(function (e) {
    const form = document.getElementById('form');
    form.reportValidity()
    if (!form.checkValidity()) {
    } else if ($('[name="check_validity"]').val() == 0) {
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

      axios.post(baseUrl + '/api/config/post-edit', formData, apiHeaders) // Update the URL to match the Config controller
        .then(function (response) {
          console.log('response..', response);
          if (response.status == 200 && response.data.status) {
            Swal.fire({
              icon: 'success',
              width: 600,
              title: "Berhasil",
              // html: "...",
              confirmButtonText: 'Ya, terima kasih',
            });
            window.location = baseUrl + '/admin-katkab/config';
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
            console.error('Error response:', error.response);
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
