@extends('layout.main')


@section('container')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Dashboard</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
        <div class="col-md-7 align-self-center">
            {{-- <a href="https://www.wrappixel.com/templates/adminwrap/"
                class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down text-white"> Upgrade to
                Pro</a> --}}
        </div>
    </div>

    <div class="row">
         <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 no-block">
                        <h5 class="card-title mb-0 align-self-center">Jumlah Diklat</h5>
                    </div>
                    <div id="jumlah_diklat" style="height:240px; width:100%;"></div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 no-block">
                        <h5 class="card-title mb-0 align-self-center">Jumlah Sertifikasi</h5>
                    </div>
                    <div id="jumlah_sertifikasi" style="height:240px; width:100%;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="card income-o-year">
                <div class="card-body">
                <div class="d-flex m-b-30 no-block">
                    <h5 class="card-title m-b-0 align-self-center">
                        Kinerja Satker
                    </h5>
                </div>
                <div
                    id="kinerja-satker"
                ></div>
                </div>
            </div>
        </div>
    </div>
    
</div>

@endsection


@section('custom-script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    
    
    $(function() {
        "use strict";       

        kinerjaSatker();
    });

    function kinerjaSatker(){
            // console.log("test");
            $.ajax({
                url: '/perhitungan/dashboard/kinerja-satker', // URL to your Laravel route
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                  
                    data = JSON.parse(data);                   
                    generatechart1(data);
                    generatechart2(data);
                    generatechart3(data);
                    
                    
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });


    }

    function generatechart1(data) {
        const barpersatker_satker = data.barpersatker.satker;
        const barpersatker_total = data.barpersatker.total;

        var options = {
            series: [{
            data: barpersatker_total
            }],
            chart: {
            height: 350,
            type: 'bar',
            events: {
                click: function(chart, w, e) {
                // console.log(chart, w, e)
                }
            }
            },
            plotOptions: {
            bar: {
                columnWidth: '45%',
                distributed: true,
            }
            },
            dataLabels: {
            enabled: false
            },
            legend: {
            show: false
            },
            xaxis: {
            categories: barpersatker_satker,
            labels: {
                style: {
                fontSize: '12px'
                }
            }
            }
        };

        var chart = new ApexCharts(document.querySelector("#kinerja-satker"), options);
        chart.render();
        
    }   

    function generatechart2(data) {
        const sertifikasi_per_satker_satker = data.sertifikasi_per_satker.satker;
        const sertifikasi_per_satker_total = data.sertifikasi_per_satker.total.map(Number);
        
        var options = {        
        series: sertifikasi_per_satker_total,
         labels: sertifikasi_per_satker_satker,
          chart: {
          type: 'pie',
        },
        dataLabels: {
            enabled: true,
            formatter: function (val, opts) {
      return opts.w.globals.series[opts.seriesIndex];
    },
        },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#jumlah_sertifikasi"), options);
        chart.render();
        
    }

    function generatechart3(data) {
        const sertifikasi_per_satker_satker = data.diklat_per_satker.satker;
        const sertifikasi_per_satker_total = data.diklat_per_satker.total.map(Number);
        
        var options = {        
        series: sertifikasi_per_satker_total,
        labels: sertifikasi_per_satker_satker,
          chart: {
          type: 'donut',
        },
        dataLabels: {
        enabled: true,
        formatter: function (val, opts) {
      return opts.w.globals.series[opts.seriesIndex];
    },
  },
        tooltip: {
            y: {
            formatter: function (val) {
                return val;
            }
            }
        },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#jumlah_diklat"), options);
        chart.render();
        
    }
</script>

@endsection
