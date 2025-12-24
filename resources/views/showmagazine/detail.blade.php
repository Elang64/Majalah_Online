@extends('templates.app')

@section('content')
<style>
    :root {
        --primary: #1B3C53;
        --secondary: #234C6A;
        --light: #F8F9FA;
        --gray: #6C757D;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
    }

    .magazine-detail {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* 3 Kolom: Cover | Info | Deskripsi */
    .magazine-grid {
        display: grid;
        grid-template-columns: 300px 1fr 1fr;
        gap: 2.5rem;
        margin-bottom: 3rem;
    }

    /* Cover kiri */
    .magazine-cover {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        height: fit-content;
    }

    .cover-image {
        width: 100%;
        /* height: 400px; */
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Info tengah */
    .magazine-info {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        height: fit-content;
    }

    .info-header h1 {
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 2.2rem;
    }

    /* Deskripsi kanan (card baru) */
    .magazine-description {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        height: fit-content;
    }

    .desc-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        color: var(--primary);
    }

    .desc-header i {
        margin-right: 10px;
        font-size: 1.3rem;
    }

    .desc-header h5 {
        margin: 0;
        font-weight: 700;
        font-size: 1.3rem;
    }

    .description-text {
        color: #444;
        line-height: 1.8;
        font-size: 1.05rem;
        padding: 1.2rem;
        background: var(--light);
        border-radius: 8px;
        border-left: 5px solid var(--secondary);
    }

    /* Badge & harga tetap sama */
    .badge { padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600; font-size: 0.9rem; display: inline-block; }
    .badge-success { background: rgba(40,167,69,0.1); color: var(--success); }
    .badge-warning { background: rgba(255,193,7,0.1); color: #856404; }
    .badge-danger { background: rgba(220,53,69,0.1); color: var(--danger); }

    .price-container { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin: 1rem 0; }
    .current-price { font-size: 2rem; font-weight: 700; color: var(--primary); }
    .original-price { color: var(--gray); text-decoration: line-through; font-size: 1.3rem; }

    /* Table info */
    .info-table td { padding: 0.8rem 0; vertical-align: top; }
    .info-table td:first-child { width: 140px; color: var(--gray); font-weight: 600; }
    .info-table td:nth-child(2) { width: 15px; text-align: center; color: #ccc; }

    /* Action buttons tetap */
    .action-buttons { position: fixed; bottom: 0; left: 0; right: 0; background: white; padding: 1.5rem; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); z-index: 100; }
    .action-container { max-width: 1400px; margin: 0 auto; display: flex; justify-content: center; gap: 1rem; }
    .btn-lg { padding: 1rem 2.5rem; font-size: 1.1rem; font-weight: 600; border-radius: 10px; transition: all 0.3s; }

    /* Responsif */
    @media (max-width: 1100px) {
        .magazine-grid { grid-template-columns: 280px 1fr 1fr; gap: 2rem; }
    }

    @media (max-width: 992px) {
        .magazine-grid {
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        .magazine-cover { grid-row: 1 / 2; }
        .magazine-info { grid-column: 1 / 3; }
        .magazine-description { grid-column: 1 / 3; }
    }

    @media (max-width: 768px) {
        .magazine-grid { grid-template-columns: 1fr; gap: 1.5rem; }
        .magazine-cover, .magazine-info, .magazine-description { max-width: 100%; }
        .cover-image { height: 350px; }
        .action-container { flex-direction: column; }
        .btn-lg { width: 100%; }
    }

    @media (max-width: 576px) {
        .info-table td { display: block; padding: 0.4rem 0; }
        .info-table td:nth-child(2) { display: none; }
        .cover-image { height: 280px; }
    }
</style>

<div class="magazine-detail">
    <div class="magazine-grid">
        <!-- Kiri: Cover -->
        <div class="magazine-cover">
            <img src="{{ asset('storage/' . $magazines->cover) }}"
                 alt="{{ $magazines->title }}"
                 class="cover-image">
        </div>

        <!-- Tengah: Informasi + Harga + Status -->
        <div class="magazine-info">
            <div class="info-header">
                <h1>{{ $magazines->title }}</h1>
            </div>

            <table class="info-table">
                <tr><td><b>Kategori</b></td><td>:</td><td>{{ $magazines->category }}</td></tr>
                <tr><td><b>Tahun Terbit</b></td><td>:</td><td>{{ $magazines->publication_year }}</td></tr>

                <tr>
                    <td><b>Promo</b></td><td>:</td>
                    <td>
                        @if ($magazines->promo)
                            <span class="badge badge-warning">{{ $magazines->promo->promo_code }}</span>
                        @else -
                        @endif
                    </td>
                </tr>

                <!-- Harga -->
                <tr>
                    <td><b>Harga</b></td><td>:</td>
                    <td>
                        @php
                            $discounted = $magazines->promo
                                ? ($magazines->promo->type == 'percent'
                                    ? $magazines->price - ($magazines->price * $magazines->promo->discount / 100)
                                    : $magazines->price - $magazines->promo->discount)
                                : $magazines->price;
                            $discounted = max(0, $discounted);
                        @endphp

                        <div class="price-container">
                            <span class="current-price">Rp{{ number_format($discounted, 0, ',', '.') }}</span>
                            @if($magazines->promo && $discounted < $magazines->price)
                                <span class="original-price">
                                    <s>Rp{{ number_format($magazines->price, 0, ',', '.') }}</s>
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>

                @if(auth()->check() && auth()->user()->role == 'user')
                    @php
                        $hasPurchased = \App\Models\Order::where('user_id', auth()->id())
                                        ->where('magazine_id', $magazines->id)->exists();
                    @endphp
                    <tr>
                        <td><b>Status Anda</b></td><td>:</td>
                        <td>
                            @if($hasPurchased)
                                <span class="badge badge-success"><i class="fas fa-check-circle me-1"></i> Sudah Dibeli</span>
                            @else
                                <span class="badge badge-warning"><i class="fas fa-shopping-cart me-1"></i> Belum Dibeli</span>
                            @endif
                        </td>
                    </tr>
                @endif

                <tr>
                    <td><b>Status</b></td><td>:</td>
                    <td>
                        <span class="badge {{ $magazines->actived ? 'badge-success' : 'badge-danger' }}">
                            {{ $magazines->actived ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Kanan: Deskripsi (card terpisah) -->
        <div class="magazine-description">
            <div class="desc-header">
                <i class="fas fa-file-alt"></i>
                <h5>Deskripsi Majalah</h5>
            </div>
            <div class="description-text">
                {!! nl2br(e($magazines->description)) !!}
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons dengan pengecekan role -->
<div class="action-buttons">
    <div class="action-container">
        @if(!auth()->check())
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-cart me-2"></i> BELI MAJALAH
            </a>

        @elseif(auth()->check() && auth()->user()->role == 'user')
            @if($hasPurchased ?? false)
                @if($magazines->file_path)
                    <a href="{{ asset('storage/' . $magazines->file_path) }}"
                       class="btn btn-success btn-lg"
                       download="{{ $magazines->title }}.pdf">
                        <i class="fas fa-download me-2"></i> Unduh Majalah
                    </a>
                @else
                    <button class="btn btn-success btn-lg" disabled>Sudah Dibeli</button>
                @endif
                <a href="{{ route('magazines.purchased') }}" class="btn btn-info btn-lg">
                    <i class="fas fa-book me-2"></i> Lihat Koleksi Saya
                </a>

            @else
                <a href="javascript:void(0)" onclick="createOrder()" id="btnOrder" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-cart me-2"></i> BELI MAJALAH
                </a>
            @endif

        @elseif(auth()->check() && auth()->user()->role == 'admin')
            <!-- Tombol untuk admin -->
            <a href="{{ route('magazines.edit', $magazines->id) }}" class="btn btn-warning btn-lg">
                <i class="fas fa-edit me-2"></i> Edit Majalah
            </a>
            <a href="{{ route('magazines.index') }}" class="btn btn-info btn-lg">
                <i class="fas fa-list me-2"></i> Kembali ke Daftar
            </a>

        @else
            <!-- Untuk role lainnya -->
            <button class="btn btn-secondary btn-lg" disabled>
                Anda tidak memiliki akses untuk membeli
            </button>
        @endif
    </div>
</div>

@if(auth()->check() && auth()->user()->role == 'user' && !($hasPurchased ?? false))
<input type="hidden" id="user_id" value="{{ auth()->id() }}">
<input type="hidden" id="magazine_id" value="{{ $magazines->id }}">
<input type="hidden" id="price" value="{{ $discounted }}">
@endif

@endsection

@if(auth()->check() && auth()->user()->role == 'user' && !($hasPurchased ?? false))
@push('script')
<script>
    function createOrder() {
        let data = {
            user_id: $("#user_id").val(),
            magazine_id: $("#magazine_id").val(),
            cart_id: null,
            quantity: 1,
            total_price: $("#price").val(),
            purchase_history: "Pembelian Majalah: {{ addslashes($magazines->title) }}",//menambhakan karakter backslash
            payment: "pending",
            _token: "{{ csrf_token() }}"
        };

        $.ajax({
            url: "/orders",
            method: "POST",
            data: data,
            success: function(response) {
                if(response.success && response.data) {
                    window.location.href = `/orders/${response.data.id}/payment`;
                } else {
                    alert('Gagal membuat pesanan!');
                }
            },
            error: function() {
                alert('Terjadi kesalahan! Silakan coba lagi.');
            }
        });
    }
</script>
@endpush
@endif
