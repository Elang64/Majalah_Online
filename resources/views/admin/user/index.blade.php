@extends('templates.app')

@section('content')
    <div class="container mt-5">
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.users.export') }}" class="btn btn-secondary me-2">Export (.xlsx)</a>
            <a href="{{route('admin.users.trash')}}" class="btn btn-outline-secondary me-2">Data Sampah</a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">Tambah Data</a>
        </div>
        <h5 class="mt-3">Data Pengguna (Admin & Staff)</h5>
        <table class="table table-bordered">
            <tr class="text-center">
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
            @foreach ($users as $index => $item)
                <tr>
                    <th class="text-center">{{ $index + 1 }}</th>
                    <th>{{ $item['name'] }}</th>
                    <th>{{ $item['email'] }}</th>
                    <th class="fw-bold" style="font-size: 0.655rem;">
                        @if ($item['role'] == 'admin')
                            <span class="alert alert-primary  py-1 px-2 m-0 d-inline-block">admin</span>
                        @elseif($item['role'] == 'staff')
                            <span class="alert alert-success  py-1 px-2 m-0 d-inline-block">staff</span>
                        @endif
                    </th>

                    <th class="d-flex justify-content-center">
                        {{-- ['id' => $item['id']] : mengirim $item['id'] ke route {id} --}}
                        <a href="{{ route('admin.users.edit', ['id' => $item['id']]) }}" class="btn btn-info mx-2">Edit</a>
                        <form action="{{ route('admin.users.delete', ['id' => $item['id']]) }}" method="POST">
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
