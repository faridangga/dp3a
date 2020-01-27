<div class="container-fluid">
	<div class="row">
		<div class="col-md-5 mb-4">
			<?php echo form_open('Admin/Report/get_report_layanan_lokasi',['id' => 'form-filter']) ?>
			<div class="form-group row mb-1 filter-input">
				<label for="" class="control-label col-form-label col-md-2 ml-1">Tanggal</label>
				<div class="col-md-7">
					<div class="input-daterange input-group" id="datepicker">
						<input value="<?php echo date('01/01/Y') ?>" type="text" class="form-control start" name="start">
						<div class="input-group-append">
							<span class="input-group-text bg-info b-0 text-white">TO</span>
						</div>
						<input value="<?php echo date('m/d/Y') ?>" type="text" class="form-control end" name="end">
					</div>
				</div>
				<div class="col-md-1">
					<button type="submit" class="btn btn-primary filter-input" id="laporan-kekerasan-submit">Submit</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table id="table-data" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" role="grid" aria-describedby="example23_info" style="width: 100%;" data-url="<?php echo base_url('Admin/Report/get_report_layanan_lokasi') ?>">
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
		<div class="col-lg-12 col-12">
			<div class="card card-default">
				<div class="card-header">
					<h3 class="card-title">Grafik Kekerasan</h3>

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
		var start_date = $('.start').val();
		var end_date = $('.end').val();
		var table_url = $('#table-data').data('url');
		table = $('#table-data').DataTable({
			orderCellsTop : true,
			dom: "'B<'row'<'col-6'l><'col-6'f>>rtip'",
			buttons: [
			{
				extend: 'excelHtml5',
				className : 'mb-2',
				title : 'Kekerasan Berdasarkan Lokasi Pada Tanggal ' + '\n' + start_date + ' - ' + end_date,
      },
			{
				extend: 'pdfHtml5',
				className : 'mb-2',
				title: 'Kekerasan Berdasarkan Lokasi Pada Tanggal ' + '\n' + start_date + ' - ' + end_date,
				customize: function(doc) {
					doc.styles.title = {
						alignment: 'center'
					}
				}
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
				"data": "nama_kecamatan",
			},
			{ 
				"title" : "Fisik",
				"data": "Fisik",
				"class": "text-center",
			},
			{ 
				"title" : "Psikis",
				"data": "Psikis",
				"class": "text-center",
			},
			{ 
				"title" : "Seksual",
				"data": "Seksual",
				"class": "text-center",
			},
			{ 
				"title" : "Eksploitasi",
				"data": "Eksploitasi",
				"class": "text-center",
			},
			{ 
				"title" : "Trafficking",
				"data": "Trafficking",
				"class": "text-center",
			},
			{ 
				"title" : "Penelantaran",
				"data": "Penelantaran",
				"class": "text-center",
			},
			{ 
				"title" : "Lainnya",
				"data": "Lainnya",
				"class": "text-center",
			},
			{ 
				"title" : "Total",
				"data": "Total",
				"class": "text-center",
			},
			]
		});

		$("form#form-filter").submit(function(e) {
			e.preventDefault();
			// var start = $('.start').val();
			// var end = $('.end').val();
			var formData = new FormData(this);    
			var url = $(this).attr('action');
			// alert(url)
			$.ajax({
				// url: 'Admin/Pengaduan/get_report_bar_layanan_lokasi',
				url : url,
				type: 'POST',
				// data: {start:start,end:end},
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
		$( "#laporan-kekerasan-submit" ).click(function() {
			draw_chart($(this).val());
		});

		$('#datepicker').datepicker({
			todayHighlight:'TRUE',
			autoclose: true,
		});

		// $('#laporan-kekerasan-submit').submit(function(){
		// 	draw_chart($(this).val());
		// })
		// $('.start').trigger('change');
		// $('.end').change(function(){
		// 	draw_chart($(this).val());
		// })
		// $('.end').trigger('change');
	});  

	var reload_table = (data) => {
		table.clear();
		table.rows.add(data);
		table.draw();
	} 	

	var draw_chart = () => {
		var start = $('.start').val();
		var end = $('.end').val();

		$.ajax({
			url: base_cname+"/get_report_bar_layanan_lokasi",
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
						text: ['Grafik Kekerasan Berdasarkan Lokasi Pada Tanggal', start + ' - ' + end ],
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
								beginAtZero: true,
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
