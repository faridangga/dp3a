<div class="container-fluid">
  <div class="row">
    <div class="col-lg-4 col-4">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>30</h3>

          <p>Pengaduan</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-4">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>20</h3>

          <p>Artikel</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-4">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>60</h3>

          <p>User</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-sm-4">
      <div class="form-group row">
        <label class="col-sm-2 col-md-2 col-form-label">Kategori</label>
        <div class="col-sm-10 col-md-10">
          <select name="select_kategori" class="form-control select2" style="width: 100%;">
            <option value="" selected disabled>Choose</option>
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
          <select name="select_tahun" class="form-control select2" style="width: 100%;">
            <option value="" selected disabled>Choose</option>
            <?php foreach ($data['select_kategori'] as $key => $value): ?>
              <option value="<?php echo $value->id_kategori ?>"><?php echo date('Y', strtotime($value->waktu_lapor));?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>
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
            <canvas id="myChart" class="chartjs" height="254" width="509" style="width: 509px; height: 254px;" data> </canvas>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
<script>

  var ctx = document.getElementById('myChart').getContext('2d');
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
