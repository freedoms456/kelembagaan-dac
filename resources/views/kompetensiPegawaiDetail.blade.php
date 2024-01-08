@extends('layout.main')


@section('container')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Dashboard Kompetensi Pegawai</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard Kompetensi Pegawai</a></li>
                <li class="breadcrumb-item active">Detail</li>
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
        {{-- <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-4  col-sm-12 ">
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
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label">Nama Pegawai</label>
                        <select class="form-control custom-select">
                            <option value="">Pilih Pegawai</option>
                            <option value="">Semua Pegawai</option>
                            <option value="">Syahri Ramadhani</option>

                          </select>
                    </div>
                    <div class="col-sm-12 col-md-2 d-flex" style="align-items: end">
                        <button type="submit" class="btn btn-success ">
                          Cari Rekomendasi
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Column -->
    </div>
    <!-- ============================================================== -->
    <!-- End Sales Chart -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Projects of the Month -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-6 col-xlg-3 col-md-5">
            <div class="card">
              <div class="card-body">
                <center class="m-t-30">
                  <img src="https://images.unsplash.com/photo-1575936123452-b67c3203c357?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8aW1hZ2V8ZW58MHx8MHx8fDA%3D" class="img-circle" width="150" height="150">
                  <h4 class="card-title m-t-10"><?= $pegawai->name ?></h4>
                  <h6 class="card-subtitle"><?= $pegawai->jabatan ?></h6>
                  <hr>

              </div>
              <div class="card-body">
                <small class="text-muted">Masa Kerja </small>
                <h6><?= $pegawai->masa_kerja ?> Tahun</h6>
                <small class="text-muted">Satuan kerja </small>
                <h6>BPK Provinsi <?= $pegawai->satuan_kerja ?></h6>
                {{-- <small class="text-muted ">Nip</small>
                <h6>19800112200201001</h6> --}}
                <div class="alert-rekomendasi alert alert-info">
                    Kami Merekomendasikan Untuk meningkatkan Komptensi di bidang <strong>
                        @foreach($jabatanKeahlian as $data)
                            @if($data->avg_total > $data->total)
                                <span class="bidang-komp">{{ $data->kategori->name }}</span><br>

                            @endif

                        @endforeach
                    </strong>
                  </div>
              </div>

            </div>
        </div>
        <div class="col-lg-6 col-xlg-9 col-md-7">
            <div class="card">

              <!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane active" id="profile" role="tabpanel">
                  <div class="card-body">

                    <h4 class="font-medium m-t-30">Poin Komptensi Pegawai berdasarkan Jabatan serupa</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="table-responsive">
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th>Kompetensi</th>
                                      {{-- <th>Diklat</th>
                                      <th>Sertifikasi</th>
                                      <th>Kinerja</th>
                                      <th>Nilai SKP</th> --}}
                                      <th>Poin Kompetensi</th>
                                      <th>Rata Rata Nasional</th>

                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($jabatanKeahlian as $data)
                                    <tr>
                                      <td>{{ $data->kategori->name }}</td>
                                      {{-- <td>{{ $data->diklat }}</td>
                                      <td>{{ $data->sertifikasi }}</td>
                                      <td>{{ $data->kinerja }}</td>
                                      <td>{{ $data->skp }}</td> --}}
                                      <td style="{{ $data->total < $data->avg_total ? 'color: red;' : 'color: green' }}">
                                        {{ number_format($data->total, 2) }}
                                    </td>
                                    <td>
                                        {{ number_format($data->avg_total, 2) }}
                                    </td>

                                    </tr>
                                    @endforeach


                                  </tbody>
                                </table>
                              </div>
                        </div>

                    </div>


                  </div>
                </div>
              </div>
            </div>
          </div>

        <!-- Column -->
        <!-- Column -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <canvas id="radarChartPegawai" width="500" height="500"></canvas>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
@section('custom-script')
<script type="text/javascript">
 var table = $('.yajra-datatable').DataTable({});
 var labels = @json($jabatanKeahlian);
 let chartType = labels.length < 3 ? 'bar' : 'radar';
 var Kategori = labels.map(function(item) {
    return item.kategori.name;
});
var nilaiSAW =  labels.map(function(item) {
    return item.total;
});
var nilaiSAWRataRata =  labels.map(function(item) {
    return item.avg_total;
});
console.log(labels);
console.log(Kategori);

    if($('.bidang-komp').length < 1){
        $('.alert-rekomendasi').hide();
    }
    // Data for the radar chart
    var radarData = {
            labels: Kategori,
            datasets: [{
                label: 'Poin Individu',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                data: nilaiSAW // Replace with the actual data for the person's skills
            },
            {
                label: 'Rata Rata Seluruh Pegawai',
                backgroundColor: 'rgba(104, 52, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                data: nilaiSAWRataRata // Replace with the actual data for the person's skills
            }]
        };

        // Options for the radar chart
        var radarOptions = {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
            callbacks: {
                labels: function(tooltipItem, data) {
                    let labels = data.labels[tooltipItem.index];
                    // Limit label length to 5 words
                    if (label.split(' ').length > 5) {
                        label = label.split(' ').slice(0, 5).join(' ') + '...';
                    }
                    return label;
                }
            }
        },
            scales: {
                r: {
                    angleLines: {
                        display: false
                    },
                    suggestedMin: 0,
                    suggestedMax: 5
                }
            }
        };

        // Get the canvas element
        var ctx = document.getElementById('radarChartPegawai').getContext('2d');

        // Create the radar chart
        var radarChart = new Chart(ctx, {
            type: chartType,
            data: radarData,
            options: radarOptions
         });

    var barData = {
            labels: ['Provinsi', 'Bulungan', 'Tarakan', 'Malinau', 'Nunukan','KTT'],
            datasets: [{
                label: 'Jumlah',
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: [20, 35, 40, 15, 25,20] // Replace with your data values
            }]
        };

        // Options for the horizontal bar chart
        var barOptions = {
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
        var ctx = document.getElementById('horizontalBarChart').getContext('2d');

        // Create the horizontal bar chart
        var horizontalBarChart = new Chart(ctx, {
            type: 'bar',
            data: barData,
            options: barOptions
        });

</script>
@endsection
