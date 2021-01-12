@extends('backend.layouts.master')
@section('title', 'Ana Sayfa')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Bekleyen Sipariş
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ ceil($statistics['waiting_order']*100/$statistics['total_order']).'%' }}</div>
                                   </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ ceil($statistics['waiting_order']*100/$statistics['total_order']).'%' }}" aria-valuenow="50" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mt-2 text-gray-500">{{ $statistics['waiting_order'] }} adet bekleyen sipariş var</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tamamlanan Sipariş
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ ceil($statistics['completed_order']*100/$statistics['total_order']).'%' }}</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ ceil($statistics['completed_order']*100/$statistics['total_order']).'%' }}" aria-valuenow="50" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mt-2 text-gray-500">{{ $statistics['completed_order'] }} adet tamamlanan sipariş var</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Toplam Ürün</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['total_product'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Toplam Kullanıcı</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['total_user'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Satışlar</h1>
    </div>

    <div class="row" style="height:500px!important;">
        <div class="col-md-6" style="height:100%;">
            <canvas id="best_seller" height="100%"></canvas>
        </div>
        <div class="col-md-6" style="height:100%;">
            <canvas id="month_seller" height="100%"></canvas>
        </div>
    </div>

</div>
@endsection
@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script>
        @php
            $labels = "";
            $data = "";
            foreach($best_seller as $report) {
                $labels .= "\"$report->product_name\", ";
                $data .= "$report->piece, ";
            }
        @endphp
        var ctx = document.getElementById('best_seller').getContext('2d');
        var best_seller = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [{!! $labels !!}],
                datasets: [{
                    label: 'En Çok Satışlar',
                    data: [{!! $data !!}],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{ ticks: { beginAtZero: true } }]
                }
            }
        });

        @php
            $labels = "";
            $data = "";
            foreach($month_seller as $report) {
                $labels .= "\"$report->month\", ";
                $data .= "$report->piece, ";
            }
        @endphp
        var ctx = document.getElementById('month_seller').getContext('2d');
        var month_seller = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [{!! $labels !!}],
                datasets: [{
                    label: 'Aylara Göre Satışlar',
                    data: [{!! $data !!}],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{ ticks: { beginAtZero: true } }]
                }
            }
        });
    </script>
@endsection