<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="table-data" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" role="grid" aria-describedby="example23_info" style="width: 100%;" data-url="<?php echo base_url($cname.'/get_data') ?>">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>

                  <th></th>
                  <th></th>
                  <th class="th-sticky-action">-</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

  var url_insert_user_laporan = '<?php echo base_url($cname.'/insert') ?>';
  var base_cname = "<?php echo base_url($cname) ?>";
  var table = "";
  $(document).ready(function() {
    var table_url = $('#table-data').data('url');
    table = $('#table-data').DataTable({
      orderCellsTop : true,
      responsive : true,
      dom: "<'row'<'col-6'l><'col-6'f>>rtip'",
      scrollY: true,
      scrollX: true,
      "ajax": {
        'url': table_url,
      },
      "columns": [
      {
        "title" : "No",
        "width" : "15px",
        "data": null,
        "class": "text-center",
        render: (data, type, row, meta) => {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      { 
        "title" : "Nama user",
        "data": "nama" 
      },
      { 
        "title" : "Nomor Telp",
        "data": "nomor_telp" 
      },
      { 
        "title" : "Alamat",
        "data": "alamat" 
      },
      { 
        "title" : "Tanggal Lahir",
        "data": "tanggal_lahir" 
      },
      { 
        "title" : "Status",
        "class": "text-center",
        data : (data, type, row, meta) => {
          ret = "";
          if(data.status == '1'){
            ret += '<span class="badge bg-success">Aktif</span>';
          }else 
          if(data.status == '0'){
            ret += '<span class="badge bg-danger">Tidak Aktif</span>';
          }else{
            ret += '<span class="badge bg-secondary">loss</span>';
          }
          return ret;
        } 
      },
      {
        "title": "Actions",
        "width" : "1px",
        "class": "text-center th-sticky-action",
        "data": (data, type, row) => {
          let ret = "";
          if (data.status == '0') {
            ret += ' <a class="btn btn-success btn-sm text-white" onclick="update_status(this)" data-id="'+data.id_user+'""> <i class="fas fa-check"></i> Aktifkan User</a>'
          }else if(data.status == '1'){
            ret += ' <a class="btn btn-warning btn-sm text-white" onclick="update_status(this)" data-id="'+data.id_user+'""> <i class="fas fa-ban"></i> Non Aktif User</a>';
          }

          ret += ' <a class="btn btn-primary btn-sm text-white" onclick="reset_pass(this)" data-id="'+data.id_user+'"><i class="fas fa-key"></i> Reset Pass</a>';
          ret += ' <a class="btn btn-danger btn-sm text-white" onclick="delete_user(this)" data-id="'+data.id_user+'"><i class="fas fa-trash-alt"></i> Delete</a>';

          return ret;
        }
      }
      ]
    });

    $('form#form-user').submit(function(e){
      var form = $(this);
      e.preventDefault();

      $.ajax({
        url: url_insert_user_laporan,
        type: 'POST',
        data: form.serialize(),
        dataType : "JSON",
        success: function (data) {
          // let json = $.parseJSON(data);
          swal(data.title,data.text,data.icon);
          scroll_smooth('table',500);
          form_reset();
        }
      });
    });
  });


  // var reset_pass = (id_user, tanggal_lahir) => {
  //   $.ajax({
  //     url: base_cname+"/reset_pass",
  //     type: 'POST',
  //     data: {
  //       'id_user' : id_user,
  //       'tanggal_lahir' : tanggal_lahir
  //     },
  //     success: function (data) {
  //       var json = $.parseJSON(data);
  //       scroll_smooth('body',500);
  //     },
  //   });
  // }

  var delete_user = (obj) => {
    swal({
      title: 'Apakah Anda Yakin ?',
      text: "Anda akan menghapus user ini !!",
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if(willDelete){
        $.ajax({
          url : base_cname+"/delete_user",
          type : 'POST',
          data : {
            id_user : $(obj).data('id'),
          },
          dataType : "JSON",
          success : (data) => {
            swal(data.title,data.text,data.icon);
            form_reset();
            scroll_smooth('table',500);
          }
        });
      }
    });
  }

  var reset_pass = (obj) => {
    swal({
      title: 'Apakah Anda Yakin ?',
      text: "Anda akan mereset password!!",
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    }).then((willRessetPass) => {
      if(willRessetPass){
        $.ajax({
          url: base_cname+"/reset_pass",
          type: 'POST',
          data : {
            id_user : $(obj).data('id'),
          },
          dataType : "JSON",
          success : (data) => {
            swal(data.title,data.text,data.icon);
            form_reset();
            scroll_smooth('table',500);
          }
        });
      }
    });
  }

  var update_status = (obj) => {
    swal({
      title: 'Apakah Anda Yakin ?',
      text: "Akan merubah status!",
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if(willDelete){
        $.ajax({
          url : base_cname+"/update_status",
          type : 'POST',
          data : {
            id_user : $(obj).data('id'),
          },
          dataType : "JSON",
          success : (data) => {
            swal(data.title,data.text,data.icon);
            form_reset();
          }
        });
      }
    });
  }


  var form_reset = () => {
    table.ajax.reload(null,false);
    $('form#form-user').find('input,select').val('');
  }

</script>