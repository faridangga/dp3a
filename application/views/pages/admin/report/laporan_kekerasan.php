<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="col-lg-6 col-md-8 col-sm-12 pb-2">
            <?php echo form_open($cname.'/get_data_report',['id' => 'form-filter']) ?>
            <div class="form-group row mb-1 filter-input">
              <label for="" class="control-label col-form-label col-md-2">Year</label>
              <div class="col-md-5">
                <div class="input-group">
                  <input type="number" name="year" id="year" class="form-control" value="<?php echo date('Y') ?>" id="laporan-kekerasan-year">
<!--                   <div class="input-group-append">
                    <button type="button" class="btn btn-primary" id="btn-all-year">All Year</button>
                  </div> -->
                </div>
              </div>
            </div>
            <div class="form-group row mb-1 filter-input">
              <label for="" class="control-label col-form-label col-md-2">Lokasi</label>
              <div class="col-md-5">
                <select name="nama_kecamatan" id="lokasi" class="form-control">
                  <option value="" selected disabled>Choose</option>
                  <option value="0" selected>All</option>
                  <?php foreach ($data['select_lokasi'] as $key => $value): ?>
                    <option value="<?php echo $value->id_kecamatan ?>"><?php echo $value->nama_kecamatan ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="form-group row mb-0 mt-2">
              <label for="" class="control-label col-form-label col-md-2 filter-input"></label>
              <div class="col-md-9">
                <button type="submit" class="btn btn-primary filter-input" id="laporan-kekerasan-submit">Submit</button>
              </div>
            </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="table-data" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" role="grid" aria-describedby="example23_info" style="width: 100%;" data-url="<?php echo base_url($cname.'/get_data_report') ?>">
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
                  <th></th>
                  <th></th>

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

  var base_cname = "<?php echo base_url($cname) ?>";
  var table = "";
  $(document).ready(function() {
    var year = $('#year').val();
    var lokasi = $('#lokasi').val();
    if(lokasi == 0) {
      lokasi = "Semua Lokasi";
    }
    var table_url = $('#table-data').data('url');
    table = $('#table-data').DataTable({
      orderCellsTop : true,
      dom: "'B<'row'<'col-6'l><'col-6'f>>rtip'",
      buttons: [
      {
        extend: 'excelHtml5',
        className : 'mb-2',
        title : 'Rekap Jumlah Kekerasan Berdasarkan Lokasi Pada ' + '\n' + lokasi + ' Tahun ' + year,
      },
      {
        extend: 'pdfHtml5',
        className : 'mb-2',
        title: 'Rekap Jumlah Kekerasan Berdasarkan Lokasi Pada ' + '\n' + lokasi + ' Tahun ' + year,
        customize: function(doc) {
          doc.styles.title = {
            alignment: 'center',
            fontSize: '15',
          }
        }
      },
      ],
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
        "title" : "Bulan",
        "class": "text-center",
        data : (data, type, row, meta) => {
          ret = "";
          if(data.bulan == '1'){
            ret += '<span class="">Januari</span>';
          }else 
          if(data.bulan == '2'){
            ret += '<span class="">Februari</span>';
          }else 
          if(data.bulan == '3'){
            ret += '<span class="">Maret</span>';
          }else
          if(data.bulan == '4'){
            ret += '<span class="">April</span>';
          }else
          if(data.bulan == '5'){
            ret += '<span class="">Mei</span>';
          }else
          if(data.bulan == '6'){
            ret += '<span class="">Juni</span>';
          }else
          if(data.bulan == '7'){
            ret += '<span class="">Juli</span>';
          }else
          if(data.bulan == '8'){
            ret += '<span class="">Agustus</span>';
          }else
          if(data.bulan == '9'){
            ret += '<span class="">September</span>';
          }else
          if(data.bulan == '10'){
            ret += '<span class="">Oktober</span>';
          }else
          if(data.bulan == '11'){
            ret += '<span class="">November</span>';
          }else{
            ret += '<span class="">Desember</span>';
          }
          return ret;
        }
      },
      { 
        "title" : "Fisik",
        "data": "Fisik",
        "class": "text-center",
      },
      { 
        "title" : "Psikis",
        "data": "Psikis",
        "class": "text-center",
      },
      { 
        "title" : "Seksual",
        "data": "Seksual",
        "class": "text-center",
      },
      { 
        "title" : "Eksploitasi",
        "data": "Eksploitasi",
        "class": "text-center",
      },
      { 
        "title" : "Trafficking",
        "data": "Trafficking",
        "class": "text-center",
      },
      { 
        "title" : "Penelantaran",
        "data": "Penelantaran",
        "class": "text-center",
      },
      { 
        "title" : "Lainnya",
        "data": "Lainnya",
        "class": "text-center",
      },
      { 
        "title" : "Total",
        "data": "Total",
        "class": "text-center",
      },
      ]
    });

    $("form#form-filter").submit(function(e) {
      e.preventDefault();
      var formData = new FormData(this);    
      var url = $(this).attr('action');
      $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function (data) {
          var json = $.parseJSON(data);
          reload_table(json.data);
        },
        cache: false,
        contentType: false,
        processData: false
      });
    });

    $('#laporan-kekerasan-submit').click();
    // $('#btn-all-year').on('click',function(){
    //   if(!$(this).parent().parent().find('#laporan-kekerasan-year').attr('disabled')){
    //     $(this).parent().parent().find('#laporan-kekerasan-year').attr('disabled',true);
    //   }else{
    //     $(this).parent().parent().find('#laporan-kekerasan-year').attr('disabled',false)
    //   }
    // })
    
  });

var reload_table = (data) => {
  table.clear();
  table.rows.add(data);
  table.draw();
} 

</script>