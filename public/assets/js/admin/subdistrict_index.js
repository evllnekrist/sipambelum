console.log('SUBDISTRICT IDX');

function doDelete(id, name) {
  if (confirm("Apakah Anda yakin menghapus subdistrict dengan ID '" + id + "' dan nama '" + name + "'? Aksi ini tidak dapat dibatalkan.")) {
    axios.post(baseUrl+'/api/subdistrict/post-delete/' + id, {}, apiHeaders)
    .then(function (response) {
      console.log('response..', response);
      if (response.status == 200 && response.data.status) {
        Swal.fire({
          icon: 'success',
          width: 600,
          title: "Berhasil",
          confirmButtonText: 'Ya, terima kasih',
        });
        window.location = baseUrl+'/admin-katkab/subdistrict';
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
  } else {
    Swal.fire({
      icon: 'info',
      width: 600,
      html: 'Batal dihapus',
      confirmButtonText: 'Ya',
    });
  }
}

function getData() {
  $('#page-loading').html(loadingElement);
  let url = baseUrl+'/api/get-subdistrict-list'; // Ubah sesuai endpoint API untuk mendapatkan data subdistrict
  let page = 1, pageSize = 10;
  let payload = { page: page, page_size: pageSize };
  console.log('tryin to retrieve data....', url);
  axios.post(url, payload, apiHeaders)
  .then(function (response) {
    console.log('[DATA] response..', response.data.data);
    if (response.data.status) {
      var table = $('#data-list').DataTable({
        dom: 'Bfrtip',
        data: response.data.data,
        columns: [
          { data: 'id' },
          { data: 'name' }, // Sesuaikan dengan atribut subdistrict dari respons API
          { data: 'active', render: function(data) {
            return data == 1 ? 'Aktif' : 'Tidak Aktif';
        }},
          // Kolom aksi untuk menghapus subdistrict
          {
            data: null, render: function (data, type, row) {
              return '<a onclick="doDelete(' + data.id + ',`' + data.name + '`)" class="text-danger"><i class="nav-icon fas fa-trash"></i></a>' +
                ' <a href="' + baseUrl + '/admin-katkab/subdistrict/edit/' + data.id + '" class="text-primary"><i class="nav-icon fas fa-edit"></i></a>';
            }
          },
        ],
      });

      table.on('order.dt search.dt', function () {
        var i = 1;
        table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
          this.data(i++);
        }).draw();
      });
    } else {
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
    Swal.fire({
      icon: 'error',
      width: 600,
      title: "Error",
      html: error,
      confirmButtonText: 'Ya',
    });
    console.log(error);
  });
}
getData();
