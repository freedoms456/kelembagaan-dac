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
        <div class="col-lg-12">
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
                        <div class="col-sm-12 col-md-2 d-flex" style="align-items: end">
                            <button type="submit" class="btn btn-success ">
                            Cari
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <h5 class="mt-5"> Daftar Pemeriksa</h5>
                        <table class="table table-bordered yajra-datatable mt-3">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Role Rekomendasi</th>
                                    <th>LK</th>
                                    <th>Kinerja</th>
                                    <th>PDTT</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr role="row">
                                    <td class="">Kurniawan</td>
                                    <td>Pemeriksa Ahli Muda</td>
                                    <td>Ketua Tim</td>
                                    <td>10</td>
                                    <td >9</td>
                                    <td>4</td>
                                    <td><span class="label label-success">view</span></td>
                                </tr>
                                <tr role="row">
                                    <td class="">Ronal Rano</td>
                                    <td>Pemeriksa Ahli Muda</td>
                                    <td>Ketua Tim</td>
                                    <td>8</td>
                                    <td >3</td>
                                    <td>2</td>
                                    <td><span class="label label-success">view</span></td>
                                </tr>
                                <tr role="row">
                                    <td class="">Renaldi raya</td>
                                    <td>Pemeriksa Ahli Muda</td>
                                    <td>Ketua Tim</td>
                                    <td>15</td>
                                    <td >10</td>
                                    <td>5</td>
                                    <td><span class="label label-success">view</span></td>
                                </tr>
                                <tr role="row">
                                    <td class="">Dini Rahma</td>
                                    <td>Pemeriksa Ahli Pertama</td>
                                    <td>Anggota Tim</td>
                                    <td>5</td>
                                    <td >9</td>
                                    <td>2</td>
                                    <td><span class="label label-success">view</span></td>
                                </tr>
                                <tr role="row">
                                    <td class="">Agus Ageng</td>
                                    <td>Pemeriksa Ahli Pertama</td>
                                    <td>Anggota Tim</td>
                                    <td>1</td>
                                    <td >2</td>
                                    <td>2</td>
                                    <td><span class="label label-success">view</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
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
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5 class="card-title">Profiling Berdasarkan Pencapaian</h5>
                            <div class="row">
                                <div class="card-body">
                                    <div class="button-group">
                                        <button type="button" class="
                                            btn
                                            waves-effect waves-light
                                            btn-rounded btn-secondary
                                          ">
                                         Pengendali Teknis
                                        <button type="button" class="
                                            btn
                                            waves-effect waves-light
                                            btn-rounded btn-secondary active
                                          ">
                                          Ketua Tim
                                        </button>
                                        <button type="button" class="
                                            btn
                                            waves-effect waves-light
                                            btn-rounded btn-secondary
                                          ">
                                         Infrasturktur
                                        </button>
                                        <button type="button" class="
                                            btn
                                            waves-effect waves-light
                                            btn-rounded btn-secondary
                                          ">
                                         LK Kas
                                        </button>

                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                    <div class="table-responsive mt-3 no-wrap">
                        <table class="table vm no-th-brd pro-of-month">
                            <thead>
                                <tr>
                                    <th>Nama Pegawai</th>
                                    <th>Nama Perwakilan</th>
                                    <th>Poin Kompetensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                       Renaldi Raya
                                    </td>
                                    <td>Kalimantan Utara</td>
                                    <td>64.54</td>
                                </tr>
                                <tr>
                                    <td>
                                       Kurniawan
                                    </td>
                                    <td>Kalimantan Utara</td>
                                    <td>54.23</td>
                                </tr>
                                <tr>
                                    <td>
                                       Ronal Rano
                                    </td>
                                    <td>Kalimantan Utara</td>
                                    <td>44.32</td>
                                </tr>
                            </tbody>
                        </table>
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
 var table = $('.yajra-datatable').DataTable({});

</script>
@endsection
