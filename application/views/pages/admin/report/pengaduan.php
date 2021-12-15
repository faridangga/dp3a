<div class="container-fluid">
    <div class="row">
        <?php
        $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

        ?>
        <?php
        $no = 1;
        foreach ($bulan as $b) :
        ?>
            <div class="col-md-6">

                <!-- PIE CHART -->

                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title"><?= $b ?></h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChart<?= $no; ?>" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
        <?php
            $no++;
        endforeach;
        ?>
        <!-- /.col (LEFT) -->

        <!-- /.col (RIGHT) -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->

<script>
    $(function() {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */


        //-------------
        //- DONUT CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        // var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        // var donutData = {
        //     labels: [
        //         'Chrome',
        //         'IE',
        //         'FireFox',
        //         'Safari',
        //         'Opera',
        //         'Navigator',
        //     ],
        //     datasets: [{
        //         data: [700, 500, 400, 600, 300, 100],
        //         backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        //     }]
        // }
        // var donutOptions = {
        //     maintainAspectRatio: false,
        //     responsive: true,
        // }
        // //Create pie or douhnut chart
        // // You can switch between pie and douhnut using the method below.
        // new Chart(donutChartCanvas, {
        //     type: 'doughnut',
        //     data: donutData,
        //     options: donutOptions
        // })

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        <?php
        for ($x = 1; $x <= 12; $x++) {
        ?>
            var pieChartCanvas = $('#pieChart<?= $x; ?>').get(0).getContext('2d')
            var pieData = {
                labels: [
                    'Fisik',
                    'Psikis',
                    'Seksual',
                    'Eksploitasi',
                    'Penelantaran',
                    'Lainnya',
                ],
                datasets: [{
                    data: [Math.floor(Math.random() * 20), Math.floor(Math.random() * 20), Math.floor(Math.random() * 20), Math.floor(Math.random() * 20), Math.floor(Math.random() * 20), Math.floor(Math.random() * 20)],
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }]
            }
            //var pieData = donutData;
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })
        <?php
        }
        ?>



    })
</script>