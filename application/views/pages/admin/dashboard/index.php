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
        <a href="<?php echo base_url('Admin/Users') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-sm-4">
      <div class="form-group row">
        <label class="col-sm-2 col-md-2 col-form-label">Kategori</label>
        <div class="col-sm-10 col-md-10">
          <select name="select_kategori" class="form-control select2" id="select-kategori" style="width: 100%;">
            <option value="0" selected>Semua Kategori</option>
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
            <!-- <option value="<?php echo date('Y') ?>" selected disabled><?php echo date('Y') ?></option> -->
            <option value="0" selected>Semua Tahun</option>
            <?php foreach ($data['tahun'] as $key => $value): ?>
              <option value="<?php echo $value->tahun; ?>"><?php echo $value->tahun;?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-sm-4">
      <!-- <button class="btn btn-info" onclick="draw_chart()">Submit</button> -->
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
            <canvas id="bar_pengaduan" height="254" width="509" style="width: 509px; height: 254px;" data> </canvas>
          </div>
        </div>
      </div>
      
    </div>

    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="table-data" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" role="grid" aria-describedby="example23_info" style="width: 100%;" data-url="<?php echo base_url('Dashboard/get_table_pengaduan') ?>">
              <thead>
                <tr>
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
  var table = "";
  var base_cname = "<?php echo base_url($cname) ?>";
  $(document).ready(function(){
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
        "title" : "Nama Kategori",
        data : (data, type, row, meta) => {
          ret = "";
          if(data.id_kategori == '1'){
            ret += 'Fisik';
          }else 
          if(data.id_kategori == '2'){
            ret += 'Psikis';
          }else 
          if(data.id_kategori == '3'){
            ret += 'Seksual';
          }else 
          if(data.id_kategori == '4'){
            ret += 'Eksploitasi';
          }else 
          if(data.id_kategori == '5'){
            ret += 'Trafficking';
          }else 
          if(data.id_kategori == '6'){
            ret += 'Penelantaran';
          }else{
            ret += 'Lainnya';
          }
          return ret;
        } 
      },
      { 
        "title" : "Sudah Direspon",
        "class": "text-center",
        "data": "jumlah_direspon" 
      },
      { 
        "title" : "Belum Direspon",
        "class": "text-center",
        "data": "jumlah_blm_direspon" 
      },
      ]
    });

    $('#select-kategori').change(function(){
      draw_chart($(this).val());
    })
    $('#select-kategori').trigger('change');
    $('#select-tahun').change(function(){
      draw_chart($(this).val());
    })
    $('#select-tahun').trigger('change');
  });

  var draw_chart = () => {

    var kategori = document.getElementById("select-kategori");
    var id_kategori = kategori.options[kategori.selectedIndex].value;
    var nama_kategori = "";
    if(id_kategori == 1){
      nama_kategori = "Fisik";
    } else if(id_kategori == 2){
      nama_kategori = "Psikis";
    } else if(id_kategori == 3){
      nama_kategori = "Seksual";
    } else if(id_kategori == 4){
      nama_kategori = "Eksploitasi";
    } else if(id_kategori == 5){
      nama_kategori = "Trafficking";
    } else if(id_kategori == 6){
      nama_kategori = "Penelantaran";
    } else if(id_kategori == 7){
      nama_kategori = "Lainnya";
    } else if(id_kategori == 0){
      nama_kategori = "Semua Kategori";
    } 

    var tahun = document.getElementById("select-tahun");
    var waktu_lapor = tahun.options[tahun.selectedIndex].value;
    var nama_tahun = "";
    if(waktu_lapor != 0){
      nama_tahun = tahun.options[tahun.selectedIndex].value;
    } else {
      nama_tahun = "Semua";
    }

    $.ajax({
      url: base_cname+"/get_chart_pengaduan",
      type: 'POST',
      data: {id_kategori:id_kategori,waktu_lapor:waktu_lapor},
      success: function (data) {


        var json = $.parseJSON(data);

        var ctx = document.getElementById('bar_pengaduan').getContext('2d');

        var datasets = [];
        Object.keys(json.label).forEach(function(key) {
          datasets.push({
            label: json.label[key],
            backgroundColor: json.backgroundColor[key],
            borderColor: json.borderColor[key],
            data: json.data[key],
            borderWidth : 1,
          });
        })

        var optionBar = {
          title: {
            display: true,
            text: ['Grafik Pengaduan Kategori ' + nama_kategori,'Tahun ' + nama_tahun ],
            fontSize: 14,
            lineHeight: 2,
          },
          tooltips: {
            mode: 'index',
            intersect: false
          },
          responsive: true,
          scales: {
            xAxes: [{
              stacked: true,
            }],
            yAxes: [{
              ticks: {
                stepSize: 1
              },
              stacked: true
            }]
          },
          
        }
        var data = {
          labels: json.labels,
          datasets: datasets,
        };

        if(window.chart1 != undefined){
          window.chart1.destroy(); 
        }

        window.chart1 = new Chart(ctx, {
          type: 'bar',

          data: data,

          options: optionBar
        });

      }
    });
  }


</script>
