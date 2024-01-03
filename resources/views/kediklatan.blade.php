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
                          <h2 class="m-b-0"><?= $jumlahDiklat;?></h2>
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
                          <h2 class="m-b-0"><?= $jumlahJenisDiklat;?></h2>
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
                          <h2 class="m-b-0"><?= $totalJP;?></h2>
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
                            <select id="kategori" class="form-control custom-select">
                                <option value="Pemeriksaan Keuangan">Pemeriksaan Keuangan</option>
                                <option value="Programmer">Prograsmmer</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-2 d-flex" style="align-items: end">
                            <button type="submit" id="cari" class="btn btn-success ">
                            Cari
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-md-5">
                        <canvas id="pie-jabatan" width="600" height="600"></canvas>
                    </div>


                    <div class="col-md-7">
                        <input type="hidden" id="urlDataTable" value="{{ route('kediklatan.list') }}">
                        <table id="myTable" class="table table-bordered yajra-datatable  mt-3">
                            <thead>
                                <tr>
                                    <th style="width:50px">No</th>
                                    <th>Nama Diklat</th>
                                    <th style="width:50px">JP</th>
                                    <th style="width:50px">Jumlah Peserta </th>
                                </tr>
                            </thead>

                        </table>
                        {{-- <canvas id="pie-satker" width="400" height="400"></canvas> --}}
                    </div>
                    <div class="col-md-6">
                        <canvas id="line-tren" width="400" height="400"></canvas>
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
     var pieJabatan = null;
     var table = null;
     $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })


        $("#cari").click(function (e) {
            updateChart();
            getDataTable();
        });

        });




    var table = $('.yajra-datatable').DataTable({});


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

    function updateChart() {
            var kategori = document.getElementById('kategori').value;
            // var selectedYear = document.getElementById('year').value;

            // Make an Ajax request to get the data for the selected month and year

             $.ajax({
                method: 'GET',
                url: '/kediklatan/getPieJabatan',
                data: {
                    kategori: kategori
                },
                success: function (data) {
                    let labels = data.map(item => item.jabatan);
                    let values = data.map(item => item.total);


                       let pieData2 = {
                        labels: labels,
                        datasets: [{
                            label: 'Total',
                            data: values,
                            axis: 'y',
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    };



                    // Get the canvas element
                    var ctx = document.getElementById('pie-jabatan').getContext('2d');

                    if (pieJabatan !== null) {
                        pieJabatan.destroy();
                    }
                    // Create the horizontal bar chart
                    pieJabatan = new Chart(ctx, {
                        type: 'bar',
                        data: pieData2,
                        options: {
                            indexAxis: 'y',
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }

                    });


                }
            });



     }

     function getDataTable(){
            if (table !== null) {
                table.destroy(); // Destroy the DataTable instance if it exists
            }
            table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url : $('#urlDataTable').val(),
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data : function(d) {
                    d.kategori = document.getElementById('kategori').value
                },



            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'jp', name: 'jp'},
                {data: 'total', name: 'total'},

            ]
            });
            // TABLE 2


        }



</script>
@endsection
