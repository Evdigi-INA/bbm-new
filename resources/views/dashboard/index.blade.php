@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div id="content" class="content">
        {{ Breadcrumbs::render('dashboard') }}
        {{-- <center style="margin: 50px">
            <img style="width:80%" src="{{ asset('vendor/assets/img/logo/logo.png') }}" alt="">
            <h1>Halaman Dashboard</h1>
        </center> --}}

        {{-- @dump($total_penjualan)
        @dump($total_pembelian)

        @dump($total_cek_giro_cair)
        @dump($total_cek_giro_tolak) --}}
        <h2 style="margin-bottom: 1em;">Dashboard Tahun {{ date('Y') }}</h2>

        <div class="row">

            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Total Penjualan</h3>
                    </div>
                    <div class="panel-body">
                        <h3 style="margin: 0;">
                            {{ $total_penjualan }}
                            <span style="font-size: 15px;">Penjualan</span>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Total Pembelian</h3>
                    </div>
                    <div class="panel-body">
                        <h3 style="margin: 0;">
                            {{ $total_pembelian }}
                            <span style="font-size: 15px;">Pembelian</span>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Total Cek/Giro Cair</h3>
                    </div>
                    <div class="panel-body">
                        <h3 style="margin: 0;">
                            {{ $total_cek_giro_cair }}
                            <span style="font-size: 15px;">Cek/Giro</span>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">Total Cek/Giro Tolak</h3>
                    </div>
                    <div class="panel-body">
                        <h3 style="margin: 0;">
                            {{ $total_cek_giro_tolak }}
                            <span style="font-size: 15px;">Cek/Giro</span>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h5 class="text-center">Penjualan & Pembelian Perbulan</h5>
                                <div style="height: 239px; width: 100%">
                                    <canvas id="sales_chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h5 class="text-center">Penjualan Triwulan</h5>
                                <div style="height: 239px; width: 100%">
                                    <canvas id="triwulan_chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h5 class="text-center">Top 5 Barang Paling Laris</h5>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Gambar</th>
                                    <th>Barang</th>
                                    <th>Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($barang_paling_laku as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset('storage/img/barang/' . $item->barang->gambar) }}"
                                                alt="gambar" class="img-fluid rounded"
                                                style="width: 80px; height: 80px; object-fit: cover; border-radius: 3px;">
                                        </td>
                                        <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}</td>
                                        <td>{{ $item->sum_qty }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Barang tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"
        integrity="sha512-GMGzUEevhWh8Tc/njS0bDpwgxdCJLQBWG3Z2Ct+JGOpVnEmjvNx6ts4v6A2XJf1HOrtOsfhv3hBKpK9kE5z8AQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const triwulan1 = {{ $triwulan1 }}
        const triwulan2 = {{ $triwulan2 }}
        const triwulan3 = {{ $triwulan3 }}
        const triwulan4 = {{ $triwulan4 }}

        const penjualan_per_bulan = {{ $penjualan_per_bulan }}
        const pembelian_per_bulan = {{ $pembelian_per_bulan }}

        const ctx1 = document.getElementById('triwulan_chart');
        const triwulan_chart = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: ['Triwulan I', 'Triwulan II', 'Triwulan III', 'Triwulan IV'],
                datasets: [{
                    label: 'Penjualan Triwulan',
                    data: [triwulan1, triwulan2, triwulan3, triwulan4],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx2 = document.getElementById('sales_chart');
        const sales_chart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Penjualan',
                    data: penjualan_per_bulan,
                    fill: true,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }, {
                    label: 'Pembelian',
                    data: pembelian_per_bulan,
                    fill: true,
                    backgroundColor: 'rgba(252, 0, 130, 0.2)',
                    borderColor: ' rgba(252, 0, 130, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
