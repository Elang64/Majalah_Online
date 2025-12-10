@extends('templates.app')

@section('content')
    <div class="container pt-5">
        <div class="w-75 d-block m-auto">

            {{-- Cover + Title --}}
            <div class="d-flex">
                <div style="width:150px;height:200px">
                    <img src="{{ asset('storage/' . $magazines->cover) }}" alt="" class="w-100">
                </div>

                <div class="ms-5 mt-4">
                    <h4>{{ $magazines->title }}</h4>

                    <table>
                        <tr>
                            <td><b class="text-secondary">Kategori</b></td>
                            <td class="px-3"></td>
                            <td>{{ $magazines->category }}</td>
                        </tr>

                        <tr>
                            <td><b class="text-secondary">Tahun Terbit</b></td>
                            <td class="px-3"></td>
                            <td>{{ $magazines->publication_year }}</td>
                        </tr>

                        <tr>
                            <td><b class="text-secondary">Promo</b></td>
                            <td class="px-3"></td>
                            <td>
                                @if ($magazines->promo)
                                    {{ $magazines->promo->promo_code }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>

                        {{-- Harga Setelah Promo --}}
                        <tr>
                            <td><b class="text-secondary">Harga</b></td>
                            <td class="px-3"></td>
                            <td>
                                @php
                                    if ($magazines->promo) {
                                        if ($magazines->promo->type == 'percent') {
                                            $discounted =
                                                $magazines->price -
                                                ($magazines->price * $magazines->promo->discount) / 100;
                                        } else {
                                            $discounted = $magazines->price - $magazines->promo->discount;
                                        }
                                        $discounted = max(0, $discounted);
                                    } else {
                                        $discounted = $magazines->price;
                                    }
                                @endphp

                                <span id="totalPrice">
                                    Rp{{ number_format($discounted, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>

                        {{-- Status Pembelian User --}}
                        @php
                            $hasPurchased = false;
                            $isLoggedIn = auth()->check();

                            if ($isLoggedIn) {
                                $hasPurchased = \App\Models\Order::where('user_id', auth()->id())
                                    ->where('magazine_id', $magazines->id)
                                    ->exists();
                            }
                        @endphp

                        @if($isLoggedIn)
                        <tr>
                            <td><b class="text-secondary">Status Anda</b></td>
                            <td class="px-3"></td>
                            <td>
                                @if($hasPurchased)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Sudah Dibeli
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-shopping-cart"></i> Belum Dibeli
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endif

                        <tr>
                            <td><b class="text-secondary">Status</b></td>
                            <td class="px-3"></td>
                            <td>
                                @if ($magazines->actived)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="mt-4">
                <h5>Deskripsi</h5>
                <p>{{ $magazines->description }}</p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="w-100 p-2 bg-light text-center fixed-bottom">
                @if(!$isLoggedIn)
                    {{-- User belum login -- tombol beli langsung arahkan ke login --}}
                    <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-cart"></i> BELI MAJALAH
                    </a>
                @elseif($hasPurchased)
                    {{-- User sudah membeli --}}
                    <div class="d-flex justify-content-center gap-3">
                        @if($magazines->file_path)
                        <a href="{{ asset('storage/' . $magazines->file_path) }}"
                           class="btn btn-success btn-lg"
                           download="{{ $magazines->title }}.pdf">
                            <i class="fas fa-download"></i> Unduh Majalah
                        </a>
                        @else
                        <button class="btn btn-success btn-lg" disabled>
                            <i class="fas fa-check-circle"></i> Sudah Dibeli
                        </button>
                        @endif
                        <a href="{{ route('magazines.purchased') }}" class="btn btn-info btn-lg">
                            <i class="fas fa-book"></i> Lihat Koleksi Saya
                        </a>
                    </div>
                @else
                    {{-- User belum membeli -- tampilkan tombol beli --}}
                    <a href="javascript:void(0)" onclick="createOrder()" id="btnOrder" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-cart"></i> BELI MAJALAH
                    </a>
                @endif
            </div>

            @if($isLoggedIn && !$hasPurchased)
            <input type="hidden" id="user_id" value="{{ auth()->id() }}">
            <input type="hidden" id="magazine_id" value="{{ $magazines->id }}">
            <input type="hidden" id="price" value="{{ $discounted }}">
            @endif
        </div>
    </div>
@endsection

@if($isLoggedIn && !$hasPurchased)
@push('script')
    <script>
        function createOrder() {
            let data = {
                user_id: $("#user_id").val(),
                magazine_id: $("#magazine_id").val(),
                cart_id: null,
                quantity: 1,
                total_price: $("#price").val(),
                purchase_history: "Pembelian Majalah: {{ $magazines->title }}",
                payment: "pending",
                _token: "{{ csrf_token() }}"
            };

           $.ajax({
                url: "/orders",
                method: "POST",
                data: data,
                success: function(response) {
                    if(response.success && response.data) {
                        let orderId = response.data.id;
                        window.location.href = `/orders/${orderId}/payment`;
                    } else {
                        alert('Gagal membuat pesanan majalah!');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Terjadi kesalahan! Silakan coba lagi.');
                }
            });
        }
    </script>
@endpush
@endif
