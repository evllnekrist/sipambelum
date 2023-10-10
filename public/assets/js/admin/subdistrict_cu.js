console.log('SUBDISTRICT CU');

$(function(){
  $("#input-file").fileinput();

  $("#btn-submit-add").click(function(e){
    const form = document.getElementById('form');
    form.reportValidity();
    if (!form.checkValidity()) {
      // Form is not valid, do nothing
    } else {
      $('#loading').show();
      $('#form').hide();
      const formData = new FormData(form);
      axios.post(baseUrl+'/api/subdistrict/post-add', formData, apiHeaders)
      .then(function (response) {
        if (response.status == 200 && response.data.status) {
          // Data subdistrict berhasil ditambahkan
          Swal.fire({
            icon: 'success',
            width: 600,
            title: "Berhasil",
            confirmButtonText: 'Ya, terima kasih',
          });
          window.location = baseUrl+'/admin-katkab/subdisctrict';
        } else {
          // Data subdistrict gagal ditambahkan, tampilkan pesan kesalahan
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
        // Tangani kesalahan saat menambahkan data subdistrict
        console.error(error);
        Swal.fire({
          icon: 'error',
          width: 600,
          title: "Error",
          html: "Terjadi kesalahan saat menambahkan data subdistrict.",
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
      // Form is not valid, do nothing
    } else {
      $('#loading').show();
      $('#form').hide();
      const formData = new FormData(form);
      axios.post(baseUrl+'/api/subdistrict/post-edit', formData, apiHeaders)
      .then(function (response) {
        console.log('response..',response);
        if(response.status == 200 && response.data.status) {
          Swal.fire({
            icon: 'success',
            width: 600,
            title: "Berhasil",
            confirmButtonText: 'Ya, terima kasih',
          });
          window.location = baseUrl+'/admin-katkab/subdisctrict';
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
