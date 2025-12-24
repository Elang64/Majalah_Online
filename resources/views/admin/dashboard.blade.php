@extends('templates.app')

@section('content')
    <div class="container">
        <!-- Welcome Card -->
        <div class="page-header container mt-5">
            <h1>Dashboard Admin</h1>
            @if (Session::get('success'))
                <div class="alert alert-success">Selamat Datang, <b>{{ Auth::user()->name }}</b></div>
            @endif
        </div>

        <div class="card">
            <div class="container p-3 text-center">
                <h6>Majalah yang Aktif dan Non-Aktif</h6>

                <div class="d-flex justify-content-center align-items-center">
                    <div class="chart-wrapper">
                        <canvas id="chartPie"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('script')
        <script>
            $(function() {

                $.ajax({
                    url: "{{ route('admin.magazines.chart') }}",
                    method: "GET",
                    success: function(response) {
                        showChartPie(response.data);
                    },
                    error: function() {
                        alert('Gagal mengambil data chart!');
                    }
                });

                function showChartPie(dataPie) {
                    const canvas = document.getElementById('chartPie');

                    if (!canvas) {
                        console.error('Canvas chartPie tidak ditemukan');
                        return;
                    }

                    const ctx = canvas.getContext('2d');

                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['Aktif', 'Non-Aktif'],
                            datasets: [{
                                data: dataPie,
                                backgroundColor: [
                                    '#2c5f7d',
                                    '#e67e22'
                                ]
                            }]
                        }
                    });
                }
            });
        </script>
    @endpush
