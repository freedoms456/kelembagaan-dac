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
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Sales Chart and browser state-->
    <!-- ============================================================== -->
    <div>
        <!-- Column -->
        <div class="col-lg-12">
            <div class="card d-flex flex-row">
                <div class="card-body col-lg-3">
                        <div class=" mb-4">
                            <h5 class="card-title mb-0 align-self-center">Our Visitors</h5>
                            <div class="ms-auto">
                                <select class="form-select b-0">
                                    <option selected="">Today</option>
                                    <option value="1">Tomorrow</option>
                                </select>
                            </div>
                        </div>
                        <div id="visitor" style="height:260px; width:100%;"></div>
                        <ul class="list-inline mt-4 text-center font-12">
                            <li><i class="fa fa-circle text-purple"></i> Tablet</li>
                            <li><i class="fa fa-circle text-success"></i> Desktops</li>
                            <li><i class="fa fa-circle text-info"></i> Mobile</li>
                        </ul>
                    </div>
                    <div class="card-body col-lg-4">
                        <div class="d-flex no-block">
                            <div>
                                <h5 class="card-title mb-0">Sales Chart</h5>
                            </div>
                            <div class="ms-auto">
                                <ul class="list-inline text-center font-12">
                                    <li><i class="fa fa-circle text-success"></i> SITE A</li>
                                    <li><i class="fa fa-circle text-info"></i> SITE B</li>
                                    <li><i class="fa fa-circle text-primary"></i> SITE C</li>
                                </ul>
                            </div>
                        </div>
                        <div class="" id="sales-chart" style="height: 355px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-lg-12">
            <div class="card">
            <div class="card-body col-lg-4">
                        <div class="d-flex no-block">
                            <div>
                                <h5 class="card-title mb-0">Sales Chart</h5>
                            </div>
                            <div class="ms-auto">
                                <ul class="list-inline text-center font-12">
                                    <li><i class="fa fa-circle text-success"></i> SITE A</li>
                                    <li><i class="fa fa-circle text-info"></i> SITE B</li>
                                    <li><i class="fa fa-circle text-primary"></i> SITE C</li>
                                </ul>
                            </div>
                        </div>
                        <div class="" id="bar-satker" style="height: 355px;"></div>
                    </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Sales Chart -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Projects of the Month -->
    <!-- ============================================================== -->
   
    <!-- ============================================================== -->
    <!-- End Projects of the Month -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Notification And Feeds -->
    <!-- ============================================================== -->
    
    <!-- ============================================================== -->
    <!-- End Notification And Feeds -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
</div>

@endsection


<script type="text/javascript">
var barSatker = null;
var myChart = null;

$.ajax({
                method: 'GET',
                url: '/dashboard/kinerjaSatker',
                data: {
                    perwakilan: perwakilan,
                    skp: skp
                },
                success: function (data) {
                    let labels = data.map(item => item.nama);
                    let values = data.map(item => item.total);
                }
                var ctx = document.getElementById('bar-satker');

                    // If myChart exists, remove the previous chart
                    if (myChart !== null) {
                        myChart.destroy();
                    };

                    // Create the new chart
                    myChart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            indexAxis: 'y',
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });

</script>