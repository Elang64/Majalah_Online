@extends('templates.app')

@section('content')
    <div class="container-main mt-5">
        <!-- Success Alert -->
        @if (Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert"
                style="border-radius: 12px; border: none; box-shadow: var(--card-shadow);">
                <i class="fas fa-check-circle me-2"></i>
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Error Alert -->
        @if (Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                style="border-radius: 12px; border: none; box-shadow: var(--card-shadow);">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="header-content">
                    <h1 class="h1 mb-2 fw-bold">Data Promo</h1>
                    <p class="mb-0 opacity-90 fs-5">Kelola Promo dengan efisien</p>
                </div>
                <div class="action-buttons d-flex flex-wrap gap-2 mt-3 mt-md-0">
                    <a href="{{ route('admin.promos.export') }}" class="btn btn-success">
                        <i class="fas fa-file-excel me-2"></i>Export (.xlsx)
                    </a>
                    <a href="{{ route('admin.promos.trash') }}" class="btn btn-info">
                        <i class="fas fa-trash-restore me-2"></i>Data Sampah
                    </a>
                    <a href="{{ route('admin.promos.create') }}" class="btn btn-primary ">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Promo
                    </a>
                </div>
            </div>
        </div>

        <table class="table table-bordered ">
            {{-- jika ingin seperti sebelumnya hapus class di tr nya --}}
            <tr class="text-center">
                <thead>
                    <th class="fw-bold text-center">No</th>
                    <th class="fw-bold text-center">Kode Promo</th>
                    <th class="fw-bold text-center">Total Potongan</th>
                    <th class="fw-bold text-center">Aksi</th>
                </thead>
            </tr>
            @foreach ($promos as $index => $item)
                <tr>
                    <th class="text-center">{{ $index + 1 }}</th>
                    <th>
                        <small class="badge-warning badge mt-1 d-inline-block">
                            <i class="fas fa-tag me-1"></i> {{ $item['promo_code'] }}
                        </small>
                    </th>
                    <th>
                        @if ($item['type'] == 'percent')
                            {{ $item['discount'] }}%
                        @else
                            Rp {{ number_format($item['discount'], 0, ',', '.') }}
                        @endif
                    </th>
                    {{-- tipe dan jumlah potongan disatukan pake if kayaknya --}}
                    {{-- jika ingin tombol seperti yang awal, hapus justify-content-center di classnya dan class di tombol edit --}}
                    <th class="d-flex justify-content-center">
                        {{-- ['id' => $item['id']] : mengirim $item['id'] ke route {id} --}}
                        <a href="{{ route('admin.promos.edit', ['id' => $item['id']]) }}"
                            class="btn btn-warning mx-2"> <i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.promos.delete', ['id' => $item['id']]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"> <i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </th>
                </tr>
            @endforeach
        </table>
    </div>

    <style>
        .btn {
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .badge-warning {
            background: rgba(255, 193, 7, 0.1);
            color: #856404;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }
    </style>
@endsection
