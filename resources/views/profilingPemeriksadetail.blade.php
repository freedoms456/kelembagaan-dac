@extends('layout.main')


@section('container')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Profiling Pemeriksa</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Profiling Pemeriksa</li>
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
                    {{-- <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="vertical-header">Riwayat Pendidikan</th>
                                <td></td>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="vertical-header">Masa Kerja</th>
                                <td>20 Tahun</td>

                            </tr>
                        </tbody>
                    </table> --}}
                    <h4 class="font-medium m-t-30">Poin Pemeriksa berdasarkan SAW</h4>
                    <hr>
                    <div class="row">
                    <div class="col-md-12">
                        <canvas id="radarChartPegawai" width="400" height="400"></canvas>
                    </div>
                    <div class="col-md-5">
                        {{-- <canvas id="horizontalBarChart" width="400" height="400"></canvas> --}}
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
    <!-- ============================================================== -->
    <!-- End Projects of the Month -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Notification And Feeds -->
    <!-- ============================================================== -->
    {{-- <div class="row">
        <!-- Start Notification -->
        <div class="col-lg-8 col-md-12">
            <div class="card card-body mailbox">
                <h5 class="card-title">Data Kompetensi Pegawai</h5>
                <div class="message-center" style="height: 420px !important;">
                    <!-- Message -->
                    <a href="#">
                        <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                        <div class="mail-contnet">
                            <h6 class="text-dark font-medium mb-0">Luanch Admin</h6> <span class="mail-desc">Just see the my new admin!</span>
                            <span class="time">9:30 AM</span>
                        </div>
                    </a>
                    <!-- Message -->
                    <a href="#">
                        <div class="btn btn-success btn-circle"><i class="fa fa-calendar-check-o"></i></div>
                        <div class="mail-contnet">
                            <h6 class="text-dark font-medium mb-0">Event today</h6> <span class="mail-desc">Just a reminder that you have
                                event</span> <span class="time">9:10 AM</span>
                        </div>
                    </a>
                    <!-- Message -->
                    <a href="#">
                        <div class="btn btn-info btn-circle"><i class="fa fa-cog text-white"></i></div>
                        <div class="mail-contnet">
                            <h6 class="text-dark font-medium mb-0">Settings</h6> <span class="mail-desc">You can customize this template as you
                                want</span> <span class="time">9:08 AM</span>
                        </div>
                    </a>
                    <!-- Message -->
                    <a href="#">
                        <div class="btn btn-primary btn-circle"><i class="fa fa-user"></i></div>
                        <div class="mail-contnet">
                            <h6 class="text-dark font-medium mb-0">Pavan kumar</h6> <span class="mail-desc">Just see the my admin!</span> <span
                                class="time">9:02 AM</span>
                        </div>
                    </a>
                    <!-- Message -->
                    <a href="#">
                        <div class="btn btn-info btn-circle"><i class="fa fa-cog text-white"></i></div>
                        <div class="mail-contnet">
                            <h6 class="text-dark font-medium mb-0">Customize Themes</h6> <span class="mail-desc">You can customize this template as you
                                want</span> <span class="time">9:08 AM</span>
                        </div>
                    </a>
                    <!-- Message -->
                    <a href="#">
                        <div class="btn btn-primary btn-circle"><i class="fa fa-user"></i></div>
                        <div class="mail-contnet">
                            <h6 class="text-dark font-medium mb-0">Pavan kumar</h6> <span class="mail-desc">Just see the my admin!</span> <span
                                class="time">9:02 AM</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- End Notification -->
        <!-- Start Feeds -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Feeds</h5>
                    <ul class="feeds">
                        <li>
                            <div class="bg-light-info"><i class="fa fa-bell-o"></i></div> You have 4 pending
                            tasks. <span class="text-muted">Just Now</span>
                        </li>
                        <li>
                            <div class="bg-light-success"><i class="fa fa-server"></i></div> Server #1
                            overloaded.<span class="text-muted">2 Hours ago</span>
                        </li>
                        <li>
                            <div class="bg-light-warning"><i class="fa fa-shopping-cart"></i></div> New
                            order received.<span class="text-muted">31 May</span>
                        </li>
                        <li>
                            <div class="bg-light-danger"><i class="fa fa-user"></i></div> New user
                            registered.<span class="text-muted">30 May</span>
                        </li>
                        <li>
                            <div class="bg-light-inverse"><i class="fa fa-bell-o"></i></div> New Version
                            just arrived. <span class="text-muted">27 May</span>
                        </li>
                        <li>
                            <div class="bg-light-info"><i class="fa fa-bell-o"></i></div> You have 4 pending
                            tasks. <span class="text-muted">Just Now</span>
                        </li>
                        <li>
                            <div class="bg-light-danger"><i class="fa fa-user"></i></div> New user
                            registered.<span class="text-muted">30 May</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Feeds -->
    </div> --}}
    <!-- ============================================================== -->
    <!-- End Notification And Feeds -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
</div>

@endsection
@section('custom-script')
<script type="text/javascript">

    const ketegori_pegawai = @json($ketegori_pegawai);
    const poin_pegawai_ps = @json($poin_pegawai_ps);
    const riwayat_pemeriksaan = @json($riwayat_pemeriksaan);
    const riwayat_pemeriksaan_jumlah = @json($riwayat_pemeriksaan_jumlah);

 var table = $('.yajra-datatable').DataTable({});
    // Data for the radar chart
    var radarData = {
            labels: ketegori_pegawai,
            datasets: [{
                label: 'Nilai',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                data: poin_pegawai_ps // Replace with the actual data for the person's skills
            }]
        };

        // Options for the radar chart
        var radarOptions = {
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
            type: 'radar',
            data: radarData,
            options: radarOptions
    });

        var barData = {
            labels: riwayat_pemeriksaan ,
            datasets: [{
                label: 'Jumlah',
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: riwayat_pemeriksaan_jumlah // Replace with your data values
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
