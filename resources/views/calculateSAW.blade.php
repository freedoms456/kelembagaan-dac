@extends('layout.main')


@section('container')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Hitung SAW</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Hitung SAW</li>
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
                        <label class="control-label">Pilih Kategori</label>
                        <select id="kategori" class="form-control custom-select">
                            <option value="all">Semua</option>
                            @foreach($kategori as $kategoris)
                            <option value="{{$kategoris->id }}_{{$kategoris->name}}">{{$kategoris->name}}</option>
                            @endforeach


                        </select>
                    </div>

                    <div class="col-3">
                        <button type="button" id="cari" class="btn btn-primary" style="margin-top: 25px;">Hitung</button>
                        {{-- <button type="button" id="lihat" class="btn btn-primary" style="margin-top: 25px;">lihat</button> --}}
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <label class="control-label">Hasil SAW</label>
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pegawai</th>
                                        <th>Poin Diklat</th>
                                        <th>Poin Sertifikasi</th>
                                        <th>Poin Kinerja</th>
                                        <th>Poin SKP</th>
                                        <th>Poin Kompetensi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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
<script type="text/javascript">
//  var table = $('#myTable').DataTable({});
 var myChart = null;
 var table = null;
 var table2 = null;
var pieSatker = null;
    $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })


            $("#cari").click(function (e) {

                // getDataTable();
                calculateSAW();
            });
            $("#lihat").click(function (e) {

            // getDataTable();
            getDataTable();
            });

    });


        function calculateSAW(){
            // console.log("test");
            $.ajax({
                url: '/perhitunganSAW/calculate', // URL to your Laravel route
                method: 'POST',
                data : {
                    kategori : document.getElementById('kategori').value
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    getDataTable();
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
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
                        url : "/perhitunganSAWS/get-datatable",
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


</script>
@endsection
