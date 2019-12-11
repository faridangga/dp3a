<div class="container-fluid">
  <div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>150</h3>

          <p>New Orders</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>53<sup style="font-size: 20px">%</sup></h3>

          <p>Bounce Rate</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>44</h3>

          <p>User Registrations</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>65</h3>

          <p>Unique Visitors</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small card -->
      <div class="small-box bg-success">
        <!-- Loading (remove the following to stop the loading)-->
        <div class="overlay dark">
          <i class="fas fa-3x fa-sync-alt"></i>
        </div>
        <!-- end loading -->
        <div class="inner">
          <h3>53<sup style="font-size: 20px">%</sup></h3>

          <p>Bounce Rate</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">
          More info <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group row pr-3 mb-2">
        <label for="" class="control-label col-form-label col-md-2">category</label>
        <div class="col-md-12">
          <select name="fk_category" class="form-control select2" id="select-category" style="width: 100%;">
            <?php foreach ($data['combo_sto_periode'] as $key => $value): ?>
              <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-12">
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Primary Outline</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div>
            <div class="fa-loading">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
            <canvas id="chartjs-4" height="254" width="509" style="width: 509px; height: 254px;" data> </canvas>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
<script>new Chart(document.getElementById("chartjs-4"),{"type":"doughnut","data":{"labels":["Red","Blue","Yellow"],"datasets":[{"label":"My First Dataset","data":[300,50,100],"backgroundColor":["rgb(255, 99, 132)","rgb(54, 162, 235)","rgb(255, 205, 86)"]}]}});</script>

<!-- <script>
  var base_url_cname = '<?php echo base_url($cname) ?>';
  var category_url = "";
  $(document).ready(function(){
    $('#select-category').change(function(){
      draw_chart($(this).val());
    })
    $('#select-category').trigger('change');
  });

  var chart1,chart2,chart3,chart4;
  var draw_chart = (category=null) => {
    if(chart1 != null){
      chart1.destroy();
    }
    if(chart2 != null){
      chart2.destroy();
    }
    if(chart3 != null){
      chart3.destroy();
    }
    if(chart4 != null){
      chart4.destroy();
    }

    if(category != null){
      category_url = "/"+category;
    }

    $.ajax({
      url : base_url_cname+'/get_pengaduan_1'+category_url,
      success : (data) => {
        var json = $.parseJSON(data);
        var ctx4 = document.getElementById("dg-pengaduan-1").getContext("2d");
        $('#dg-pengaduan-1').parent().find('.fa-loading').remove();
        var data4 = {
          datasets: [{
            backgroundColor : ['#12a605','#FFC12C'],
            data: [json.count_sto, json.count_not_sto]
          }],

          labels: [
          'done',
          'un done',
          ]
        };

        chart1 = new Chart(ctx4, {
          type: 'doughnut',
          data: data4,
          options: {
            legend: {
              position : 'left',
              display: true,
              labels: {

              }
            },
            plugins: {
              datalabels: {
                anchor : 'center',
                color: '#000',
                font : {
                  size : 15,
                  weight : 'bold',
                }
              }
            },
            elements: {
              center: {
                text: json.count_sto+json.count_not_sto,
                color: '#000',
                fontStyle: 'Helvetica',
                sidePadding: 15
              }
            }
          }
        });

        var ctx = document.getElementById('bar-per-section').getContext('2d');
        $('#bar-per-section').parent().find('.fa-loading').remove();


        var c_labels = [];
        var d_data1 = [];
        var d_data2 = [];
        Object.keys(json.per_pic).forEach(function(key) {
          c_labels.push(key);
          d_data1.push(parseInt(json.per_pic[key].sto) || 0);
          d_data2.push(parseInt(json.per_pic[key].not_sto) || 0);
        })
        chart4 = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: c_labels,
            datasets: [
            {
              label: 'STO',
              data: d_data1,
              backgroundColor: 'rgba(99, 255, 132, 1)',
              borderColor:  'rgba(99, 255, 132, 1)',
              borderWidth: 1
            },
            {
              label: 'NOT STO',
              data: d_data2,
              backgroundColor: 'rgba(255, 99, 132, 1)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1
            }
            ]
          },
          options: {
            scales: {
              xAxes: [{
                ticks: {
                  suggestedMin: 0, 
                  beginAtZero: true,
                  stepValue: 5,
                  stepSize : 5,
                }
              }]
            },
            plugins: {
              datalabels: {
                anchor : 'end',
                color: '#000',
                font : {
                  size : 15,
                  weight : 'bold',
                }
              }
            },
          }
        });
      }
    });
  }
  

</script> -->
