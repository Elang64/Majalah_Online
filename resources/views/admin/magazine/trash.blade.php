@extends('templates.app')

@section('content')
    <div class="container-main mt-4">

        {{-- Alert Success --}}
        @if (Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ Session::get('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Header --}}
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                     <h4>Data Sampah Majalah</h4>
                      <p class="mb-0 opacity-75">Kelola data sampah majalah</p>
                </div>

                <div>
                     <a href="{{ route('admin.magazines.index') }}" class="btn btn-secondary btn-sm">
                   <i class="fas fa-arrow-left"></i> Kembali
                </a>
                </div>
            </div>
        </div>


        {{-- Table --}}
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0 text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Cover</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tahun</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($magazineTrash as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $item->cover) }}" width="60" class="rounded">
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->category }}</td>
                                <td>{{ $item->publication_year }}</td>
                                <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $item->actived ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->actived ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.magazines.restore', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-success btn-rounded">
                                         <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.magazines.delete_permanent', $item->id) }}"
                                        method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">
                                          <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
