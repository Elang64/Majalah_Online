@extends('templates.app')

@section('content')
    <div class="container-main mt-5">
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif



        <div class="page-header">
            <div class="d-flex justify-content-between">
                <h1 class="h1 fw-bold ">Data Pengguna Admin </h1>

                <div>
                    <a href="{{ route('admin.users.export') }}" class="btn btn-success me-2"> <i class="fas fa-file-excel me-2"></i>Export (.xlsx)</a>
                    <a href="{{ route('admin.users.trash') }}" class="btn btn-info me-2"><i class="fas fa-trash-restore me-2"></i>Data Sampah</a>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle me-2"></i>Tambah Data</a>
                </div>
            </div>
        </div>

        <table class="table table-bordered">
            <tr class="text-center">
                <thead class="text-center">
                    <th class="fw-bold">No</th>
                    <th class="fw-bold">Nama</th>
                    <th class="fw-bold">Email</th>
                    <th class="fw-bold">Role</th>
                    <th class="fw-bold">Aksi</th>
                </thead>
            </tr>
            @foreach ($users as $index => $item)
                <tr>
                    <th class="text-center">{{ $index + 1 }}</th>
                    <th>{{ $item['name'] }}</th>
                    <th>{{ $item['email'] }}</th>
                    <th class="fw-bold text-center" style="font-size: 0.655rem;">
                        @if ($item['role'] == 'admin')
                            <span class="alert alert-primary  py-1 px-2 m-0 d-inline-block">admin</span>
                        @endif
                    </th>

                    <th class="d-flex justify-content-center">
                        {{-- ['id' => $item['id']] : mengirim $item['id'] ke route {id} --}}
                        <a href="{{ route('admin.users.edit', ['id' => $item['id']]) }}"
                            class="btn btn-warning mx-2"> <i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.users.delete', ['id' => $item['id']]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"> <i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </th>
                </tr>
            @endforeach
        </table>
    </div>
    </div>

    <style>
        .btn {
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
    </style>
@endsection
