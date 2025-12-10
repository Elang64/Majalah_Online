@extends('templates.app')

@section('content')
    <div class="container">
        <div class="card w-70 d-block mx-auto text-center mt-4 p-4">
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    {{-- <a href="{{ route('orders.export-pdf', $order->id) }}" class="btn btn-secondary">
                    Unduh Bukti PDF
                </a> --}}
                </div>

                <div class="text-center mb-4">
                    <h4 class="text-success">
                        <i class="fas fa-check-circle"></i> Pembayaran Berhasil
                    </h4>
                    <p class="text-muted">Terima kasih telah melakukan pembayaran untuk majalah</p>
                </div>

                <div class="border rounded p-4 mb-4">
                    {{-- Info Pembelian --}}
                    <div class="row mb-3">
                        <div class="col-md-6 text-start">
                            <h5>Detail Pembelian</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><b>No. Order</b></td>
                                    <td>: {{ $order->order_number ?? 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Tanggal Pembelian</b></td>
                                    <td>: {{ \Carbon\Carbon::parse($order->created_at)->format('d F Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><b>Status Pembayaran</b></td>
                                    <td>
                                        : <span class="badge bg-success">Lunas</span>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6 text-start">
                            <h5>Detail Majalah</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><b>Judul</b></td>
                                    <td>: {{ $order->magazine->title }}</td>
                                </tr>
                                <tr>
                                    <td><b>Kategori</b></td>
                                    <td>: {{ $order->magazine->category }}</td>
                                </tr>
                                <tr>
                                    <td><b>Tahun Terbit</b></td>
                                    <td>: {{ $order->magazine->publication_year }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Ringkasan Pembayaran --}}
                    <div class="border-top pt-3">
                        <h5 class="text-start">Ringkasan Pembayaran</h5>
                        <table class="table">
                            <tr>
                                <td class="text-start">Harga Majalah</td>
                                <td class="text-end">Rp {{ number_format($order->magazine->price, 0, ',', '.') }}</td>
                            </tr>

                            @if ($order->total_price < $order->magazine->price)
                                @php
                                    $diskon = $order->magazine->price - $order->total_price;
                                @endphp
                                <tr>
                                    <td class="text-start text-success">Diskon</td>
                                    <td class="text-end text-success">-Rp {{ number_format($diskon, 0, ',', '.') }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td class="text-start">Harga Setelah Diskon</td>
                                <td class="text-end">
                                    <b>Rp {{ number_format($order->total_price, 0, ',', '.') }}</b>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-start">Biaya Layanan</td>
                                <td class="text-end">Rp 2.000</td>
                            </tr>

                            <tr class="table-active">
                                @php
                                    $total_bayar = $order->total_price + 2000;
                                @endphp
                                <td class="text-start"><b>Total Pembayaran</b></td>
                                <td class="text-end"><b>Rp {{ number_format($total_bayar, 0, ',', '.') }}</b></td>
                            </tr>
                        </table>
                    </div>

                    {{-- QR Code untuk majalah digital (opsional) --}}
                    @if ($order->magazine->digital_url)
                        <div class="text-center mt-4 border-top pt-3">
                            <h6>Akses Majalah Digital</h6>
                            <div class="mb-3">
                                <a href="{{ $order->magazine->digital_url }}" target="_blank"
                                    class="btn btn-outline-primary">
                                    <i class="fas fa-book-open"></i> Baca Majalah Online
                                </a>
                            </div>
                            <div>
                                {{-- Generate QR Code untuk link majalah --}}
                                <div class="d-inline-block p-2 border rounded">
                                    {!! QrCode::size(100)->generate($order->magazine->digital_url) !!}
                                </div>
                                <p class="text-muted small mt-2">Scan QR Code untuk mengakses majalah</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Tombol aksi --}}
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-home"></i> Kembali ke Beranda
                    </a>
                    <a href="{{ route('magazines.detail', $order->magazine_id) }}" class="btn btn-primary">
                        <i class="fas fa-book"></i> Lihat Majalah Lainnya
                    </a>
                    @if ($order->magazine->file_path)
                        <a href="{{ asset('storage/' . $order->magazine->file_path) }}" class="btn btn-success"
                            download="{{ $order->magazine->title }}.pdf">
                            <i class="fas fa-download"></i> Unduh Majalah
                        </a>
                    @endif
                </div>

                {{-- Informasi tambahan --}}
                <div class="alert alert-info mt-4 text-start">
                    <small>
                        <i class="fas fa-info-circle"></i>
                        <b>Informasi:</b><br>
                        1. Bukti pembayaran ini dapat digunakan sebagai tanda bukti pembelian.<br>
                        2. Simpan bukti pembayaran untuk keperluan pengaduan atau komplain.<br>
                        3. Majalah akan dikirimkan ke email: <b>{{ auth()->user()->email }}</b> dalam 1x24 jam.<br>
                        4. Untuk bantuan, hubungi customer service di 1500-123.
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .ticket-body {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }

        .ticket-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }

        .ticket-details small {
            font-weight: bold;
            color: #666;
            min-width: 80px;
            display: inline-block;
        }
    </style>
@endpush
