console.log('TRAINING CU');

$(function(){
  $("#input-file").fileinput();

 $("#btn-submit-add").click(function(e){
  const form = document.getElementById('form');
  form.reportValidity();
  if (!form.checkValidity()) {
    // Form is not valid, do nothing
  } else {
    const formData = new FormData(form); // Mendefinisikan formData di sini
   const nik = formData.get('nik'); // Mengambil nilai NIK dari form
    // Periksa apakah NIK sudah terdaftar
    axios.post(baseUrl+'/api/trainee/check-nik', { nik: nik }, apiHeaders)
    .then(function (response) {
      if (response.status == 200 && response.data.status) {
        // NIK sudah terdaftar, tampilkan pesan kesalahan
        Swal.fire({
          icon: 'warning',
          width: 600,
          title: "Maaf",
          html: "NIK sudah terdaftar, tidak dapat mendaftar lagi.",
          confirmButtonText: 'Ya',
        });
      } else {
        // NIK belum terdaftar, lanjutkan dengan mengirim permintaan POST
        $('#loading').show();
        $('#form').hide();
        const formData = new FormData(form);
        axios.post(baseUrl+'/api/trainee/post-add', formData, apiHeaders)
        .then(function (response) {
          if (response.status == 200 && response.data.status) {
            // Data trainee berhasil ditambahkan
            Swal.fire({
              icon: 'success',
              width: 600,
              title: "Berhasil",
              confirmButtonText: 'Ya, terima kasih',
            });
            window.location = baseUrl+'/admin-katkab/trainee';
          } else {
            // Data trainee gagal ditambahkan, tampilkan pesan kesalahan
            Swal.fire({
              icon: 'warning',
              width: 600,
              title: "Gagal",
              html: response.data.message,
              confirmButtonText: 'Ya',
            });
          }
        })
        .catch(function (error) {
          // Tangani kesalahan saat menambahkan data trainee
          console.error(error);
          Swal.fire({
            icon: 'error',
            width: 600,
            title: "Error",
            html: "Terjadi kesalahan saat menambahkan data trainee.",
            confirmButtonText: 'Ya',
          });
        })
        .finally(function() {
          // Tampilkan kembali form setelah selesai
          $('#loading').hide();
          $('#form').show();
        });
      }
    })
    .catch(function (error) {
      // Tangani kesalahan saat memeriksa NIK
      console.error(error);
      Swal.fire({
        icon: 'error',
        width: 600,
        title: "Error",
        html: "Terjadi kesalahan saat memeriksa NIK.",
        confirmButtonText: 'Ya',
      });
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
      axios.post(baseUrl+'/api/trainee/post-edit', formData, apiHeaders)
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
