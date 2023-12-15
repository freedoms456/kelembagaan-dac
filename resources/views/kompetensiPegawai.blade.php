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
                <li class="breadcrumb-item active">Dashboard Kompetensi Pegawai</li>
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
                        <div class="col-md-4  col-sm-12 ">
                            <label class="control-label">Jabatan</label>
                            <select class="form-control custom-select">
                                <option value="">Pilih Jabatan</option>
                                <option value="">Pranata Komputer</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-2 d-flex" style="align-items: end">
                            <button type="submit" class="btn btn-success ">
                            Cari
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="button-group mt-4">
                            <button type="button" class="
                                btn
                                waves-effect waves-light
                                btn-rounded btn-secondary
                              ">
                            Sistem Informasi
                            <button type="button" class="
                                btn
                                waves-effect waves-light
                                btn-rounded btn-secondary active
                              ">
                            Jaringan Keamanan Komputer
                            </button>
                            <button type="button" class="
                                btn
                                waves-effect waves-light
                                btn-rounded btn-secondary
                              ">
                           Infrasturktur TI
                            </button>
                            <button type="button" class="
                                btn
                                waves-effect waves-light
                                btn-rounded btn-secondary
                              ">
                             Kelola Data
                            </button>

                        </div>
                        <h5 class="mt-5"> Daftar Pegawai</h5>
                        <table class="table table-bordered yajra-datatable mt-3">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Perwakilan</th>
                                    <th>Poin Kompetensi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr role="row">
                                    <td class="">Rama</td>
                                    <td>Pranata Komputer Ahli Muda</td>
                                    <td>BPK Provinsi DKI Jakarta</td>
                                    <td>77.5</td>
                                    <td><span class="label label-success">view</span></td>
                                </tr>
                                <tr role="row">
                                    <td class="">Rano</td>
                                    <td>Pranata Komputer Ahli Pertama</td>
                                    <td>BPK Provinsi Kalimantan Utara</td>
                                    <td>77.4</td>
                                    <td><span class="label label-success">view</span></td>
                                </tr>
                                <tr role="row">
                                    <td class="">Ika</td>
                                    <td>Pranata Komputer Ahli Pertama</td>
                                    <td>BPK Provinsi Kalimantan Timur</td>
                                    <td>73.4</td>
                                    <td><span class="label label-success">view</span></td>
                                </tr>
                                <tr role="row">
                                    <td class="">Rendi</td>
                                    <td>Pranata Komputer Ahli Pertama</td>
                                    <td>BPK Provinsi Kalimantan Tengah</td>
                                    <td>72.4</td>
                                    <td><span class="label label-success">view</span></td>
                                </tr>
                                <tr role="row">
                                    <td class="">Sila</td>
                                    <td>Pranata Komputer Ahli Pertama</td>
                                    <td>BPK Provinsi Kalimantan Barat</td>
                                    <td>71.4</td>
                                    <td><span class="label label-success">view</span></td>
                                </tr>
                                <tr role="row">
                                    <td class="">Eka</td>
                                    <td>Pranata Komputer Ahli Pertama</td>
                                    <td>BPK Provinsi Kalimantan Selatan</td>
                                    <td>70.4</td>
                                    <td><span class="label label-success">view</span></td>
                                </tr>
                                <tr role="row">
                                    <td class="">Dendi</td>
                                    <td>Pranata Komputer Ahli Pertama</td>
                                    <td>BPK Provinsi Sumatra Barat</td>
                                    <td>69.4</td>
                                    <td><span class="label label-success">view</span></td>
                                </tr>
                                <tr role="row">
                                    <td class="">Dendik</td>
                                    <td>Pranata Komputer Ahli Pertama</td>
                                    <td>BPK Provinsi Sumatra Selatan</td>
                                    <td>68.4</td>
                                    <td><span class="label label-success">view</span></td>
                                </tr>

                            </tbody>
                        </table>
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

</script>
@endsection
