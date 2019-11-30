<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <?php echo form_open($cname.'/insert',['id'=>'form-posts']); ?>
          <input type="hidden" class="form-control" name="id" placeholder="">
          <div class="form-group row">
            <label class="col-sm-2 col-md-2 col-form-label">Judul</label>
            <div class="col-sm-10 col-md-10">
              <input type="text" class="form-control" name="title" placeholder="">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-md-2 col-form-label">content</label>
            <div class="col-sm-10 col-md-10">
             <textarea name="content" class="textarea" placeholder="Place some text here" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
              <?php echo $value->content ?>
            </textarea>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">category_id</label>
          <div class="col-sm-10 col-md-10">
            <select name="category_id" id="" class="form-control">
              <option value="" selected disabled>Choose</option>
              <?php foreach ($data['select_kategori_post'] as $key => $value): ?>
                <option value="<?php echo $value->id_kategori ?>"><?php echo $value->nama_kategori ?></option>

              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">image_content</label>
          <div class="col-sm-10 col-md-10">
            <input type="text" class="form-control" name="image_content" placeholder="image_content">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">hit</label>
          <div class="col-sm-10 col-md-10">
            <input type="text" class="form-control" name="hit" placeholder="hit">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">is_slider</label>
          <div class="col-sm-10 col-md-10 col-form-label">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="is_slider1" name="is_slider" class="custom-control-input">
              <label class="custom-control-label" value="1" for="is_slider1">Aktif</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="is_slider2" name="is_slider" class="custom-control-input">
              <label class="custom-control-label" value="0" for="is_slider2">Tidak Aktif</label>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">is_recommended</label>
          <div class="col-sm-10 col-md-10 col-form-label">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="is_recommended1" name="is_recommended" class="custom-control-input">
              <label class="custom-control-label" value="1" for="is_recommended1">Aktif</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="is_recommended2" name="is_recommended" class="custom-control-input">
              <label class="custom-control-label" value="0" for="is_recommended2">Tidak Aktif</label>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">visibility</label>
          <div class="col-sm-10 col-md-10 col-form-label">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="visibility1" name="visibility" class="custom-control-input">
              <label class="custom-control-label" value="1" for="visibility1">Aktif</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="visibility2" name="visibility" class="custom-control-input">
              <label class="custom-control-label" value="0" for="visibility2">Tidak Aktif</label>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">post_type</label>
          <div class="col-sm-10 col-md-10">
            <input type="text" class="form-control" name="post_type" placeholder="post_type">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">image_url</label>
          <div class="col-sm-10 col-md-10">
            <input type="file" id="input-file-now" class="dropify" name="image_url" />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">video_embed_code</label>
          <div class="col-sm-10 col-md-10">
            <input type="text" class="form-control" name="video_embed_code" placeholder="video_embed_code">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">user_id</label>
          <div class="col-sm-10 col-md-10">
            <select name="category_id" id="" class="form-control">
              <option value="" selected disabled>Choose</option>
              <?php foreach ($data['select_admins'] as $key => $value): ?>
                <option value="<?php echo $value->id_admin ?>"><?php echo $value->nama ?></option>

              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">Status</label>
          <div class="col-sm-10 col-md-10">
            <select class="form-control" name="status">
              <option value="" selected disabled>Choose</option>
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">created_at</label>
          <div class="col-sm-10 col-md-10">
            <input type="text" class="form-control" name="created_at" placeholder="created_at">
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
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

<script>

  var url_fill_form = '<?php echo base_url($cname.'/get_data_by_id') ?>';
  var url_insert_posts = '<?php echo base_url($cname.'/insert') ?>';
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
        "title" : "Id",
        "class" : "text-center",
        "width" : "50px",
        "data": "id" 
      },
      { 
        "title" : "title",
        "data": "title",
      },
      {
        "title" : "content",
        "data": "content",
      },
      {
        "title" : "category_id",
        "data": "category_id",
      },
      {
        "title" : "image_content",
        "data": "image_content",
      },
      {
        "title" : "hit",
        "data": "hit",
      },
      {
        "title" : "is_slider",
        data : (data, type, row, meta) => {
          ret = "";
          if(data.is_slider == '1'){
            ret += '<span class="badge bg-success">Aktif</span>';
          }else if(data.is_slider == '0'){
            ret += '<span class="badge bg-warning">Tidak Aktif</span>';
          }else{
            ret += '<span class="badge bg-secondary">loss</span>';
          }
          return ret;
        }
      },
      {
        "title" : "is_recommended",
        data : (data, type, row, meta) => {
          ret = "";
          if(data.is_recommended == '1'){
            ret += '<span class="badge bg-success">Aktif</span>';
          }else if(data.is_recommended == '0'){
            ret += '<span class="badge bg-warning">Tidak Aktif</span>';
          }else{
            ret += '<span class="badge bg-secondary">loss</span>';
          }
          return ret;
        } 
      },
      {
        "title" : "visibility",
        "data": "visibility",
      },
      {
        "title" : "post_type",
        "data": "post_type",
      },
      {
        "title" : "image_url",
        "data": "image_url",
      },
      {
        "title" : "video_embed_code",
        "data": "video_embed_code",
      },
      {
        "title" : "user_id",
        "data": "user_id",
      },
      { 
        "title" : "Status", 
        data : (data, type, row, meta) => {
          ret = "";
          if(data.status == '1'){
            ret += '<span class="badge bg-success">Aktif</span>';
          }else if(data.status == '0'){
            ret += '<span class="badge bg-danger">Tidak Aktif</span>';
          }else{
            ret += '<span class="badge bg-secondary">loss</span>';
          }
          return ret;
        } 
      },
      {
        "title" : "created_at",
        "data": "created_at",
      },
      {
        "title": "Actions",
        "visible":true,
        "class": "text-center th-sticky-action",
        "data": (data, type, row) => {
          let ret = "";
          if (data.is_slider == '0') {
            ret += ' <a class="btn btn-success btn-sm" href="#"> Aktif Slide </a>'
          }else if(data.is_slider == '1'){
            ret += ' <a class="btn btn-danger btn-sm" href="#"> Non Aktif Slide </a>';
          }

          if (data.is_recommended == '0') {
            ret += ' <a class="btn btn-success btn-sm" href="#"> Aktif Recommended</a>'
          }else if(data.is_recommended == '1'){
            ret += ' <a class="btn btn-danger btn-sm" href="#"> Non Aktif Recommended</a>';
          }

          ret += ' <a class="btn btn-info btn-sm" href="#" onclick="fill_form('+data.id+'); return false;"><i class="fas fa-pencil-alt"></i> Edit</a>';
          ret += ' <a class="btn btn-danger btn-sm" href="#" onclick="delete_kategori(this)" data-id="'+data.id+'"><i class="fas fa-trash-alt"></i> Delete</a>';          

          return ret;
        }
      }
      ]
    });

    $('form#form-posts').submit(function(e){
      var form = $(this);
      e.preventDefault();

      $.ajax({
        url: url_insert_posts,
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


  var fill_form = (id) => {
    $.ajax({
      url: url_fill_form,
      type: 'POST',
      data: {
        'id' : id
      },
      success: function (data) {
        var json = $.parseJSON(data);
        let form = $('#form-posts');
        form.find('[name="id"]').val(json.id);
        form.find('[name="title"]').val(json.title);
        form.find('[name="content"]').val(json.content);
        form.find('[name="category_id"]').val(json.category_id);
        form.find('[name="status"]').val(json.status);
        alert(json.content);
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
            id : $(obj).data('id'),
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
    $('form#form-posts').find('input,select').val('');
  }

  $(function () {
    // Summernote
    $('.textarea').summernote('code');
    $('.dropify').dropify();
  })

</script>