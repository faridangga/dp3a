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
  <div class="modal-dialog modal-lg">
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
          <div class="row">
            <div class="col-6">
              <fieldset class="border p-2">
                <legend  class="w-auto">Data Pelapor</legend>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" name="nama" placeholder="" readonly>
                </div>
                <div class="form-group">
                  <label>No. Telp</label>
                  <input type="text" class="form-control" name="nomor_telp" placeholder="" readonly>
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control" name="alamat" rows="2" readonly></textarea>
                </div>
              </fieldset>           
            </div>
            <div class="col-6">
              <fieldset class="border p-2">
                <legend  class="w-auto">Data Pengaduan</legend>
                <div class="form-group">
                  <label>Kategori</label>
                  <input type="text" class="form-control" name="id_kategori" placeholder="" readonly>
                </div>
                <div class="form-group">
                  <label>Kronologi</label>
                  <textarea class="form-control" name="isi_laporan" rows="2" readonly></textarea>
                </div>
                <div class="form-group">
                  <label>Waktu Laporan</label>
                  <input type="text" class="form-control" name="waktu_lapor" placeholder="" readonly>
                </div>
              </fieldset>           
            </div>

            <div class="col-6">
              <fieldset class="border p-2">
                <legend  class="w-auto">Data Korban</legend>
                <div class="form-group">
                  <label>Jenis Kelamin</label>
                  <input type="text" class="form-control" name="jenis_kelamin" placeholder="" readonly>
                </div>
                <div class="form-group">
                  <label>Usia</label>
                  <input type="text" class="form-control" name="usia" placeholder="" readonly>
                </div>
                <div class="form-group">
                  <label>Kecamatan</label>
                  <input type="text" class="form-control" name="kecamatan" placeholder="" readonly>
                </div>
                <div class="form-group">
                  <label>Desa</label>
                  <input type="text" class="form-control" name="desa" placeholder="" readonly>
                </div>
                <div class="form-group">
                  <label>Dusun</label>
                  <input type="text" class="form-control" name="dusun" placeholder="" readonly>
                </div>
              </fieldset>
            </div>

            <div class="col-6 mt-2">
              <div class="form-group">
                <label>Status</label>
                <select name="status" id="" class="form-control">
                  <option value="" selected disabled>Pilih</option>
                  <?php foreach ($data['select_status_pengaduan'] as $key => $value): ?>
                    <option value="<?php echo $value->id_status ?>"><?php echo $value->nama_status ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label>Layanan yang diberikan</label>
                <select name="layanan" id="" class="form-control">
                  <option value="" selected disabled>Pilih</option>
                  <?php foreach ($data['select_layanan'] as $key => $value): ?>
                    <option value="<?php echo $value->id_layanan ?>"><?php echo $value->nama_layanan ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
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
        "title" : "Layanan",
        "data": "nama_layanan" 
      },
      { 
        "title" : "Status",
        "class" : "th-sticky-status",
        data : (data, type, row, meta) => {
          ret = "";
          if(data.id_status == '0'){
            ret += '<span class="badge bg-warning">Belum Direspon</span>';
          }else 
          if(data.id_status == '4'){
            ret += '<span class="badge text-white" style="background: #fd7e14">Sedang di proses</span>';
          }else 
          if(data.id_status == '1'){
            ret += '<span class="badge bg-success">Sudah Teratasi</span>';
          }else
          if(data.id_status == '2'){
            ret += '<span class="badge bg-danger">Tidak Teratasi</span>';
          }else
          if(data.id_status == '3'){
            ret += '<span class="badge bg-secondary">Tidak Bisa dihubungi</span>';
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
       // $('[name="jenis_kelamin"]').val(data.jenis_kelamin);
       $('[name="nama"]').val(data.nama);
       $('[name="usia"]').val(data.usia);
       $('[name="kecamatan"]').val(data.nama_kecamatan);
       $('[name="desa"]').val(data.desa);
       $('[name="dusun"]').val(data.dusun);
       $('[name="nomor_telp"]').val(data.nomor_telp);
       $('[name="id_kategori"]').val(data.nama_kategori);
       $('[name="isi_laporan"]').val(data.isi_laporan);
       $('[name="waktu_lapor"]').val(data.waktu_lapor);
       $('[name="status"]').val(data.status);
       $('[name="layanan"]').val(data.layanan);
       
       $('#modal_form').modal('show');
       $('.modal-title').text('Edit pengaduan');
       if(data.jenis_kelamin == 'P'){
         $('[name="jenis_kelamin"]').val('Perempuan');
       } else {
         $('[name="jenis_kelamin"]').val('Laki-Laki');
       }
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
