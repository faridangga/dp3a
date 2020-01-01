<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="col-lg-6 col-md-8 col-sm-12 pb-2">
            <?php echo form_open($cname.'/get_data_report',['id' => 'form-filter']) ?>
            <div class="form-group row mb-1 filter-input">
              <label for="" class="control-label col-form-label col-md-2">Year</label>
              <div class="col-md-9">
                <div class="input-group">
                  <input type="number" name="year" class="form-control" value="<?php echo date('Y') ?>" id="laporan-kekerasan-year">
                </div>
              </div>
            </div>
            <div class="form-group row mb-1 filter-input">
              <label for="" class="control-label col-form-label col-md-2">Lokasi</label>
              <div class="col-md-9">
                <select name="nama_kecamatan" id="" class="form-control">
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
    var table_url = $('#table-data').data('url');
    table = $('#table-data').DataTable({
      orderCellsTop : true,
      dom: "'B<'row'<'col-6'l><'col-6'f>>rtip'",
      buttons: [
      {
        extend: 'excelHtml5',
        className : 'mb-2',
      },
      {
        extend: 'pdfHtml5',
        className : 'mb-2',
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
        "title" : "Lokasi",
        "data": "nama_kecamatan" 
      },
      { 
        "title" : "Fisik",
        "data": "Fisik" 
      },
      { 
        "title" : "Psikis",
        "data": "Psikis" 
      },
      { 
        "title" : "Seksual",
        "data": "Seksual" 
      },
      { 
        "title" : "Eksploitasi",
        "data": "Eksploitasi" 
      },
      { 
        "title" : "Trafficking",
        "data": "Trafficking" 
      },
      { 
        "title" : "Penelantaran",
        "data": "Penelantaran" 
      },
      { 
        "title" : "Lainnya",
        "data": "Lainnya" 
      },
      { 
        "title" : "Total",
        "data": "Total" 
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
    
  });

  var reload_table = (data) => {
    table.clear();
    table.rows.add(data);
    table.draw();
  } 

</script>