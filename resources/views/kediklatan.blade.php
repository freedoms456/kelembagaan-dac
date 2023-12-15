@extends('layout.main')


@section('container')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Kediklatan</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Kediklatan</li>
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
                <!-- Column -->
                <div class="col-lg-4 col-md-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex p-10 no-block">
                        <div class="align-slef-center">
                          <h2 class="m-b-0">234</h2>
                          <h6 class="text-muted m-b-0">Jumlah Diklat</h6>
                        </div>
                        <div class="align-self-center display-6 ml-auto">
                          <i class="text-success icon-Target-Market"></i>
                        </div>
                      </div>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 70%; height: 3px">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-4 col-md-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex p-10 no-block">
                        <div class="align-slef-center">
                          <h2 class="m-b-0">10</h2>
                          <h6 class="text-muted m-b-0">Jenis Diklat</h6>
                        </div>
                        <div class="align-self-center display-6 ml-auto">
                          <i class="text-info icon-Dollar-Sign"></i>
                        </div>
                      </div>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 70%; height: 3px">
                        <span class="sr-only">50% Complete</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-4 col-md-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex p-10 no-block">
                        <div class="align-slef-center">
                          <h2 class="m-b-0">4470</h2>
                          <h6 class="text-muted m-b-0">Total JP</h6>
                        </div>
                        <div class="align-self-center display-6 ml-auto">
                          <i class="text-primary icon-Inbox-Forward"></i>
                        </div>
                      </div>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 70%; height: 3px">
                        <span class="sr-only">50% Complete</span>
                      </div>
                    </div>
                  </div>
                </div>


                <!-- Column -->
                <!-- Column -->

                <!-- Column -->
                <!-- Column -->
              </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4  col-sm-12 ">
                            <label class="control-label">Pilih Jenis Diklat</label>
                            <select class="form-control custom-select">
                                <option value="">Pemeriksaan LKPD</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-2 d-flex" style="align-items: end">
                            <button type="submit" class="btn btn-success ">
                            Cari
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-md-3">
                        <canvas id="pie-jabatan" width="400" height="400"></canvas>
                    </div>

                    <div class="col-md-3">
                        <canvas id="line-tren" width="400" height="400"></canvas>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered yajra-datatable mt-3">
                            <thead>
                                <tr>
                                    <th>Nama Diklat</th>
                                    <th>JP</th>
                                    <th>Jumlah Peserta </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr role="row">
                                    <td class="">Perhitungan Aset</td>
                                    <td>30</td>
                                    <td>50</td>
                                </tr>
                                <tr role="row">
                                    <td class="">Arus Kas</td>
                                    <td>30</td>
                                    <td>60</td>
                                </tr>
                                <tr role="row">
                                    <td class="">Pemanfaatan BIDICS dalam pemeriksaan Keuangan</td>
                                    <td>40</td>
                                    <td>65</td>
                                </tr>


                            </tbody>
                        </table>
                        {{-- <canvas id="pie-satker" width="400" height="400"></canvas> --}}
                    </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
        <!-- <script type="module" src="dimensions.js"></script> -->


</div>

@endsection
@section('custom-script')
<script>
     var table = $('.yajra-datatable').DataTable({});
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
    // var ctx = document.getElementById('pie-satker').getContext('2d');

    // Create the horizontal bar chart
    // var pieSatker = new Chart(ctx, {
    //     type: 'pie',
    //     data: pieData,
    //     options: pieOptions
    // });

    var lineData = {
        labels: ['2021','2022','2023'],
        datasets: [{
            label: 'Peserta per Tahun',
            data: [50,60, 65],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    };

    // Options for the horizontal bar chart
    var lineOptions = {
        scales: {
                  y: {
                    beginAtZero: true
                    }
                }
    };

    // Get the canvas element
    var ctx = document.getElementById('line-tren').getContext('2d');

    // Create the horizontal bar chart
    var horizontalBarChart = new Chart(ctx, {
        type: 'line',
        data: lineData,
        options: lineOptions
    });


    var pieData2 = {
        labels: ['Pemeriksa Ahli Muda', 'Pemeriksa Ahli Madya', 'Pemeriksa Ahli pertama'],
        datasets: [{
            label: 'Jumlah',

            data: [20, 15, 65] // Replace with your data values
        }]
    };

    // Get the canvas element
    var ctx = document.getElementById('pie-jabatan').getContext('2d');

    // Create the horizontal bar chart
    var pieSatker = new Chart(ctx, {
        type: 'pie',
        data: pieData2,
        options: pieOptions
    });
</script>
@endsection
