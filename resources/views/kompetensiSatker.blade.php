@extends('layout.main')


@section('container')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Dashboard Kompetensi Pegawai per-Satker</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Dashboard Kompetensi Pegawai per-Satker</li>
            </ol>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Sales Chart and browser state-->
    <!-- ============================================================== -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4  col-sm-12 ">
                            <label class="control-label">Jabatan</label>
                            <select id="jabatan" class="form-control custom-select">
                                <option value="all">Semua Jabatan</option>
                                {{-- <option value="all">Semua Perwakilan</option> --}}
                                @foreach($jabatan as $data)
                                <option value="{{$data->jabatan}}">{{$data->jabatan}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4  col-sm-12 ">
                            <label class="control-label">Bidang</label>
                            <select id="kategori" class="form-control custom-select">
                                {{-- <option value="">Pilih Bidang</option> --}}
                                @foreach($kategori as $kategoris)
                                <option value="{{$kategoris->id }}_{{$kategoris->name}}">{{$kategoris->name}}</option>
                                @endforeach
                                </select>
                        </div>

                        <div class="col-sm-12 col-md-2 d-flex" style="align-items: end">
                            <button id="cari" type="submit" class="btn btn-success ">
                            Cari
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <h5 class="mt-5"> Rata Rata Kompetensi</h5>
                        <table id="myTable" class="table table-bordered yajra-datatable mt-3">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Satker</th>
                                    <th>Diklat</th>
                                    <th>Sertifikasi</th>
                                    <th>Kinerja</th>
                                    <th>SKP</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">

                        <h5 class="mt-5"><strong> Clustering </strong></h5>
                        <br>
                        <div id="information">
                        <div class="row">
                            <div class="col-md-2">
                                <strong>Centroid 1:</strong> <span id="centroid1"></span>
                            </div>
                            <div class="col-md-2">
                                <strong>Centroid 2:</strong> <span id="centroid2"></span>
                            </div>
                            <div class="col-md-2">
                            <strong>Iteration Count:</strong> <span id="iterationCount"></span>
                            </div>
                        </div>



                        </div>
                        <canvas id="histogramChart" width="800" height="400"></canvas>
                    </div>
            </div>
        </div>
        <!-- Column -->
    </div>

</div>

@endsection
@section('custom-script')
<script type="text/javascript">
   // Data scatter plot untuk masing-masing kategori
     var table = null;
     var table2 = null;
    var histogramChart = null;
     $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })


        $("#cari").click(function (e) {

            // getDataTable();
            getDataTable();
            calculateKmeans();
        });


    });

    function getDataTable(){
        if (table !== null) {
            table.destroy(); // Destroy the DataTable instance if it exists
         }
        table = $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
                ajax: {
                    url : "/perhitunganSAWS/get-datatablePerwakilan",
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    },
                    data : function(d) {
                        d.jabatan = document.getElementById('jabatan').value,
                        d.kategori = document.getElementById('kategori').value
                    },
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'satuan_kerja', name: 'satuan_kerja'},
                    {data: 'avg_diklat', name: 'avg_diklat'},
                    {data: 'avg_sertifikasi', name: 'avg_sertifikasi'},
                    {data: 'avg_kinerja', name: 'avg_kinerja'},
                    {data: 'avg_skp', name: 'avg_skp'},
                    {data: 'avg_totals', name: 'avg_totals'}

                ]
                });
    }

    function calculateKmeans(){
            // console.log("test");
            $.ajax({
                url: '/perhitunganKmeans/calculate', // URL to your Laravel route
                method: 'POST',
                data : {
                    kategori : document.getElementById('kategori').value,
                    jabatan : document.getElementById('jabatan').value
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    const scores = data.average_totals;
                    const kmeansResults = data.kmeans_result;
                    document.getElementById('centroid1').innerText = data.centroids.centroid_1.toFixed(2);
                    document.getElementById('centroid2').innerText = data.centroids.centroid_2.toFixed(2);
                    document.getElementById('iterationCount').innerText = data.iteration_count;

                    if (histogramChart !== null) {
                        histogramChart.destroy();
                    }

                    // Sort scores
                    const sortedScores = Object.entries(scores).sort((a, b) => a[1] - b[1]);
                    const sortedNames = sortedScores.map(([name]) => name);
                    const sortedValues = sortedScores.map(([_, value]) => value);
                    const colors = sortedNames.map(name => kmeansResults[name] === 0 ? 'rgba(54, 162, 235, 0.5)' : 'rgba(54, 162, 35, 0.5)');

                    // Create the histogram chart
                    const ctx = document.getElementById('histogramChart').getContext('2d');
                    histogramChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: sortedNames,
                            datasets: [{
                                label: 'Average Score',
                                data: sortedValues,
                                backgroundColor: colors,
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            },
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Histogram of Average Scores by Region'
                            }
                        }
                    });
                    // getDataTable();
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });


    }



//    END
        const dataRendah = [];
        const dataSedang = [];
        const dataTinggi = [];

        // Generate data untuk setiap kategori
        for (let i = 0; i < 15; i++) {
            dataRendah.push({ x: Math.random() * 5, y: Math.random() * 5 });
            dataSedang.push({ x: Math.random() * 5 + 3, y: Math.random() * 5 + 3 });
            dataTinggi.push({ x: Math.random() * 5 + 6, y: Math.random() * 5 + 6 });
        }

        // Data untuk scatter plot (kategori rendah)
        const scatterDataRendah = {
            label: 'Rendah',
            data: dataRendah,
            backgroundColor: 'rgba(255, 99, 132, 0.5)', // Warna untuk kategori rendah
            pointRadius: 10
        };

        // Data untuk scatter plot (kategori sedang)
        const scatterDataSedang = {
            label: 'Sedang',
            data: dataSedang,
            backgroundColor: 'rgba(54, 162, 235, 0.5)', // Warna untuk kategori sedang
            pointRadius: 10
        };

        // Data untuk scatter plot (kategori tinggi)
        const scatterDataTinggi = {
            label: 'Tinggi',
            data: dataTinggi,
            backgroundColor: 'rgba(75, 192, 192, 0.5)', // Warna untuk kategori tinggi
            pointRadius: 10
        };

        // Menggambar scatter plot dengan Chart.js
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'scatter',
            data: {
                datasets: [scatterDataRendah, scatterDataSedang, scatterDataTinggi] // Tambahkan dataset untuk setiap kategori
            },
            options: {
                // Atur opsi grafik sesuai kebutuhan
                // Contoh: atur skala sumbu x dan y, judul grafik, dll.
                scales: {
                    x: {
                        // Atur konfigurasi sumbu x
                        // Contoh: title: { display: true, text: 'Sumbu X' }
                    },
                    y: {
                        // Atur konfigurasi sumbu y
                        // Contoh: title: { display: true, text: 'Sumbu Y' }
                    }
                }
            }
        });
</script>
@endsection
