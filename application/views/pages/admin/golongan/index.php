<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Title</h3>

        </div>
        <div class="card-body">
          <?php echo form_open($cname.'/insert',['id'=>'form-crud']); ?>
          <input type="hidden" class="form-control" name="id_golongan" placeholder="">
          <div class="form-group">
            <label>Nama Golongan</label>
            <input type="text" class="form-control" name="nama_golongan" placeholder="">
          </div>
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" name="status">
              <option value="1">1</option>
              <option value="2">2</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="reset" class="btn btn-secondary">Reset</button>
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
        "title" : "Id Golongan",
        "class" : "text-center",
        "width" : "50px",
        "data": "id_golongan" 
      },
      { 
        "title" : "Nama Golongan",
        "data": "nama_golongan" 
      },
      { 
        "title" : "Status",
        "data": "status" 
      },
      {
        "title": "Actions",
        "width" : "120px",
        "visible":true,
        "class": "text-center",
        "data": (data, type, row) => {
          let ret = "";
          ret += ' <a class="btn btn-info btn-sm" href="#" onclick="fill_form('+data.id_golongan+'); return false;"><i class="fas fa-pencil-alt"></i> Edit</a>';
          ret += ' <a class="btn btn-danger btn-sm" href="#" onclick="delete_golongan(this)" data-id="'+data.id_golongan+'"><i class="fas fa-trash-alt"></i> Delete</a>';

          return ret;
        }
      }
      ]
    });


  });


  var fill_form = (id_golongan) => {
    $.ajax({
      url: url_fill_form,
      type: 'POST',
      data: {
        'id_golongan' : id_golongan
      },
      success: function (data) {
        var json = $.parseJSON(data);
        let form = $('#form-crud');
        form.find('[name="id_golongan"]').val(json.id_golongan);
        form.find('[name="nama_golongan"]').val(json.nama_golongan);
        form.find('[name="status"]').val(json.status);
        scroll_smooth('body',500);
      },
    });
  }

  var delete_golongan = (obj) => {
    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if(willDelete){
        $.ajax({
          url : base_cname+"/delete_golongan",
          type : 'POST',
          data : {
            id_golongan : $(obj).data('id_golongan'),
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

</script>