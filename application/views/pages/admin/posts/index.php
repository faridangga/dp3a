<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <?php echo form_open_multipart($cname.'/insert',['id'=>'form-posts']); ?>
          <input type="hidden" class="form-control" name="id" placeholder="">
          <div class="form-group row">
            <label class="col-sm-2 col-md-2 col-form-label">Judul</label>
            <div class="col-sm-10 col-md-10">
              <input type="text" class="form-control" name="title" placeholder="Judul">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-md-2 col-form-label">Content</label>
            <div class="col-sm-10 col-md-10">
             <textarea name="content" class="textarea" placeholder="Place some text here" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
             </textarea>
           </div>
         </div>
         <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">Category</label>
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
          <label class="col-sm-2 col-md-2 col-form-label">Image Url</label>
          <div class="col-sm-10 col-md-10">
            <input type="file" id="input-file-now" class="dropify" name="image_url"/>
            <p class="text-danger">*Wajib diisi</p>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">Post Type</label>
          <div class="col-sm-10 col-md-10">
            <input type="text" class="form-control" name="post_type" placeholder="post_type">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">Video Embed Code</label>
          <div class="col-sm-10 col-md-10">
            <input type="text" class="form-control" name="video_embed_code" placeholder="video_embed_code">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">Status</label>
          <div class="col-sm-10 col-md-10">
            <select class="form-control" name="status">
              <option value="1">Aktif</option>
              <option value="0" selected>Tidak Aktif</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-md-2 col-form-label">Slider</label>
          <div class="col-sm-10 col-md-10">
            <select class="form-control" id="status" name="is_slider">
              <option value="1">Aktif</option>
              <option value="0" selected>Tidak Aktif</option>
            </select>
          </div>
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
          <table id="table-data" class="table table-hover table-striped table-bordered table-responsive border-collapse" cellspacing="0" width="100%" role="grid" aria-describedby="example23_info"  data-url="<?php echo base_url($cname.'/get_data') ?>">
            <thead>
              <tr>
                <th></th>
                <th></th>
                <th class="text-center"></th>
                <th></th>
                <th></th>

                <th class="text-center"></th>
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
      responsive : true,
      dom: "<'row'<'col-6'l><'col-6'f>>rtip'",
      "ajax": {
        'url': table_url,
      },
      "columns": [
      {
        "title" : "No",
        "width" : "1px",
        "data": null,
        "class": "text-center",
        render: (data, type, row, meta) => {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      { 
        "title" : "Title",
        "data": "title",
      },
      {
        "title" : "Content",
        "data": "content",
        "width" : "300px",
      },
      {
        "title" : "Category",
        "data": "nama_kategori",
      },
      {
        "title" : "Slider",
        "class" : "text-center",
        data : (data, type, row, meta) => {
          ret = "";
          if(data.is_slider == '1'){
            ret += '<span class="badge bg-success">Aktif</span>';
          }else if(data.is_slider == '0'){
            ret += '<span class="badge bg-danger">Tidak Aktif</span>';
          }else{
            ret += '<span class="badge bg-secondary">loss</span>';
          }
          return ret;
        } 
      },
      {
        "title" : "Post Type",
        "data": "post_type",
        "class" : "text-center",
        "width" : "150px",
      },
      // {
      //   "title" : "Image Url",
      //   "data" : "image_url",
      //   "class" : "text-center",
      //   "render": function (data) {
      //     return '<img src="<?php echo base_url() ?>'+ data + '" style="height:150px; width:150px"/>';
      //   }
      // },
      // {
      //   "title" : "Video Embed Code",
      //   "data": "video_embed_code",
      // },
      {
        "title" : "User",
        "data": "nama",
      },
      { 
        "title" : "Status",
        "width" : "1px",
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
        "title": "Actions",
        "width" : "25%",
        "class": "text-center th-sticky-action",
        "data": (data, type, row) => {
          let ret = "";
          if (data.is_slider == '0') {
            ret += ' <a class="btn btn-success btn-sm text-white" onclick="is_slider(this)" data-id="'+data.id+'""> Aktif Slider</a>'
          }else if(data.is_slider == '1'){
            ret += ' <a class="btn btn-danger btn-sm text-white" onclick="is_slider(this)" data-id="'+data.id+'""> Non Aktif Slider</a>';
          }

          ret += ' <a class="btn btn-info btn-sm text-white" onclick="fill_form('+data.id+'); return false;"><i class="fas fa-pencil-alt"></i> Edit</a>';
          ret += ' <a class="btn btn-danger btn-sm text-white" onclick="delete_posts(this)" data-id="'+data.id+'"><i class="fas fa-trash-alt"></i> Delete</a>';          

          return ret;
        }
      }
      ]
    });

    // $('form#form-posts').submit(function(e){
    //   var form = $(this);
    //   e.preventDefault();

    //   $.ajax({
    //     url: url_insert_posts,
    //     type: 'POST',
    //     data: form.serialize(),
    //     dataType : "JSON",
    //     success: function (data) {
    //       // let json = $.parseJSON(data);
    //       swal(data.title,data.text,data.icon);
    //       scroll_smooth('table',500);
    //       form_reset();
    //     }
    //   });
    // });
    $('#datepicker').datepicker({
      todayHighlight:'TRUE',
      autoclose: true,
    });

    $('.textarea').summernote();
    $('.dropify').dropify();
    
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
        form.find('.note-editable').html(json.content);
        form.find('[name="content"]').val(json.content);
        form.find('[name="category_id"]').val(json.category_id);
        form.find('[name="hit"]').val(json.hit);
        form.find('[name="post_type"]').val(json.post_type);
        // form.find('.dropify').html(base_cname+json.image_url);
        form.find('[name="video_embed_code"]').val(json.video_embed_code);
        form.find('[name="user_id"]').val(json.user_id);
        form.find('[name="status"]').val(json.status);
        form.find('[name="is_slider"]').val(json.is_slider);
        // $("#input-file-now").removeClass('dropify').addClass('dropify');
        $("#input-file-now").attr("data-default-file", base_cname+json.image_url);
        // $('.dropify').dropify();
        scroll_smooth('body',500);
      },
    });
  }

  var delete_posts = (obj) => {
    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if(willDelete){
        $.ajax({
          url : base_cname+"/delete_posts",
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

  var is_slider = (obj) => {
    swal({
      title: 'Apakah yakin ?',
      text: "Akan merubah status!",
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if(willDelete){
        $.ajax({
          url : base_cname+"/update_is_slider",
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
    $('form#form-posts').find('input,select,datepicker,radio').val('');
    $('form#form-posts').find('.note-editable').html('');
    $('form#form-posts').find('.dropify-clear').trigger("click");
    $('[data-toggle="buttons"] :radio').prop('checked', false);
  }

  $(function () {
    // Summernote
  })

</script>