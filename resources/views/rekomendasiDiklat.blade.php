@extends('layout.main')


@section('container')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Rekomendasi Diklat</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Rekomendasi Diklat</li>
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
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label">Nama Pegawai</label>
                        <select id="pegawai" class="form-control custom-select">
                            @foreach($pegawai as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach

                          </select>
                    </div>
                    <div class="col-sm-12 col-md-2 d-flex" style="align-items: end">
                        <button id="cari" type="submit" class="btn btn-success ">
                          Cari Rekomendasi
                        </button>
                    </div>
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
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5 class="card-title nama-pegawai">Syahri Ramadhani</h5>
                        </div>
                    </div>
                    <div class="table-responsive mt-3 no-wrap">
                        <table id="myTable" class="table vm no-th-brd pro-of-month">
                            <thead>
                                <tr>
                                    <th>Nama Diklat</th>
                                    <th>JP</th>
                                    <th>Detail Diklat</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card card-body mailbox">
                <h5 class="card-title jabatan-pegawai">jabatan</h5>
                <div class="message-center" style="height: 420px !important;">
                    <!-- Message -->
                    <div id="dataDisplay"></div>
                    <!-- Message -->
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
    </div>


@endsection


@section('custom-script')
<script type="text/javascript">

    $(document).ready(function() {

        $('.custom-select').select2();

        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })


                $("#cari").click(function (e) {

                    dataPegawai();
                });

    });

     var table = null;

        function getDataTable(datas){
            if (table !== null) {
                table.destroy(); // Destroy the DataTable instance if it exists
                    }
                    table = $('#myTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url : "/rekomendasidiklat/get-datatable",
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                        },
                        data : function(d) {
                            d.pegawai = document.getElementById('pegawai').value
                            d.data = datas

                        },



                    },
                    columns: [
                        {data: 'diklat_name', name: 'diklat_name'},
                        {data: 'diklat_jp', name: 'diklat_jp'},
                        {data: 'diklat_detail', name: 'diklat_detail'},


                    ]
                    });
        }

        function dataPegawai(){
            // console.log("test");
            let displayContainer = document.getElementById('dataDisplay');
            $.ajax({
                url: '/rekomendasidiklat/getPegawai', // URL to your Laravel route
                method: 'POST',
                data : {
                    pegawai : document.getElementById('pegawai').value
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $(displayContainer).html('');
                    $('.jabatan-pegawai').html(response[0].pegawai.jabatan)
                    $('.nama-pegawai').html(response[0].pegawai.name)

                    response.forEach(item => {
                        // Create elements for each category and avg_total
                        let categorya = document.createElement('a');
                        let categoryDiv = document.createElement('div');
                        categoryDiv.classList.add('mail-contnet');

                        let categoryName = document.createElement('h6');
                        categoryName.classList.add('text-dark', 'font-medium', 'mb-0','mt-2');
                        categoryName.textContent = item.kategori.name;

                        let total = document.createElement('div');
                        total.classList.add('mail-desc');
                        total.textContent = `Poin Kompentensi: ${item.total}`;

                        let avgTotal = document.createElement('div');
                        avgTotal.classList.add('mail-desc');
                        avgTotal.textContent = `Rata-rata: ${item.avg_total}`;

                        // Append elements to the container
                        categoryDiv.appendChild(categoryName);
                        categoryDiv.appendChild(avgTotal);
                        categoryDiv.appendChild(total);
                        displayContainer.appendChild(categoryDiv);
                        categoryDiv.appendChild(categorya);
                    });
                    getDataTable(response);
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        }



    </script>
@endsection
