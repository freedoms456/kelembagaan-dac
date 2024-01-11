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
                        <div class="col-md-3  col-sm-12 ">
                            <label class="control-label">Perwakilan</label>
                            <select id="perwakilan" class="form-control custom-select">
                            
                            </select>
                        </div>
                        <div class="col-md-3  col-sm-12 ">
                            <label class="control-label">Jabatan</label>
                            <select id="jabatan" class="form-control custom-select">
                                <option value="all">Semua Jabatan</option>
                                {{-- <option value="all">Semua Perwakilan</option> --}}
                                @foreach($jabatan as $data)
                                <option value="{{$data->jabatan}}">{{$data->jabatan}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3  col-sm-12 ">
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
                        {{-- <div class="button-group mt-4">
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

                        </div> --}}
                        <h5 class="mt-5"> Daftar Pegawai</h5>
                        <table id="myTable" class="table table-bordered yajra-datatable mt-3">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Perwakilan</th>
                                    <th>Poin Kompetensi</th>
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
    <!-- End Notification And Feeds -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
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
                    getDataTable();
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
                            url : "/perhitunganSAWS/get-datatable",
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                            },
                            data : function(d) {
                                d.kategori = document.getElementById('kategori').value
                                d.perwakilan = document.getElementById('perwakilan').value
                                d.jabatan = document.getElementById('jabatan').value
                            },



                        },
                        columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                            {data: 'pegawai.name', name: 'pegawai.name'},
                            {data: 'pegawai.jabatan', name: 'pegawai.jabatan'},
                            {data: 'pegawai.satuan_kerja', name: 'pegawai.satuan_kerja'},
                            {data: 'total', name: 'total'},
                            {data: 'action', name: 'action'}

                        ]
                        });
            }

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


    </script>
@endsection
