@extends('layout.main')


@section('container')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Pembentukan Tim Kaltara</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Pembentukan Tim</li>
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
    {{-- <div class="row">
        <!-- Column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label">Jenis Tim</label>
                        <select class="form-control custom-select">
                            <option value="">Minimalisir Resiko</option>
                            <option value="">Memberi pengalaman</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label">Jenis Pemeriksaan</label>
                        <select class="form-control custom-select">
                            <option value="">LK</option>
                            <option value="">Kinerja</option>
                            <option value="">PDTT</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div> --}}
    <!-- ============================================================== -->
    <!-- End Sales Chart -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Projects of the Month -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5 class="card-title">Provinsi</h5>
                            {{-- <div class="col-md-12 col-sm-12">
                                <label class="control-label">Jenis Tim</label>
                                <select class="form-control custom-select">
                                    <option value="LK">LK</option>
                                    <option value="">Kinerja</option>
                                    <option value="">PDTT</option>
                                </select>
                            </div> --}}
                        </div>
                    </div>
                    {{-- <div class="table-responsive mt-3 no-wrap"> --}}
                        {{-- <table class="table vm no-th-brd pro-of-month">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Peran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                      Benny
                                    </td>
                                    <td>Pengendali Teknis</td>
                                </tr>
                                <tr>
                                    <td>
                                      Kurniawan
                                    </td>
                                    <td>Ketua Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Ronal
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Rina
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Eka Setya
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Reno
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>


                            </tbody>
                        </table> --}}
                        <div id="provinsi"></div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5 class="card-title">Kota Tarakan</h5>
                        </div>
                    </div>
                    {{-- <div class="table-responsive mt-3 no-wrap">
                        <table class="table vm no-th-brd pro-of-month">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Peran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                      Tedi
                                    </td>
                                    <td>Pengendali Teknis</td>
                                </tr>
                                <tr>
                                    <td>
                                      Rendi Rahmat
                                    </td>
                                    <td>Ketua Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Ramadhan
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Santi
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Eki
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Rahmawati
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>


                            </tbody>
                        </table>
                    </div> --}}
                    <div id="tarakan"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5 class="card-title">Malinau</h5>
                        </div>
                    </div>
                    {{-- <div class="table-responsive mt-3 no-wrap">
                        <table class="table vm no-th-brd pro-of-month">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Peran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                      Tedi
                                    </td>
                                    <td>Pengendali Teknis</td>
                                </tr>
                                <tr>
                                    <td>
                                      Rendi Rahmat
                                    </td>
                                    <td>Ketua Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Ramadhan
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Santi
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Eki
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Rahmawati
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>


                            </tbody>
                        </table>
                    </div> --}}
                    <div id="malinau"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5 class="card-title">Nunukan</h5>
                        </div>
                    </div>
                    {{-- <div class="table-responsive mt-3 no-wrap">
                        <table class="table vm no-th-brd pro-of-month">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Peran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                      Tedi
                                    </td>
                                    <td>Pengendali Teknis</td>
                                </tr>
                                <tr>
                                    <td>
                                      Rendi Rahmat
                                    </td>
                                    <td>Ketua Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Ramadhan
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Santi
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Eki
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Rahmawati
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>


                            </tbody>
                        </table>
                    </div> --}}
                    <div id="nunukan"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5 class="card-title">Bulungan</h5>
                        </div>
                    </div>
                    {{-- <div class="table-responsive mt-3 no-wrap">
                        <table class="table vm no-th-brd pro-of-month">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Peran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                      Tedi
                                    </td>
                                    <td>Pengendali Teknis</td>
                                </tr>
                                <tr>
                                    <td>
                                      Rendi Rahmat
                                    </td>
                                    <td>Ketua Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Ramadhan
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Santi
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Eki
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Rahmawati
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>


                            </tbody>
                        </table>
                    </div> --}}
                    <div id="bulungan"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5 class="card-title">KTT</h5>
                        </div>
                    </div>
                    {{-- <div class="table-responsive mt-3 no-wrap">
                        <table class="table vm no-th-brd pro-of-month">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Peran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                      Tedi
                                    </td>
                                    <td>Pengendali Teknis</td>
                                </tr>
                                <tr>
                                    <td>
                                      Rendi Rahmat
                                    </td>
                                    <td>Ketua Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Ramadhan
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Santi
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Eki
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>
                                <tr>
                                    <td>
                                      Rahmawati
                                    </td>
                                    <td>Anggota Tim</td>
                                </tr>


                            </tbody>
                        </table>
                    </div> --}}
                    <div id="ktt"></div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-12 col-md-2 d-flex" style="align-items: end">
                    <button id="cari" type="submit" class="btn btn-success ">
                      Bentuk
                    </button>
                </div>
            </div>
        </div>

    </div>
    <!-- ============================================================== -->
    <!-- End Projects of the Month -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Notification And Feeds -->
    <!-- ============================================================== -->

</div>

@endsection


@section('custom-script')
<script type="text/javascript">

$( document ).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })

    getDataTable();

    $("#cari").click(function (e) {

    // getDataTable();
        calculateSAW();
    });



});
var table2 = null;

    function calculateSAW(){
            // console.log("test");
            $.ajax({
                url: '/bentuktim/create', // URL to your Laravel route
                method: 'POST',
                data : {
                    // kategori : document.getElementById('kategori').value
                    kategori : "test"
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // console.log(response);
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        }

 function getDataTable(){

        var table = $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
                ajax: {
                    url : "/pemeriksaKegiatan/get-datatableHistori",
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    },
                    data : function(d) {
                        // d.jabatan = document.getElementById('jabatan').value,
                        // d.kategori = document.getElementById('kategori').value
                    },
                },
                columns: [

                    {data: 'pegawai.name', name: 'pegawai.name'},
                    {data: 'pegawai.name', name: 'pegawai.name'},
                    {data: 'count_jenis_pemeriksaan', name: 'count_jenis_pemeriksaan'},
                    {data: 'count_LK', name: 'count_LK'},
                    {data: 'count_Kinerja', name: 'count_Kinerja'},
                    {data: 'count_PDTT', name: 'count_PDTT'},
                    {data: 'action', name: 'action'},


                ]
                });
    }

</script>
@endsection

