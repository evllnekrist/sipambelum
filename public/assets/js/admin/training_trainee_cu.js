console.log('training trainee CU')
console.log('datetime',(new Date).toLocaleString('id-ID'))

$(function(){
  // $("#input-file").fileinput();
  const subdistrict_ids = ($("[name='subdistrict_ids']").val()).split(",");
  let trainees_to_delete = [];
  let trainees_to_confirm = [];
  let trainees_to_confirm_not = [];
  let trainees_is_passed = [];
  let trainees_is_passed_not = [];

  function searchTrainee_closeResult(){
    $('.search-trainee-input:checked').each(function() {
      $(this).prop('checked',false)
    });
    $("#advance-search").hide();
  }

  function valuateDisplay(){
    let el 
    subdistrict_ids.forEach(id => {
      if(!document.getElementById("subdistrict-"+id+"-tbody").childElementCount){
        $("#subdistrict-"+id+"-wrap").hide() // undisplay empty trainees
      }
    });
  }

  $("#btn-trainees-add-cancel").click(function(e){
    searchTrainee_closeResult();
  });

  $("#btn-trainees-add").click(function(e){
    // let search_trainee = [];
    let search_trainee_data = {};
    $('.search-trainee-input:checked').each(function() {
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
        $("#subdistrict-"+sd+"-wrap").show();
        // console.log('trainees_to_delete_1 ',trainees_to_delete)
        if(trainees_to_delete.includes(item.id)){ // if add after been delete before
          trainees_to_delete.splice(trainees_to_delete.indexOf(item.id), 1); // undo to delete
        }
        // console.log('trainees_to_delete_2 ',trainees_to_delete)
        if(document.getElementById("subdistrict-"+item.id+"-trainee")){
        }else{
          template = `
          <tr id="subdistrict-`+item.id+`-trainee">
            <td>
                <b>`+item.name+`</b><br>
                <span>`+item.nik+`</span><br>
            </td>
            <td>
                <div class="_leads_status"><span class="active">`+item.level+`</span></div>
                <span>Update terakhir `+(new Date(item.created_at)).toLocaleString('id-ID')+`</span>
            </td>
            <td>
              <a onclick="displayBusiness(`+item.id+`)" class="text-blue-b">lihat</a>
            </td>
            <td>
              <a onclick="displayClass(`+item.id+`)" href="" class="text-blue-b">lihat</a>
            </td>
            <td>
                <div class="_leads_action" data-complete="'`+JSON.stringify(item)+`'">
                    <a class="trainee-delete"><i class="ti-close"></i></a>
                    <a class="trainee-approve"><i class="ti-check"></i></a>
                    <button type="button" class="btn btn-outline-warning btn-lg trainee-passed-not" style="margin-top:-5px">Tidak</button>
                    <button type="button" class="btn btn-outline-success btn-lg trainee-passed" style="margin-top:-5px">Lulus</button>
                </div>
            </td>
          </tr>`;
        }
        $("#subdistrict-"+sd+"-tbody").append(template);
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
    if($('#level').val()){
      payload['_level'] = $('#level').val();
    }
    if($('#search').val()){
      payload['_search'] = $('#search').val();
    }
    axios.post(baseUrl+'/api/get-trainee-list-adv', payload, apiHeaders)
    .then(function (response) {
      console.log('[TRAINING TRAINEE] response..',response);
      let template = '';
      if(response.data.status) {
        template = ''
        if(response.data.data.products && response.data.data.products.length > 0) {
          let i = 0;
          (response.data.data.products).forEach((item) => {
            i++;
            template +=`<li>
                            <input id="search_trainee_`+i+`" class="form-check-input search-trainee-input" value="`+item.id+`" data-complete='`+JSON.stringify(item)+`' type="checkbox">
                            <label for="search_trainee_`+i+`" class="form-check-label">`+item.name+` (<b class="text-level-`+item.level+`">`+item.level+`</b>)
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
    let to_delete = []
    $('.checkbox-trainee:checked').each(function() {
      to_delete.push($(this).data('id'))
    });
    Swal.fire({
      // title: 'Are you sure?',
      text: "Yakin menghapus "+to_delete.length+" peserta pelatihan tersebut?",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ya, lanjutkan!',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batalkan',
    }).then((result) => {
      if (result.isConfirmed) {
        to_delete.forEach(id => {
          $("#subdistrict-"+id+"-trainee").remove()
          trainees_to_delete.includes(id)?'':trainees_to_delete.push(id)
        });
        // console.log('trainees_to_delete',trainees_to_delete)
        valuateDisplay()
        Swal.fire({
          title: 'Terhapus',
          html: 'Peserta dihapus dari tampilan ini, tekan simpan untuk menyimpan perubahan',
          icon: 'success',
          showConfirmButton: false,
          timer: 1500
        })
      }
    })
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

  $(".check-all").click(function(e){
    let group = $(this).data('group')
    $(".check-all-group-"+group).prop('checked',$(this).is(":checked"))
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
