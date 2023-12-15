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
                            <label class="control-label">Pilih Jabatan</label>
                            <select class="form-control custom-select">
                                <option value="">Pilih Jabatan</option>
                                <option value="">Pemeriksa</option>
                                <option value="">Pranata Komputer</option>
                                <option value="">Analis Keuangan</option>
                                <option value="">Pemelihara sarana dan prasarana</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-2 d-flex" style="align-items: end">
                            <button type="submit" class="btn btn-success ">
                            Cari
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <h5 class="mt-5"> Rata Rata Kompetensi Pemeriksa</h5>
                        <table class="table table-bordered yajra-datatable mt-3">
                            <thead>
                                <tr>
                                    <th>Nama Satker</th>
                                    <th>Diklat</th>
                                    <th>Sertifikasi</th>
                                    <th>Kinerja</th>
                                    <th>SKP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr role="row">
                                    <td class="">BPK Perwakilan Provinsi DKI Jakarta</td>
                                    <td>94.2</td>
                                    <td>50.4</td>
                                    <td>80.4</td>
                                    <td>79.4</td>
                                </tr>
                                <tr role="row">
                                    <td class="">BPK Perwakilan Provinsi Kalimantan Timur</td>
                                    <td>84.2</td>
                                    <td>60.4</td>
                                    <td>70.4</td>
                                    <td>69.4</td>
                                </tr>
                                <tr role="row">
                                    <td class="">BPK Perwakilan Provinsi Nusa Tenggara Barat</td>
                                    <td>74.2</td>
                                    <td>60.3</td>
                                    <td>40.22</td>
                                    <td>75.4</td>
                                </tr>
                                <tr role="row">
                                    <td class="">BPK Perwakilan Provinsi Kalimantan Utara</td>
                                    <td>84.2</td>
                                    <td>54.4</td>
                                    <td>85.4</td>
                                    <td>26.4</td>
                                </tr>
                                <tr role="row">
                                    <td class="">BPK Perwakilan Provinsi Kepulauan Riau</td>
                                    <td>54.2</td>
                                    <td>60</td>
                                    <td>30.3</td>
                                    <td>49.2</td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <h5 class="mt-5"> Clustering</h5>
                        <canvas id="myChart" width="800" height="400"></canvas>
                    </div>
            </div>
        </div>
        <!-- Column -->
    </div>
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
 var table = $('.yajra-datatable').DataTable({});
   // Data scatter plot untuk masing-masing kategori
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
