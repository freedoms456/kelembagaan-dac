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
                        <select id="perwakilan" class="form-control custom-select">
                            <!-- <option value="all">Pilih Perwakilan</option>
                            <option value="all">Semua Perwakilan</option>
                            <option value="Jogja">Yogyakarta</option>
                            <option value="Kaltara">Kalimantan Utara</option> -->
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="kategori-sert">Kategori/Bidang Sertifikasi</label>
                        <select name="bidang" id="bidang" class="form-control" placeholder="Pilih Kategori">
                            @foreach($kategori as $kategoris)
                            <option value="{{$kategoris->id }}_{{$kategoris->name}}">{{$kategoris->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <button type="button" id="cari" class="btn btn-primary" style="margin-top: 25px;">Cari</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <label class="control-label">Data Sertifikasi</label>
                            <table class="table" id="myTable2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sertifikasi</th>
                                        <th>Bidang</th>
                                        <th>Jumlah Pegawai yang memiliki</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="control-label">Chart Sertifikasi yang diambil pegawai</label>
                        <canvas id="horizontalBarChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>
        <!-- <script type="module" src="dimensions.js"></script> -->


    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <label class="control-label">Detail Sertifikasi yang diambil</label>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <input type="hidden" id="urlDataTable" value="{{ route('sertifikasi.list') }}">
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <label class="control-label">Jenis Sertifikasi yang diambil</label>
                    <canvas id="pie-satker" width="400" height="400"></canvas>

                </div>
            </div>
            <input type="hidden" id="urlDataTable2" value="{{ route('sertifikasiMilik.list') }}">
        </div>
    </div>
</div>

@endsection
@section('custom-script')
<script type="text/javascript">
//  var table = $('#myTable').DataTable({});
 var myChart = null;
 var table = null;
 var table2 = null;

var optionsArray = [
        { value: 'all', text: 'Pilih Perwakilan' },
        { value: 'all', text: 'Semua Perwakilan' },
        { value: 'Banten', text: 'Banten' },
        { value: 'Jogja', text: 'Yogyakarta' },
        { value: 'Kalsel', text: 'Kalimantan Selatan' },
        { value: 'Kaltara', text: 'Kalimantan Utara' },
        { value: 'Kepri', text: 'Kepulauan Riau' },
        { value: 'Maluku', text: 'Maluku' },
        { value: 'NTB', text: 'Nusa Tenggara Barat' }
        // Add more options as needed
    ];

    // Get the select element by its ID
    var selectInput = document.getElementById('perwakilan');

    // Loop through the array to create options and append them to the select element
    optionsArray.forEach(function (option) {
        var optionElement = document.createElement('option');
        optionElement.value = option.value;
        optionElement.text = option.text;
        selectInput.appendChild(optionElement);
    });
var pieSatker = null;
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
                    d.perwakilan = document.getElementById('perwakilan').value
                    d.bidang = document.getElementById('bidang').value
                },



            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'pegawai.name', name: 'pegawai.name'},
                {data: 'pegawai.satuan_kerja', name: 'pegawai.satuan_kerja'},
                {data: 'sertifikasi.nama', name: 'sertifikasi.nama'},

            ]
            });

        function updateChart() {
            var perwakilan = document.getElementById('perwakilan').value;
            var bidang = document.getElementById('bidang').value;
            // var selectedYear = document.getElementById('year').value;

            // Make an Ajax request to get the data for the selected month and year

             $.ajax({
                method: 'GET',
                url: '/sertifikasi/getSertifikasiBasedOnName',
                data: {
                    perwakilan: perwakilan,
                    bidang: bidang
                },
                success: function (data) {
                    let labels = data.map(item => item.nama);
                    let values = data.map(item => item.total);

                    // Check if myChart exists and destroy it before creating a new one
                    if (myChart !== null) {
                        myChart.destroy();
                    }

                    let chartData = {
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

                    let chartConfig = {
                        type: 'bar',
                        data: chartData,
                        options: {
                            indexAxis: 'y',

                        }
                    };

                    let ctx = document.getElementById('horizontalBarChart');

                    // If myChart exists, remove the previous chart
                    if (myChart !== null) {
                        myChart.destroy();
                    }

                    // Create the new chart
                    myChart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
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

            $.ajax({
                method: 'GET',
                url: '/sertifikasi/getSertifikasiByJenis',
                data: {
                    perwakilan: perwakilan,
                    bidang: bidang
                },
                success: function (data) {
                    let labels = data.map(item => item.bidang);
                    let values = data.map(item => item.total);

                    // Check if myChart exists and destroy it before creating a new one

                    var pieData = {
                        labels:labels,
                        datasets: [{
                            label: 'Jumlah',

                            data: values // Replace with your data values
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
                          // If myChart exists, remove the previous chart
                        if (pieSatker !== null) {
                            pieSatker.destroy();
                        }

                        // Create the horizontal bar chart
                        pieSatker = new Chart(ctx, {
                            type: 'pie',
                            data: pieData,
                            options: pieOptions
                        });


                    // Create the new chart

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
                    d.perwakilan = document.getElementById('perwakilan').value
                    d.bidang = document.getElementById('bidang').value
                },



            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'pegawai.name', name: 'pegawai.name'},
                {data: 'pegawai.satuan_kerja', name: 'pegawai.satuan_kerja'},
                {data: 'sertifikasi.nama', name: 'sertifikasi.nama'},

            ]
            });
            // TABLE 2
            if (table2 !== null) {
                table2.destroy(); // Destroy the DataTable instance if it exists
            }
            table2 = $('#myTable2').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url : $('#urlDataTable2').val(),
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data : function(d) {
                    d.perwakilan = document.getElementById('perwakilan').value
                    d.bidang = document.getElementById('bidang').value
                },



            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nama', name: 'nama'},
                {data: 'bidang', name: 'bidang'},
                {data: 'total', name: 'total'},

            ]
            });
        }
</script>
@endsection
