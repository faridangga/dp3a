<div class="container-fluid">
	<div class="row">
		<div class="col-md-5 mb-4">
			<div class="form-group row mb-1 filter-input">
				<label for="" class="control-label col-form-label col-md-2 ml-1">Tanggal</label>
				<div class="col-md-8">
					<div class="input-daterange input-group" id="datepicker">
						<input value="<?php echo date('01/01/Y') ?>" type="text" class="form-control start" name="start">
						<div class="input-group-append">
							<span class="input-group-text bg-info b-0 text-white">TO</span>
						</div>
						<input value="<?php echo date('m/d/Y') ?>" type="text" class="form-control end" name="end">
					</div>
					
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-12">
			<div class="card card-default">
				<div class="card-header">
					<h3 class="card-title">Grafik Layanan</h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					<div>
						<canvas id="bar_layanan" height="254" width="509" style="width: 509px; height: 254px;" data> </canvas>
					</div>
				</div>
			</div>

		</div>

	</div>


</div>
<script>
	var base_cname = "<?php echo base_url($cname) ?>";
	$(document).ready(function(){

		$('#datepicker').datepicker({
			todayHighlight:'TRUE',
			autoclose: true,
		});

		$('.start').change(function(){
			draw_chart($(this).val());
		})
		$('.start').trigger('change');
		$('.end').change(function(){
			draw_chart($(this).val());
		})
		$('.end').trigger('change');
	});  

	

	var draw_chart = () => {
		var start = $('.start').val();
		var end = $('.end').val();

		$.ajax({
			url: base_cname+"/get_report_layanan",
			type: 'POST',
			data: {start:start,end:end},
			success: function (data) {
				var json = $.parseJSON(data);
				var ctx = document.getElementById('bar_layanan').getContext('2d');

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
						text: ['Grafik Layanan Pada Tanggal', start + ' - ' + end ],
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
						}],
						yAxes: [{
							ticks: {
								stepSize: 1
							},
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
