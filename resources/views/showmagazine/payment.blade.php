@extends('templates.app')

@section('content')
<div class="card w-50 d-block mx-auto my-5 p-4">
    <div class="card-body">
        <h4 class="text-center mb-3">Selesaikan Pembayaran Majalah</h4>

        {{-- Detail pembelian --}}
        <table class="w-100">
            <tr>
                <td><b>Judul Majalah</b></td>
                <td class="text-end">{{ $order->magazine->title }}</td>
            </tr>

            {{-- Harga Asli (dicoret) --}}
            <tr>
                <td><b>Harga Asli</b></td>
                <td class="text-end">
                    <span style="text-decoration: line-through; color: #999;">
                        Rp {{ number_format($order->magazine->price, 0, ',', '.') }}
                    </span>
                </td>
            </tr>

            {{-- Tampilkan diskon jika harga order lebih murah dari harga asli --}}
            @if($order->total_price < $order->magazine->price)
            @php
                $diskon = $order->magazine->price - $order->total_price;
                $persen_diskon = ($diskon / $order->magazine->price) * 100;
            @endphp
            <tr>
                <td><b>Diskon</b></td>
                <td class="text-end text-success">
                    {{ number_format($persen_diskon, 0) }}%
                    (-Rp {{ number_format($diskon, 0, ',', '.') }})
                </td>
            </tr>
            @endif

            {{-- Harga Setelah Diskon --}}
            <tr>
                <td><b>Harga Setelah Diskon</b></td>
                <td class="text-end">
                    <b>Rp {{ number_format($order->total_price, 0, ',', '.') }}</b>
                </td>
            </tr>

            <tr>
                <td><b>Biaya Layanan</b></td>
                <td class="text-end">Rp 2.000</td>
            </tr>
        </table>

        <hr>

        {{-- Total Pembayaran --}}
        <div class="d-flex justify-content-end mb-3">
            @php
                $total_bayar = $order->total_price + 2000;
            @endphp
            <h5>Total Pembayaran: <b>Rp {{ number_format($total_bayar, 0, ',', '.') }}</b></h5>
        </div>

        {{-- Ringkasan --}}
        <div class="alert alert-info">
            <small>
                <b>Ringkasan:</b><br>
                • Harga majalah: Rp {{ number_format($order->magazine->price, 0, ',', '.') }}<br>
                • Diskon: Rp {{ number_format($diskon ?? 0, 0, ',', '.') }}<br>
                • Harga setelah diskon: Rp {{ number_format($order->total_price, 0, ',', '.') }}<br>
                • Biaya layanan: Rp 2.000<br>
                • <b>Total: Rp {{ number_format($total_bayar, 0, ',', '.') }}</b>
            </small>
        </div>

        <a href="{{ route('orders.paymentProof', $order->id) }}"
           class="btn btn-lg btn-block btn-primary">
            Sudah Dibayar
        </a>
    </div>
</div>
@endsection
