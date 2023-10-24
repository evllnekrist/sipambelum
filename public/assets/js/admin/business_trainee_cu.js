console.log('business trainee CU')
console.log('datetime',(new Date).toLocaleString('id-ID'))

$(function(){
  // $("#input-file").fileinput();
  const subdistrict_ids = ($("[name='subdistrict_ids']").val()).split(",");
  // console.log('subdistrict_ids',subdistrict_ids)

  function searchTrainee_closeResult(){
    $('.search_trainee_input:checked').each(function() {
      $(this).prop('checked',false)
    });
    $("#advance-search").hide();
  }

  $("#btn-trainees-add-cancel").click(function(e){
    searchTrainee_closeResult();
  });

  $("#btn-trainees-add").click(function(e){
    // let search_trainee = [];
    let search_trainee_data = {};
    $('.search_trainee_input:checked').each(function() {
      // search_trainee.push($(this).val());
      search_trainee_data[$(this).val()] = $(this).data('complete');
    });
    searchTrainee_closeResult();
    // console.log('search trainee',search_trainee_data);
    let template = ``; let item = {}; let sd = ``;
    for (var key in search_trainee_data) {
      item  = search_trainee_data[key];
      sd    = (item['subdistrict_of_residence']).toString()
      // console.log('item',item)
      // console.log('subdistrict_ids',subdistrict_ids)
      // console.log('sd',sd)
      // console.log('==',subdistrict_ids.includes(sd))
      if(subdistrict_ids.includes(sd)){      
       $("#btn-trainees-add").click(function(e){
    let search_trainee_data = {};
    $('.search_trainee_input:checked').each(function() {
        search_trainee_data[$(this).val()] = $(this).data('complete');
    });
    searchTrainee_closeResult();
    let template = ``;
    for (var key in search_trainee_data) {
        let item = search_trainee_data[key];
        template = `
        <tr id="subdistrict-`+item.id+`-trainee">
            <td>`+item.name+`</td>
            <td><input type="text" class="form-control" name="job_title[`+item.id+`]" placeholder="Job Title"></td>
            <td>
                <a onclick="displayBusiness(`+item.id+`)" class="text-blue-b">lihat</a>
            </td>
            <td>
                <a onclick="displayClass(`+item.id+`)" href="" class="text-blue-b">lihat</a>
            </td>
            <td>
                <a class="trainee-delete"><i class="ti-close"></i></a>
            </td>
        </tr>`;
        $("#subdistrict-"+item.id+"-tbody").append(template);
    }
});z
      }else{
        Swal.fire({
          position: 'top-end',
          icon: 'warning',
          title: "Hmm..",
          html: '<small>'+item.name+' tidak terdaftar dalam kecamatan manapun. Tidak bisa menambahkan ke list.</small>',
          showConfirmButton: true,
        });
      }
    };
  });

  $("#btn-trainees-search").click(function(e){
    let appendTo = '#advance-search';
    $(appendTo+'-info').show();
    $(appendTo+'-loading').show();
    $(appendTo).hide();
    // return
    let payload = {};
    if($('#subdistrict').val()){
      payload['_subdistrict'] = $('#subdistrict').val();
    }

    if($('#search').val()){
      payload['_search'] = $('#search').val();
    }
    axios.post(baseUrl+'/api/get-trainee-list-adv', payload, apiHeaders)
    .then(function (response) {
      console.log('[BUSINESS TRAINEE] response..',response);
      let template = '';
      if(response.data.status) {
        template = ''
        if(response.data.data.products && response.data.data.products.length > 0) {
          let i = 0;
          (response.data.data.products).forEach((item) => {
            i++;
            template +=`<li>
                            <input id="search_trainee_`+i+`" class="form-check-input search_trainee_input" value="`+item.id+`" data-complete='`+JSON.stringify(item)+`' type="checkbox">
                            <label for="search_trainee_`+i+`" class="form-check-label">`+item.name+`
                            <table class="text-smaller">
                              <tr>
                                <td>NIK</td>
                                <td>`+item.nik+`</td>
                              </tr>
                              <tr>
                                <td>Kecamatan</td>
                                <td>`+(item.subdistrict?item.subdistrict.name:` - `)+`</td>
                              </tr>
                            </table>
                            </label>
                        </li>`;
          });
          $(appendTo+'-trainee-list').html(template);
          $(appendTo+'-info').hide();
          $(appendTo).show();
        }else{
          $(appendTo+'-info-content').html(`<center><b class="text-warning">tidak ada data</b></center>`);
        }
      }else{
        $(appendTo+'-info-content').html(`<center><b class="text-warning">tidak ada data</b></center>`);
      }
      $(appendTo+'-loading').hide();
    })
    .catch(function (error) {
      $(appendTo+'-loading').hide();
      $(appendTo+'-info-content').html(`<center><b class="text-warning">Gagal mendapatkan data (C2)</b><br><small>`+error.message+`</small>`);
    });
  });

  
  $(".trainee-delete").click(function(e){
    console.log('trainee delete')
  });
  $(".trainee-approve").click(function(e){
    console.log('trainee approve')
  });
  $(".trainee-passed").click(function(e){
    console.log('trainee passed ')
  });
  $(".trainee-passed-not").click(function(e){
    console.log('trainee passed not')
  });

  $("#btn-submit-edit").click(function(e){
    const form = document.getElementById('form');
    form.reportValidity()
    if (!form.checkValidity()) {
    } else {
      $('#loading').show();
      $('#form').hide();
      const formData = new FormData(form);
      // for (const [key, value] of formData) {
      //   console.log('»', key, value)
      // }
      axios.post(baseUrl+'/api/training/post-edit', formData, apiHeaders)
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
          // window.location = baseUrl+'/admin-katkab/training';
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
