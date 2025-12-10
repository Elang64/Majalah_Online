@extends('templates.app')

@section('content')
    <div class="container mt-5">
         <!-- Success Alert -->
    @if (Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; box-shadow: var(--card-shadow);">
            <i class="fas fa-check-circle me-2"></i>
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Error Alert -->
    @if (Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; box-shadow: var(--card-shadow);">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
        <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="header-content">
                <h1 class="h2 mb-2 fw-bold">Data Majalah</h1>
                <p class="mb-0 opacity-90 fs-5">Kelola koleksi majalah digital Anda dengan mudah dan efisien</p>
            </div>
            <div class="action-buttons d-flex flex-wrap gap-2 mt-3 mt-md-0">
                <a href="{{ route('admin.promos.export') }}" class="btn btn-light">
                    <i class="fas fa-file-export me-2"></i>Export Excel
                </a>
                <a href="{{ route('admin.promos.trash') }}" class="btn btn-info">
                    <i class="fas fa-trash-restore me-2"></i>Data Sampah
                </a>
                <a href="{{ route('admin.promos.create') }}" class="btn btn-warning text-white fw-bold">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Promo
                </a>
            </div>
        </div>
    </div>

        <table class="table table-bordered ">
            {{-- jika ingin seperti sebelumnya hapus class di tr nya --}}
            <tr class="text-center">
                <th>No</th>
                <th>Kode Promo</th>
                <th>Total Potongan</th>
                <th>Aksi</th>
            </tr>
            @foreach ($promos as $index => $item)
                <tr>
                    <th class="text-center">{{ $index + 1 }}</th>
                    <th>{{ $item['promo_code'] }}</th>
                    <th>
                        @if ($item['type'] == 'percent')
                            {{ $item['discount'] }}%
                        @else
                            Rp {{ number_format($item['discount'], 0, ',', '.') }}
                        @endif
                    </th>
                    {{-- tipe dan jumlah potongan disatukan pake if kayaknya --}}
                    {{-- jika ingin tombol seperti yang awal, hapus justify-content-center di classnya dan class di tombol edit --}}
                    <th class="d-flex">
                        {{-- ['id' => $item['id']] : mengirim $item['id'] ke route {id} --}}
                        <a href="{{ route('admin.promos.edit', ['id' => $item['id']]) }}"
                            class="btn btn-primary mx-2">Edit</a>
                        <form action="{{route('admin.promos.delete', ['id' => $item['id']])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </th>
                </tr>
            @endforeach
        </table>
    </div>
@endsection

