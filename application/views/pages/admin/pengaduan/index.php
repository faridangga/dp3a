<div class="container-fluid">
  <div class="row">
    <!-- <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Title</h3>

        </div>
        <div class="card-body">
          <?php echo form_open($cname.'/insert',['id'=>'form-pengaduan']); ?>
          <input type="hidden" class="form-control" name="id_pengaduan" placeholder="">
          <div class="form-group">
            <label>Nama User</label>
            <input type="text" class="form-control" name="id_user" placeholder="">
          </div>
          <div class="form-group">
            <label>Kategori</label>
            <input type="text" class="form-control" name="id_kategori" placeholder="">
          </div>
          <div class="form-group">
            <label>Laporan</label>
            <input type="text" class="form-control" name="isi_laporan" placeholder="">
          </div>
          <div class="form-group">
            <label>Waktu Laporan</label>
            <input type="text" class="form-control" name="waktu_lapor" placeholder="">
          </div>
          <div class="form-group">
            <label>Waktu Respon</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div>
              <input type="text" class="form-control float-right" id="datepicker" name="waktu">
            </div>
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

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Pengaduan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-body">
          <?php echo form_open($cname.'/update',['id'=>'form-pengaduan']); ?>
          <input type="hidden" class="form-control" name="id_pengaduan" placeholder="" readonly>
          <div class="form-group">
            <label>Nama User</label>
            <input type="text" class="form-control" name="id_user" placeholder="" readonly>
          </div>
          <div class="form-group">
            <label>Kategori</label>
            <input type="text" class="form-control" name="id_kategori" placeholder="" readonly>
          </div>
          <div class="form-group">
            <label>Laporan</label>
            <input type="text" class="form-control" name="isi_laporan" placeholder="" readonly>
          </div>
          <div class="form-group">
            <label>Waktu Laporan</label>
            <input type="text" class="form-control" name="waktu_lapor" placeholder="" readonly>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" name="status">
              <option value="" selected disabled>Choose</option>
              <option value="0">Belum Direspon</option>
              <option value="1">Sudah Teratasi</option>
              <option value="2">Tidak Teratasi</option>
              <option value="3">Tidak Bisa Dihubungi</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      <?php echo form_close(); ?>

    </div>
  </div>
</div>

<!-- End Bootstrap modal -->
<div id="users" style="display: none;">
  <?php foreach ($data['select_users'] as $key => $value): ?>
    <option value="<?php echo $value->id_user ?>"><?php echo $value->nama ?></option>
  <?php endforeach ?>
</div>

<script>
  var url_fill_form = '<?php echo base_url($cname.'/get_data_by_id') ?>';
  var url_insert_pengaduan = '<?php echo base_url($cname.'/insert') ?>';
  var url_update_pengaduan = '<?php echo base_url($cname.'/update') ?>';
  var url_edit_pengaduan = '<?php echo base_url($cname.'/edit_pengaduan') ?>';
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
        "title" : "Kategori",
        "data": "nama_kategori" 
      },
      { 
        "title" : "Isi Laporan",
        "data": "isi_laporan" 
      },
      { 
        "title" : "Waktu Lapor",
        "data": "waktu_lapor" 
      },
      { 
        "title" : "Waktu Respon",
        "data": "waktu_respon" 
      },
      { 
        "title" : "Status",
        data : (data, type, row, meta) => {
          ret = "";
          if(data.id_status == '0'){
            ret += '<span class="badge bg-secondary">Belum Direspon</span>';
          }else 
          if(data.id_status == '1'){
            ret += '<span class="badge bg-success">Sudah Teratasi</span>';
          }else
          if(data.id_status == '2'){
            ret += '<span class="badge bg-info">Tidak Teratasi</span>';
          }else
          if(data.id_status == '3'){
            ret += '<span class="badge bg-danger">Tidak Bisa dihubungi</span>';
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
          ret += ' <a class="btn btn-info btn-sm text-white" onclick="edit_pengaduan('+data.id_pengaduan+')"><i class="fas fa-pencil-alt"></i> Edit</a>';
          ret += ' <a class="btn btn-danger btn-sm text-white" onclick="delete_pengaduan(this)" data-id="'+data.id_pengaduan+'"><i class="fas fa-trash-alt"></i> Delete</a>';
          return ret;
        }
      }
      ]
    });

    $('form#form-pengaduan').submit(function(e){
      var form = $(this);
      e.preventDefault();

      $.ajax({
        url: url_update_pengaduan,
        type: 'POST',
        data: form.serialize(),
        dataType : "JSON",
        success: function (data) {
          swal(data.title,data.text,data.icon);
          scroll_smooth('table',500);
          form_reset();
          $('#modal_form').modal('hide');
          table.ajax.reload(null,false);          
        }
      });
    });

    $('#datepicker').datepicker({
      todayHighlight:'TRUE',
      autoclose: true,
    });
  });


  var delete_pengaduan = (obj) => {
    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if(willDelete){
        $.ajax({
          url : base_cname+"/delete_pengaduan",
          type : 'POST',
          data : {
            id_pengaduan : $(obj).data('id'),
          },
          dataType : "JSON",
          success : (data) => {
            swal(data.title,data.text,data.icon);
            table.ajax.reload(null,false);
          }
        });
      }
    });
  }

  var edit_pengaduan = (id_pengaduan) => {
    $.ajax({
      url : url_edit_pengaduan+"/"+id_pengaduan,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
       $('[name="id_pengaduan"]').val(data.id_pengaduan);
       $('[name="id_user"]').val(data.id_user);
       $('[name="id_kategori"]').val(data.id_kategori);
       $('[name="isi_laporan"]').val(data.isi_laporan);
       $('[name="waktu_lapor"]').val(data.waktu_lapor);
       $('[name="status"]').val(data.status);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit pengaduan'); // Set title to Bootstrap modal title


          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error get data from ajax');
          }
        });
  }

  var form_reset = () => {
    table.ajax.reload(null,false);
    $('form#form-pengaduan').find('input,select').val('');
  }

</script>
