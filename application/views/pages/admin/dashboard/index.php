<div class="container-fluid">
  <div class="row">
    <div class="col-lg-4 col-4">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?php echo $count_pengaduan_all; ?></h3>

          <p>Pengaduan</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="<?php echo base_url('Admin/pengaduan') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-4">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?php echo $count_artikel; ?></h3>

          <p>Artikel</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="<?php echo base_url('Admin/Posts') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-4">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3><?php echo $count_user; ?></h3>

          <p>User</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="<?php echo base_url('Admin/Posts') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-sm-4">
      <div class="form-group row">
        <label class="col-sm-2 col-md-2 col-form-label">Kategori</label>
        <div class="col-sm-10 col-md-10">
          <select name="select_kategori" class="form-control select2" id="select-kategori" style="width: 100%;">
            <option value="" selected disabled>Pilih Kategori</option>
            <?php foreach ($data['select_kategori'] as $key => $value): ?>
              <option value="<?php echo $value->id_kategori ?>"><?php echo $value->nama_kategori ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-sm-4">
      <div class="form-group row">
        <label class="col-sm-2 col-md-2 col-form-label">Tahun</label>
        <div class="col-sm-10 col-md-10">
          <select name="select_tahun" class="form-control select2" id="select-tahun" style="width: 100%;">
            <option value="" selected disabled>Pilih Tahun</option>
            <?php foreach ($data['tahun'] as $key => $value): ?>
              <option value="<?php echo $value->tahun; ?>"><?php echo $value->tahun;?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-sm-4">
      <button class="btn btn-info" onclick="get_data();">Submit</button>
    </div>
    <div class="col-lg-12 col-12">
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Grafik Pengaduan</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div>
            <canvas id="bar-per-kategori" class="chartjs" height="254" width="509" style="width: 509px; height: 254px;" data> </canvas>
          </div>
        </div>
      </div>
      
    </div>

  </div>

  
</div>
<script>

  var base_url_cname = '<?php echo base_url($cname) ?>';
  var periode_url = "";

  var base_cname = "<?php echo base_url($cname) ?>";
  $(document).ready(function(){

    $('#select-periode').change(function(){
      draw_chart($(this).val());
    })
    $('#select-periode').trigger('change');
  });
  
  // var chart1;
  // var draw_chart = (periode=null) => {
  //   if(chart1 != null){
  //     chart1.destroy();
  //   }

  //   if(periode != null){
  //     periode_url = "/"+periode;
  //   }

  //   $.ajax({
  //     url : base_url_cname+'/get_bar_pengaduan'+periode_url,
  //     success : (data) => {
  //       var json = $.parseJSON(data);

  //       var ctx = document.getElementById('bar-per-section').getContext('2d');
  //       $('#bar-per-section').parent().find('.fa-loading').remove();

  //       var c_labels = [];
  //       var d_data1 = [];
  //       var d_data2 = [];
  //       Object.keys(json.per_pic).forEach(function(key) {
  //         c_labels.push(key);
  //         d_data1.push(parseInt(json.per_pic[key].sto) || 0);
  //         d_data2.push(parseInt(json.per_pic[key].not_sto) || 0);
  //       })
  //       chart4 = new Chart(ctx, {
  //         type: 'bar',
  //         data: {
  //           labels: c_labels,
  //           datasets: [
  //           {
  //             label: 'STO',
  //             data: d_data1,
  //             backgroundColor: 'rgba(99, 255, 132, 1)',
  //             borderColor:  'rgba(99, 255, 132, 1)',
  //             borderWidth: 1
  //           },
  //           {
  //             label: 'NOT STO',
  //             data: d_data2,
  //             backgroundColor: 'rgba(255, 99, 132, 1)',
  //             borderColor: 'rgba(255, 99, 132, 1)',
  //             borderWidth: 1
  //           }
  //           ]
  //         },
  //         options: {
  //           scales: {
  //             xAxes: [{
  //               ticks: {
  //                 suggestedMin: 0, 
  //                 beginAtZero: true,
  //                 stepValue: 5,
  //                 stepSize : 5,
  //               }
  //             }]
  //           },
  //           plugins: {
  //             datalabels: {
  //               anchor : 'end',
  //               color: '#000',
  //               font : {
  //                 size : 15,
  //                 weight : 'bold',
  //               }
  //             }
  //           },
  //         }
  //       });
  //     }
  //   });


  var get_data = () => {
    var a = document.getElementById("select-kategori");
    var id_kategori = a.options[a.selectedIndex].value;

    var b = document.getElementById("select-tahun");
    var waktu_lapor = b.options[b.selectedIndex].value;

    $.ajax({
      url: base_cname+"/get_bar_pengaduan",
      type: 'POST',
      data: {id_kategori:id_kategori,waktu_lapor:waktu_lapor},
      success: function (data) {
        alert(data);
      },
    });
  }

  var ctx = document.getElementById('bar-per-kategori').getContext('2d');
  var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [{
        label: 'Tidak Teratasi',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        stack: 'Stack 0',
        data: [0, 10, 5, 2, 10, 30, 45]
      },{
        label: 'Sudah Teratasi',
        backgroundColor: 'rgb(40, 167, 69)',
        borderColor: 'rgb(40, 167, 69)',
        stack: 'Stack 0',
        data: [50, 10, 5, 2, 20, 10, 45]
      },{
        label: 'Belum Direspon',
        backgroundColor: 'rgb(108, 117, 125)',
        borderColor: 'rgb(108, 117, 125)',
        stack: 'Stack 0',
        data: [0, 10, 5, 2, 5, 30, 20]
      },{
        label: 'Tidak Bisa dihubungi',
        backgroundColor: 'rgb(23, 162, 184)',
        borderColor: 'rgb(23, 162, 184)',
        stack: 'Stack 0',
        data: [0, 10, 5, 2, 20, 30, 2]
      },
      ]
    },
    options: {
      title: {
        display: true,
        text: ['Grafik Pengaduan Kategori Penelantaran','Tahun 2019'],
        fontSize: 14,
        lineHeight: 2,
      },
    }
  });
</script>
