@extends('layout.main')


@section('container')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Monitoring Sertifikasi Pegawai</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Monitoring Sertifikasi Pegawai</li>
            </ol>
        </div>
        <div class="col-md-7 align-self-center">
            {{-- <a href="https://www.wrappixel.com/templates/adminwrap/"
                class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down text-white"> Upgrade to
                Pro</a> --}}
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Sales Chart and browser state-->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card row">
                <div class="card-body row">
                    <div class="col-3">
                        <label class="control-label">Perwakilan</label>
                        <select class="form-control custom-select">
                            <option value="">Pilih Perwakilan</option>
                            <option value="">Semua Perwakilan</option>
                            <option value="">Nusa Tenggara Barat</option>
                            <option value="">Kalimantan Utara</option>
                            <option value="">Kalimantan Barat</option>
                            <option value="">Kalimantan Selatan</option>
                            <option value="">Kalimantan Timur</option>
                        </select>
                    </div>

                    <div class="col-3">
                        <label for="kategori-sert">Kategori/Bidang Sertifikasi</label>
                        <select name="" id="kategori-sert" class="form-control" placeholder="Pilih Kategori">
                            <option value="">Pilih Kategori</option>
                            <option value="">Akuntansi</option>
                            <option value="">Audit</option>
                            <option value="">Audit Forensik</option>
                            <option value="">Coaching</option>
                            <option value="">Data Analitik</option>
                            <option value="">Forensik</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn btn-primary" style="margin-top: 25px;">Cari</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-5">
                        <canvas id="pie-satker" width="400" height="400"></canvas>
                    </div>
                    <div class="col-md-5">
                        <canvas id="horizontalBarChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>
        <!-- <script type="module" src="dimensions.js"></script> -->


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Perwakilan</th>
                                    <th>Sertifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Deshmukh</td>
                                    <td>BPK perwakilan provinsi Kalimantan Utara</td>
                                    <td>Prohaska</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Deshmukh</td>
                                    <td>BPK perwakilan provinsi Kalimantan Utara</td>
                                    <td>Gaylord</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Sanghani</td>
                                    <td>BPK perwakilan provinsi Kalimantan Utara</td>
                                    <td>Gusikowski</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Roshan</td>
                                    <td>BPK perwakilan provinsi Kalimantan Utara</td>
                                    <td>Rogahn</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Joshi</td>
                                    <td>BPK perwakilan provinsi Kalimantan Utara</td>
                                    <td>Hickle</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Nigam</td>
                                    <td>BPK perwakilan provinsi Kalimantan Utara</td>
                                    <td>Eichmann</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('custom-script')
<script type="text/javascript">
 var table = $('#myTable').DataTable({});
var pieData = {
            labels: ['Banten', 'Jogja', 'Kalsel', 'Kaltara', 'Kepri','Maluku','NTB'],
            datasets: [{
                label: 'Jumlah',

                data: [20, 35, 40, 15, 25,20] // Replace with your data values
            }]
        };

        // Options for the horizontal bar chart
        var pieOptions = {
            indexAxis: 'y',
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true // Start the x-axis at zero
                    }
                }]
            }
        };

        // Get the canvas element
        var ctx = document.getElementById('pie-satker').getContext('2d');

        // Create the horizontal bar chart
        var pieSatker = new Chart(ctx, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        });

        var barData = {
            labels: ['AK', 'CA', 'CPSAK', 'CPA', 'CMA','ACPA','AAP B','AAP A','CGAA','AAP'],
            datasets: [{
                label: 'Jumlah',
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
                ],
                borderWidth: 1,
                data: [20, 35, 40, 15, 25,20, 21, 10,13, 5] // Replace with your data values
            }]
        };

        // Options for the horizontal bar chart
        var barOptions = {
            scales: {
                      y: {
                        beginAtZero: true
                        }
                    }
        };

        // Get the canvas element
        var ctx = document.getElementById('horizontalBarChart').getContext('2d');

        // Create the horizontal bar chart
        var horizontalBarChart = new Chart(ctx, {
            type: 'bar',
            data: barData,
            options: barOptions
        });

</script>
@endsection
