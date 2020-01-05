<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?php echo $title ?></h3>

        </div>
        <div class="card-body">
          <?php echo form_open($cname.'/insert',['id'=>'form-data-kekerasan']); ?>
          <input type="hidden" class="form-control" name="id_laporan" placeholder="">
          <div class="form-group">
            <label>Bulan</label>
            <input type="text" class="form-control" name="bulan" placeholder="">
          </div>
          <div class="form-group">
            <label>Tahun</label>
            <input type="text" class="form-control" name="tahun" placeholder="">
          </div>
          <div class="form-group">
            <label>Usia 19-24</label>
            <input type="text" class="form-control" name="usia_1" placeholder="">
          </div>
          <div class="form-group">
            <label>Usia 25-44</label>
            <input type="text" class="form-control" name="usia_2" placeholder="">
          </div>
          <div class="form-group">
            <label>Usia 45+</label>
            <input type="text" class="form-control" name="usia_3" placeholder="">
          </div>
          <div class="form-group">
            <label>Fisik</label>
            <input type="text" class="form-control" name="fsk" placeholder="">
          </div>
          <div class="form-group">
            <label>Psikologi</label>
            <input type="text" class="form-control" name="psi" placeholder="">
          </div>
          <div class="form-group">
            <label>Seksual</label>
            <input type="text" class="form-control" name="seks" placeholder="">
          </div>
          <div class="form-group">
            <label>Eksploitasi</label>
            <input type="text" class="form-control" name="eks" placeholder="">
          </div>
          <div class="form-group">
            <label>Penelantaran</label>
            <input type="text" class="form-control" name="penelantaran" placeholder="">
          </div>
          <div class="form-group">
            <label>Lain-lain</label>
            <input type="text" class="form-control" name="lain" placeholder="">
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
                  <th></th>
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
        "title" : "Bulan",
        "data": "bulan" 
      },
      { 
        "title" : "Tahun",
        "data": "tahun" 
      },
      { 
        "title" : "Usia 19-24",
        "data": "usia_1" 
      },
      { 
        "title" : "Usia 25-44",
        "data": "usia_2" 
      },
      { 
        "title" : "Usia 45+",
        "data": "usia_3" 
      },
      { 
        "title" : "Fisik",
        "data": "fsk" 
      },
      { 
        "title" : "Psikologi",
        "data": "psi" 
      },
      { 
        "title" : "Seksual",
        "data": "seks" 
      },
      { 
        "title" : "Eksploitasi",
        "data": "eks" 
      },
      { 
        "title" : "Penelantaran",
        "data": "penelantaran" 
      },
      { 
        "title" : "Lain-lain",
        "data": "lain" 
      },
      {
        "title": "Actions",
        "width" : "120px",
        "visible":true,
        "class": "text-center th-sticky-action",
        "data": (data, type, row) => {
          let ret = "";
          ret += ' <a class="btn btn-info btn-sm text-white" onclick="fill_form('+data.id_laporan+'); return false;"><i class="fas fa-pencil-alt"></i> Edit</a>';
          ret += ' <a class="btn btn-danger btn-sm text-white" onclick="delete_kategori(this)" data-id="'+data.id_laporan+'"><i class="fas fa-trash-alt"></i> Delete</a>';

          return ret;
        }
      }
      ]
    });

    $('form#form-data-kekerasan').submit(function(e){
      var form = $(this);
      e.preventDefault();

      $.ajax({
        url: url_insert_kategori_laporan,
        type: 'POST',
        data: form.serialize(),
        dataType : "JSON",
        success: function (data) {
          // let json = $.parseJSON(data);
          swal(data.title,data.text,data.icon);
          form_reset();
        }
      });
    });
  });


  var fill_form = (id_laporan) => {
    $.ajax({
      url: url_fill_form,
      type: 'POST',
      data: {
        'id_laporan' : id_laporan
      },
      success: function (data) {
        var json = $.parseJSON(data);
        let form = $('#form-data-kekerasan');
        form.find('[name="id_laporan"]').val(json.id_laporan);
        form.find('[name="bulan"]').val(json.bulan);
        form.find('[name="tahun"]').val(json.tahun);
        form.find('[name="usia_1"]').val(json.usia_1);
        form.find('[name="usia_2"]').val(json.usia_2);
        form.find('[name="usia_3"]').val(json.usia_3);
        form.find('[name="fsk"]').val(json.fsk);
        form.find('[name="psi"]').val(json.psi);
        form.find('[name="seks"]').val(json.seks);
        form.find('[name="eks"]').val(json.eks);
        form.find('[name="penelantaran"]').val(json.penelantaran);
        form.find('[name="lain"]').val(json.lain);
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
            id_laporan : $(obj).data('id'),
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
    $('form#form-data-kekerasan').find('input,select').val('');
  }

</script>