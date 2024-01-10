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
                        <h5 class="mt-5"> Daftar Pemeriksa BPK Kaltara</h5>
                        <table id="myTable" class="table table-bordered yajra-datatable mt-3">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Jumlah Pemeriksaan</th>
                                    <th>LK</th>
                                    <th>Kinerja</th>
                                    <th>PDTT</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
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
                    <div class="">
                        <div>
                            <h5 class="card-title">Profiling Berdasarkan Pencapaian</h5>
                            <div class="row">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-md-8">
                                        <label class="control-label">Pilih Kategori</label>
                                        <select id="kategori" class="form-control custom-select">
                                            <option value="General">General</option>
                                            <option value="Akuntansi">Akuntansi</option>
                                            <option value="Teknik Sipil">Teknik Sipil</option>
                                            <option value="Ketua Tim">PT</option>
                                            <option value="Hukum">Hukum</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" id="cari" class="btn btn-primary" style="margin-top: 25px;">Hitung</button>
                                        {{-- <button type="button" id="lihat" class="btn btn-primary" style="margin-top: 25px;">lihat</button> --}}
                                    </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                    <div class="table-responsive mt-3 no-wrap">
                        <table id="myTable2" class="table vm no-th-brd pro-of-month">
                            <thead>
                                <tr>
                                    <th>Nama Pegawai</th>
                                    <th>Poin Kompetensi Pemeriksa</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Column -->
        <!-- Column -->
    </div>

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

    var table2 = null;

});

function getDataTableSAW(){
                  if (table2 !== null) {
                         table2.destroy(); // Destroy the DataTable instance if it exists
                    }
                    table2 = $('#myTable2').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url : "/perhitunganSAW/get-tableresult",
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
                        {data: 'pegawai.name', name: 'pegawai.name'},
                        {data: 'diklat', name: 'diklat'},
                        {data: 'sertifikasi', name: 'sertifikasi'},
                        {data: 'kinerja', name: 'kinerja'},
                        {data: 'skp', name: 'skp'},
                        {data: 'total', name: 'total'}

                    ]
                    });
        }
function calculateSAW(){
            // console.log("test");
            $.ajax({
                url: '/pemeriksaSAW/calculate', // URL to your Laravel route
                method: 'POST',
                data : {
                    kategori : document.getElementById('kategori').value
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    // getDataTableSAW();
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
