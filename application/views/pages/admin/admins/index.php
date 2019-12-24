<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?php echo $title ?></h3>

        </div>
        <div class="card-body">
          <?php echo form_open($cname.'/insert',['id'=>'form-admin']); ?>
          <input type="hidden" class="form-control" name="id_admin" placeholder="">
          <div class="form-group">
            <label>Nama admin</label>
            <input type="text" class="form-control" name="nama" placeholder="Nama">
          </div>
          <div class="form-group">
            <label>Nomor Identitas</label>
            <input type="text" class="form-control" name="nomor_identitas" placeholder="Nomor Identitas">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" placeholder="Password">
          </div>
          <div class="form-group">
            <label>No telp</label>
            <input type="text" class="form-control" name="no_telp" placeholder="no_telp">
          </div>
          <div class="form-group">
            <label>Jabatan</label>
            <select name="jabatan" id="" class="form-control">
              <option value="" selected disabled>Choose</option>
              <?php foreach ($data['select_jabatan'] as $key => $value): ?>
                <option value="<?php echo $value->id_jabatan ?>"><?php echo $value->nama_jabatan ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label>Golongan</label>
            <select name="golongan" id="" class="form-control">
              <option value="" selected disabled>Choose</option>
              <?php foreach ($data['select_golongan'] as $key => $value): ?>
                <option value="<?php echo $value->id_golongan ?>"><?php echo $value->nama_golongan ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label>Level User</label>
            <select class="form-control" name="level_user">
              <option value="" selected disabled>Choose</option>
              <option value="1">Admin</option>
              <option value="2">Kepala Bidang</option>
            </select>
          </div>
          <div class="form-group">
            <label>Is Active</label>
            <select class="form-control" name="is_active">
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
    </div>
    
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
  var url_insert_admin = '<?php echo base_url($cname.'/insert') ?>';
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
        "title" : "Nama admin",
        "data": "nama" 
      },
      { 
        "title" : "Nomor Identitas",
        "data": "nomor_identitas" 
      },
      { 
        "title" : "No Telp",
        "data": "no_telp" 
      },
      { 
        "title" : "Jabatan",
        "data": "nama_jabatan" 
      },
      { 
        "title" : "Golongan",
        "data": "nama_golongan" 
      },
      { 
        "title" : "Level_user", 
        data : (data, type, row, meta) => {
          ret = "";
          if(data.level_user == '1'){
            ret += '<span>Admin</span>';
          }else 
          if(data.level_user == '2'){
            ret += '<span>Kepala Bidang</span>';
          }else{
            ret += '<span class="badge bg-secondary">loss</span>';
          }
          return ret;
        } 
      },
      { 
        "title" : "Is Active", 
        data : (data, type, row, meta) => {
          ret = "";
          if(data.is_active == '1'){
            ret += '<span class="badge bg-success">Aktif</span>';
          }else 
          if(data.is_active == '0'){
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
        "class": "text-center th-sticky-action",
        "data": (data, type, row) => {
          let ret = "";
          ret += ' <a class="btn btn-info btn-sm text-white" onclick="fill_form('+data.id_admin+'); return false;"><i class="fas fa-pencil-alt"></i> Edit</a>';
          ret += ' <a class="btn btn-danger btn-sm text-white" onclick="delete_admin(this)" data-id="'+data.id_admin+'"><i class="fas fa-trash-alt"></i> Delete</a>';

          return ret;
        }
      }
      ]
    });

    $('form#form-admin').submit(function(e){
      var form = $(this);
      e.preventDefault();

      $.ajax({
        url: url_insert_admin,
        type: 'POST',
        data: form.serialize(),
        dataType : "JSON",
        success: function (data) {
          if(data.code == '2'){
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            Object.keys(data.field).forEach(function(key) {
              $('#form-admin').find('[name="'+key+'"]').parent().find('input,select').addClass('is-invalid');
              $('#form-admin').find('[name="'+key+'"]').parent().append('<div class="invalid-feedback">'+data.field[key]+'</div>');
            })
          }else{
            form_reset();
            swal(data.title,data.text,data.icon);
          }
        }
      });
    });
  });


  var fill_form = (id_admin) => {
    $.ajax({
      url: url_fill_form,
      type: 'POST',
      data: {
        'id_admin' : id_admin
      },
      success: function (data) {
        var json = $.parseJSON(data);
        let form = $('#form-admin');
        form_reset();
        form.find('[name="id_admin"]').val(json.id_admin);
        form.find('[name="nama"]').val(json.nama);
        form.find('[name="nomor_identitas"]').val(json.nomor_identitas);
        form.find('[name="no_telp"]').val(json.no_telp);
        form.find('[name="jabatan"]').val(json.jabatan);
        form.find('[name="golongan"]').val(json.golongan);
        form.find('[name="level_user"]').val(json.level_user);
        form.find('[name="is_active"]').val(json.is_active);
        scroll_smooth('body',500);
      },
    });
  }

  var delete_admin = (obj) => {
    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if(willDelete){
        $.ajax({
          url : base_cname+"/delete_admin",
          type : 'POST',
          data : {
            id_admin : $(obj).data('id'),
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
    $('form#form-admin').find('input,select').val('');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
  }

</script>