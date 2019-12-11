<div class="container-fluid">
  <div class="row">
    <!-- <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Title</h3>

        </div>
        <div class="card-body">
          <?php echo form_open($cname.'/insert',['id'=>'form-user']); ?>
          <input type="hidden" class="form-control" name="id_user" placeholder="">
          <div class="form-group">
            <label>Nama user</label>
            <input type="text" class="form-control" name="nama" placeholder="Nama">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" placeholder="Password">
          </div>
          <div class="form-group">
            <label>No Telp.</label>
            <input type="text" class="form-control" name="nomor_telp" placeholder="Nomor telp">
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <input type="text" class="form-control" name="alamat" placeholder="Alamat">
          </div>
          <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="text" class="form-control" name="tanggal_lahir" placeholder="Tanggal Lahir">
          </div>
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" name="status">
              <option value="" selected disabled>Choose</option>
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="reset" class="btn btn-secondary" onclick="form_reset();">Reset</button>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div> -->

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

  var url_fill_form = '<?php echo base_url($cname.'/get_data_by_id') ?>';
  var url_insert_user_laporan = '<?php echo base_url($cname.'/insert') ?>';
  var base_cname = "<?php echo base_url($cname) ?>";
  var table = "";
  $(document).ready(function() {
    var table_url = $('#table-data').data('url');
    table = $('#table-data').DataTable({
      orderCellsTop : true,
      responsive : true,
      dom: 'lfrtip',
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
        "title" : "password",
        "data": "password" 
      },
      { 
        "title" : "nomor_telp",
        "data": "nomor_telp" 
      },
      { 
        "title" : "alamat",
        "data": "alamat" 
      },
      { 
        "title" : "tanggal_lahir",
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
        "width" : "120px",
        "visible":true,
        "class": "text-center",
        "data": (data, type, row) => {
          let ret = "";
          if (data.status == '0') {
            ret += ' <a class="btn btn-success btn-sm text-white" onclick="update_status(this)" data-id="'+data.id_user+'""> Aktifkan User</a>'
          }else if(data.status == '1'){
            ret += ' <a class="btn btn-warning btn-sm text-white" onclick="update_status(this)" data-id="'+data.id_user+'""> Non Aktif User</a>';
          }

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


  var fill_form = (id_user) => {
    $.ajax({
      url: url_fill_form,
      type: 'POST',
      data: {
        'id_user' : id_user
      },
      success: function (data) {
        var json = $.parseJSON(data);
        let form = $('#form-user');
        form.find('[name="id_user"]').val(json.id_user);
        form.find('[name="nama"]').val(json.nama);
        form.find('[name="nomor_telp"]').val(json.nomor_telp);
        form.find('[name="alamat"]').val(json.alamat);
        form.find('[name="tanggal_lahir"]').val(json.tanggal_lahir);
        form.find('[name="status"]').val(json.status);
        scroll_smooth('body',500);
      },
    });
  }

  var delete_user = (obj) => {
    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
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

  var update_status = (obj) => {
    swal({
      title: 'Apakah yakin ?',
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