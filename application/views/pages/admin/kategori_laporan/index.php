<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <?php echo form_open($cname.'/insert',['id'=>'form-kategori-laporan']); ?>
          <input type="hidden" class="form-control" name="id_kategori" placeholder="">
          <div class="form-group">
            <label>Nama Kategori Laporan</label>
            <input type="text" class="form-control" name="nama_kategori" placeholder="">
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
        <!-- /.card-body -->

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
  var url_insert_kategori_laporan = '<?php echo base_url($cname.'/insert') ?>';
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
        "title" : "Nama kategori",
        "data": "nama_kategori" 
      },
      { 
        "title" : "Status", 
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
          ret += ' <a class="btn btn-info btn-sm text-white" onclick="fill_form('+data.id_kategori+'); return false;"><i class="fas fa-pencil-alt"></i> Edit</a>';
          ret += ' <a class="btn btn-danger btn-sm text-white" onclick="delete_kategori(this)" data-id="'+data.id_kategori+'"><i class="fas fa-trash-alt"></i> Delete</a>';

          return ret;
        }
      }
      ]
    });

    $('form#form-kategori-laporan').submit(function(e){
      var form = $(this);
      e.preventDefault();

      $.ajax({
        url: url_insert_kategori_laporan,
        type: 'POST',
        data: form.serialize(),
        dataType : "JSON",
        success: function (data) {
          if(data.code == '2'){
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            Object.keys(data.field).forEach(function(key) {
              $('#form-kategori-laporan').find('[name="'+key+'"]').parent().find('input,select').addClass('is-invalid');
              $('#form-kategori-laporan').find('[name="'+key+'"]').parent().append('<div class="invalid-feedback">'+data.field[key]+'</div>');
            })
          }else{
            form_reset();
            swal(data.title,data.text,data.icon);
          }
        }
      });
    });
  });


  var fill_form = (id_kategori) => {
    $.ajax({
      url: url_fill_form,
      type: 'POST',
      data: {
        'id_kategori' : id_kategori
      },
      success: function (data) {
        var json = $.parseJSON(data);
        let form = $('#form-kategori-laporan');
        form_reset();
        form.find('[name="id_kategori"]').val(json.id_kategori);
        form.find('[name="nama_kategori"]').val(json.nama_kategori);
        form.find('[name="status"]').val(json.status);
        scroll_smooth('body',500);
      },
    });
  }

  var delete_kategori = (obj) => {
    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if(willDelete){
        $.ajax({
          url : base_cname+"/delete_kategori",
          type : 'POST',
          data : {
            id_kategori : $(obj).data('id'),
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
    $('form#form-kategori-laporan').find('input,select').val('');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
  }

</script>