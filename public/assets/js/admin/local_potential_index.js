console.log('LOCAL POTENTIAL IDX');

function doDelete(id, name) {
  if (confirm("Apakah Anda yakin menghapus Local Potential dengan ID '" + id + "' dan nama '" + name + "'? Aksi ini tidak dapat dibatalkan.")) {
    axios.post(baseUrl+'/api/local-potential/post-delete/' + id, {}, apiHeaders)
    .then(function (response) {
      console.log('response..', response);
      if (response.status == 200 && response.data.status) {
        Swal.fire({
          icon: 'success',
          width: 600,
          title: "Berhasil",
          confirmButtonText: 'Ya, terima kasih',
        });
        window.location = baseUrl+'/admin-katkab/local-potential';
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
  let url = baseUrl+'/api/get-local-potential-list';
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
          // Sesuaikan kolom-kolom berikut dengan atribut-atribut local potential dari respons API
          { data: 'name' },
          { data: 'desc' },
          {
            data: 'img_main',
          render: function (data, type, row) {
            return '<img src="' + baseUrl + '/storage/assets/img/localpotential/' + data + '" alt="Image" width="100">';
          }

          },
          { data: 'url_link' },
          {
            data: 'active', render: function (data, type, row) {
              return data == 1 ? 'Aktif' : 'Tidak Aktif';
            }
          },
          // Kolom aksi untuk menghapus local potential
          {
            data: null, render: function (data, type, row) {
              return '<a onclick="doDelete(' + data.id + ',`' + data.name + '`)" class="text-danger"><i class="nav-icon fas fa-trash"></i></a>' +
                ' <a href="' + baseUrl + '/admin-katkab/local-potential/edit/' + data.id + '" class="text-primary"><i class="nav-icon fas fa-edit"></i></a>';
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